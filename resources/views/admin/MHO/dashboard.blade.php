@extends('layouts.mho')

@section('content')
    <div class="container">
        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3 my-2">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Reports</h5>
                        <h2>{{ $totalReports }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Ongoing Reports</h5>
                        <h2>{{ $ongoingReports }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5>Pending Reports</h5>
                        <h2>{{ $pendingReports }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 my-2">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Completed Reports</h5>
                        <h2>{{ $completedReports }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
