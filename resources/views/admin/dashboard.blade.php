@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Blocks</h5>
                                    <p class="card-text display-4">{{ $stats['total_blocks'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Rooms</h5>
                                    <p class="card-text display-4">{{ $stats['total_rooms'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Total Allocations</h5>
                                    <p class="card-text display-4">{{ $stats['total_allocations'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Requests</h5>
                                    <p class="card-text display-4">{{ $stats['pending_requests'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Blocks</h5>
                                    <p class="card-text">Add, edit, or remove hostel blocks.</p>
                                    <a href="{{ route('admin.blocks.index') }}" class="btn btn-primary">Manage Blocks</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Rooms</h5>
                                    <p class="card-text">Add, edit, or remove rooms in blocks.</p>
                                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Manage Rooms</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Allocations</h5>
                                    <p class="card-text">View and manage room allocations.</p>
                                    <a href="{{ route('admin.allocations.index') }}" class="btn btn-primary">Manage Allocations</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Manage Requests</h5>
                                    <p class="card-text">Review and process pending room requests.</p>
                                    <a href="{{ route('admin.requests.index') }}" class="btn btn-warning">Manage Requests</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
