@extends('layouts.user')
@section('styles')
    <style>
        #map {
            height: 400px;
            border: 2px solid #007bff;
            /* Border color */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Shadow effect */
        }


        .list-group-item {
            cursor: pointer;
            padding: 10px;
            /* Padding for better spacing */
        }



        /* Search Address Input Styles */
        #searchAddress {
            border: 1px solid #007bff;
            /* Border color */
            border-radius: 0.25rem;
            /* Rounded corners */
            padding: 10px;
            /* Padding */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Shadow */
            transition: border-color 0.3s;
            /* Smooth transition */
        }

        #searchAddress:focus {
            border-color: #0056b3;
            /* Darker border on focus */
            outline: none;
            /* Remove outline */
        }

        /* Pop-up styles for the marker */


        .leaflet-popup .fas {
            color: #007bff;
            /* Icon color */
        }
    </style>
@endsection
@section('content')
    <div class="card my-5">
        <h5 class="card-header">Submit a Report</h5>
        <div class="card-body">

            <form method="POST" action="{{ route('user.reports.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Incident Type</label>
                    <select name="incident_type_id" class="form-select" required>
                        @foreach (App\Models\IncidentType::all() as $incident)
                            <option value="{{ $incident->id }}">{{ $incident->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Contact Number Selection -->
                <div class="mb-3">
                    <label class="form-label">Contact Number:</label>

                    @php
                        $user = auth()->user();
                        $savedContact = $user->contacts->first()->contact_number ?? null; // Get first saved contact number
                    @endphp

                    <!-- Hidden input to detect if checkbox was unchecked -->
                    <input type="hidden" name="use_saved_number" value="0">

                    <!-- Checkbox for using saved contact number -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="use_saved_number" id="use_saved_number"
                            value="1" {{ $savedContact ? '' : 'disabled' }}>
                        <label class="form-check-label" for="use_saved_number">
                            Use my saved number: <strong>{{ $savedContact ?? 'No number saved' }}</strong>
                        </label>
                    </div>


                    <!-- Manual input field -->
                    <div class="input-group mt-2">

                        <input type="text" name="contact_number" id="contact_number" class="form-control"
                            value="{{ old('contact_number') }}" pattern="\d{11}" maxlength="11"
                            placeholder="Enter 11-digit number (e.g., 09123456789)">
                    </div>

                    @error('contact_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Attachments (Optional)</label>
                    <input type="file" name="report_attachments[]" class="form-control" multiple>
                </div>

                <div class="mb-3">
                    <label for="map" class="form-label">Location</label>
                    <input type="text" id="searchAddress" class="form-control" placeholder="Search for an address..."
                        style="width: 100%;">
                    <div id="suggestions" class="list-group" style="display: none; max-height: 200px; overflow-y: auto;">
                    </div>
                </div>

                <!-- Hidden Inputs -->
                <input type="hidden" name="address" id="address">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <!-- Map Container -->
                <div class="mb-3">
                    <div id="map" style="height: 300px;"></div>
                </div>

                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize map
            var map = L.map('map').setView([18.3515316, 121.6489289], 16);

            // Add MapTiler tile layer
            L.tileLayer(
                'https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=nnLs4mWhpJaZMAiwkL9K', {
                    tileSize: 512,
                    zoomOffset: -1,
                    minZoom: 1,
                    attribution: '&copy; <a href="https://www.maptiler.com/copyright/">MapTiler</a> | ' +
                        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Contributors',
                    crossOrigin: true
                }).addTo(map);

            // Custom icon for markers
            var redMarkerIcon = L.icon({
                iconUrl: '{{ asset('asset/image/leaflet/marker-icon-red.png') }}',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowUrl: '{{ asset('asset/image/leaflet/marker-shadow.png') }}',
                shadowSize: [41, 41]
            });

            // Define the marker variable without initializing it
            var marker;

            // Set default address and marker position on load
            var defaultAddress =
                'Cagayan State University, Aparri, Maura, Cagayan, Cagayan Valley, 3515, Philippines';
            var defaultLat = 18.3515316;
            var defaultLng = 121.6489289;

            // Display default marker and address if not set
            marker = L.marker([defaultLat, defaultLng], {
                    icon: redMarkerIcon
                }).addTo(map).bindPopup(createPopupMessage(defaultAddress, defaultLat, defaultLng))
                .openPopup();

            $('#address').val(defaultAddress);
            $('#latitude').val(defaultLat);
            $('#longitude').val(defaultLng);

            // Rate limiting for AJAX requests
            var lastRequestTime = 0;
            var requestDelay = 500; // milliseconds

            // Handle address search and suggestions
            $('#searchAddress').on('input', function() {
                var query = $(this).val();
                if (query.length > 2) {
                    var currentTime = new Date().getTime();
                    if (currentTime - lastRequestTime >= requestDelay) {
                        lastRequestTime = currentTime; // Update the time of the last request

                        $.ajax({
                            url: 'https://nominatim.openstreetmap.org/search',
                            data: {
                                q: query,
                                format: 'json',
                                addressdetails: 1,
                                limit: 5
                            },
                            success: function(data) {
                                $('#suggestions').empty();
                                if (data.length > 0) {
                                    data.forEach(function(item) {
                                        $('#suggestions').append(
                                            '<div class="list-group-item" data-lat="' +
                                            item.lat + '" data-lng="' +
                                            item.lon +
                                            '">' + item.display_name +
                                            '</div>'
                                        );
                                    });
                                    $('#suggestions').show();
                                } else {
                                    $('#suggestions').hide();
                                }
                            }
                        });
                    }
                } else {
                    $('#suggestions').hide();
                }
            });

            // Handle suggestion click
            $(document).on('click', '.list-group-item', function() {
                var lat = $(this).data('lat');
                var lng = $(this).data('lng');

                // If a marker exists, remove it before adding a new one
                if (marker) {
                    map.removeLayer(marker);
                }

                // Create a new marker at the selected location
                marker = L.marker([lat, lng], {
                        icon: redMarkerIcon
                    }).addTo(map).bindPopup(createPopupMessage($(this).text(), lat, lng))
                    .openPopup();

                // Set the map view to the new location
                map.setView([lat, lng], 16);

                // Update the search input and other fields
                $('#searchAddress').val($(this).text());
                $('#address').val($(this).text());
                $('#latitude').val(lat);
                $('#longitude').val(lng);

                $('#suggestions').hide(); // Hide suggestions
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#searchAddress').length) {
                    $('#suggestions').hide();
                }
            });

            // Handle map click event
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // If a marker exists, remove it before adding a new one
                if (marker) {
                    map.removeLayer(marker);
                }

                // Create a new marker at the clicked location
                marker = L.marker([lat, lng], {
                    icon: redMarkerIcon
                }).addTo(map);

                // Reverse geocode to get the address
                $.ajax({
                    url: 'https://nominatim.openstreetmap.org/reverse',
                    data: {
                        lat: lat,
                        lon: lng,
                        format: 'json'
                    },
                    success: function(data) {
                        if (data && data.display_name) {
                            var address = data.display_name;

                            // Update fields and bind a popup with the address and coordinates
                            $('#searchAddress').val(address);
                            $('#address').val(address);
                            $('#latitude').val(lat);
                            $('#longitude').val(lng);

                            marker.bindPopup(createPopupMessage(address, lat, lng))
                                .openPopup();
                        }
                    }
                });
            });

            // Function to create a popup message with icons for address and coordinates
            function createPopupMessage(address, lat, lng) {
                var addressIcon = '<i class="fas fa-map-marker-alt"></i>';
                var coordinatesIcon = '<i class="fas fa-map"></i>';
                return `<div>${addressIcon} Address: ${address}</div>
                <div>${coordinatesIcon} Coordinates: ${lat.toFixed(5)}, ${lng.toFixed(5)}</div>`;
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkbox = document.getElementById('use_saved_number');
            const contactInput = document.getElementById('contact_number');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    contactInput.value = ''; // Clear input field
                    contactInput.setAttribute('disabled', 'disabled'); // Disable input
                } else {
                    contactInput.removeAttribute('disabled'); // Enable input
                }
            });

            contactInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    checkbox.checked = false;
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const contactInput = document.getElementById("contact_number");

            contactInput.addEventListener("input", function(e) {
                // Remove non-numeric characters
                this.value = this.value.replace(/\D/g, "");

                // Limit input to exactly 10 digits
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        });
    </script>
@endsection
