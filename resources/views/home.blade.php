@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div class="alert alert-info">
                                <h4>Welcome, Admin!</h4>
                                <p>You have access to the admin dashboard where you can manage rooms, blocks, and student allocations.</p>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Dashboard</a>
                            </div>
                        @elseif(auth()->user()->role === 'student')
                            <div class="alert alert-info">
                                <h4>Welcome, Student!</h4>
                                <p>You can view your room allocation and make room requests from your dashboard.</p>
                                <a href="{{ route('student.dashboard') }}" class="btn btn-primary">Go to Student Dashboard</a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
