@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">Here's your current hostel status</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Room Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Room Status</h2>
                                <p class="text-sm text-gray-500">Your current room allocation</p>
                            </div>
                        </div>

                        @if(auth()->user()->room_allocation)
                            <div class="space-y-4">
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Room Number</p>
                                    <p class="text-base font-semibold text-gray-900">{{ auth()->user()->room_allocation->room->room_number }}</p>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Block</p>
                                    <p class="text-base font-semibold text-gray-900">{{ auth()->user()->room_allocation->room->block->name }}</p>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Allocated Date</p>
                                    <p class="text-base font-semibold text-gray-900">{{ auth()->user()->room_allocation->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <h3 class="mt-3 text-lg font-medium text-gray-900">No room allocated</h3>
                                <p class="mt-1 text-sm text-gray-500">You haven't been allocated a room yet.</p>
                                <div class="mt-4">
                                    <a href="{{ route('student.requests.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Request Room
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Room Request Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Request Status</h2>
                                <p class="text-sm text-gray-500">Your current room request</p>
                            </div>
                        </div>

                        @if(auth()->user()->pending_request)
                            <div class="space-y-4">
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="text-base font-semibold text-gray-900">{{ ucfirst(auth()->user()->pending_request->status) }}</p>
                                </div>

                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-500">Submitted</p>
                                    <p class="text-base font-semibold text-gray-900">{{ auth()->user()->pending_request->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <h3 class="mt-3 text-lg font-medium text-gray-900">No pending requests</h3>
                                <p class="mt-1 text-sm text-gray-500">You don't have any pending room requests.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
