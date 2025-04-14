@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Room Request Details</h2>
                        <p class="text-sm text-gray-500">View your room request information</p>
                    </div>
                    <a href="{{ route('student.requests.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to List
                    </a>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Gender</p>
                            <p class="text-base font-semibold text-gray-900">{{ ucfirst($request->gender) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Duration of Stay</p>
                            <p class="text-base font-semibold text-gray-900">{{ $request->duration }} months</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="text-base font-semibold text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       ($request->status === 'approved' ? 'bg-green-100 text-green-800' :
                                       'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Request Date</p>
                            <p class="text-base font-semibold text-gray-900">{{ $request->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>

                    @if($request->status === 'pending')
                        <div class="flex justify-end">
                            <form action="{{ route('student.requests.cancel', $request) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Are you sure you want to cancel this request?')">
                                    Cancel Request
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
