@extends('layouts.landing')

@section('title', 'Contact Us - Heroes App')

@section('content')
    <div class="container mt-5">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-danger text-white about-hero mb-5 hero-image" style="height: 400px;">
                    <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                        <h1 class="card-title fw-bold">Contact Us</h1>
                        <p class="card-text fs-5">We're here to help. Reach out to our team with any questions or concerns.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Contact Information -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Get in Touch</h3>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-danger p-3 rounded-circle text-white">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>Our Location</h5>
                                <p class="text-muted mb-0">Municipal Hall, Aparri, Cagayan</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-danger p-3 rounded-circle text-white">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>Email Us</h5>
                                <p class="text-muted mb-0">heroesapp@aparri.gov.ph</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="bg-danger p-3 rounded-circle text-white">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>Call Us</h5>
                                <p class="text-muted mb-0">09954316944 (Mayor's Office Hotline)</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-danger p-3 rounded-circle text-white">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5>Operating Hours</h5>
                                <p class="text-muted mb-0">Monday - Friday: 8:00 AM - 5:00 PM</p>
                                <p class="text-muted mb-0">Emergency services available 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">Send us a Message</h3>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                        id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5"
                                    required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger btn-lg">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div id="contact-map" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map centered on Aparri, Cagayan
            var map = L.map('contact-map').setView([18.356900923317756, 121.63710725256854], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add marker for Municipal Hall
            L.marker([18.356900923317756, 121.63710725256854]).addTo(map)
                .bindPopup('<strong>Aparri Municipal Hall</strong><br>1 De Carreon St, Aparri, 3515 Cagayan')
                .openPopup();
        });
    </script>
@endsection
