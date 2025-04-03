@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <!-- Contact Messages Table -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Contact Messages</h5>
                <div>
                    <form action="{{ route('superadmin.contact-messages.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2"
                            placeholder="Search by name or email" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date Received</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contactMessages as $message)
                                <tr>
                                    <td data-label="Full Name">{{ $message->full_name }}</td>
                                    <td data-label="Email">{{ $message->email }}</td>
                                    <td data-label="Subject">{{ $message->subject }}</td>
                                    <td data-label="Date">{{ $message->created_at->format('F j, Y g:i A') }}</td>
                                    <td class="action-btns" data-label="Actions">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <div class="d-inline">
                                                <button type="button" class="btn btn-sm btn-primary action-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewMessageModal{{ $message->id }}">
                                                    View
                                                </button>
                                            </div>
                                            <div class="d-inline">
                                                <form
                                                    action="{{ route('superadmin.contact-messages.delete', $message->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger action-btn">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- View Message Modal -->
                                <div class="modal fade" id="viewMessageModal{{ $message->id }}" tabindex="-1"
                                    aria-labelledby="viewMessageModalLabel{{ $message->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewMessageModalLabel{{ $message->id }}">
                                                    Message Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p><strong>Name:</strong> {{ $message->full_name }}</p>
                                                        <p><strong>Email:</strong> {{ $message->email }}</p>
                                                        <p><strong>Phone:</strong> {{ $message->phone_number }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Subject:</strong> {{ $message->subject }}</p>
                                                        <p><strong>Date Received:</strong>
                                                            {{ $message->created_at->format('F j, Y g:i A') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6>Message</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                {{ $message->message }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="mailto:{{ $message->email }}" class="btn btn-primary">Reply via
                                                    Email</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No contact messages found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $contactMessages->links('pagination::bootstrap-5', ['paginator' => $contactMessages, 'elements' => [1 => $contactMessages->getUrlRange(1, $contactMessages->lastPage())], 'onEachSide' => 1]) }}
                </div>
            </div>
        </div>
    </div>
@endsection
