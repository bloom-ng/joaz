@extends('layouts.admin-layout')

@section('content')
    <div class="w-full">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Newsletter Subscribers</h1>
                <div class="flex flex-col sm:flex-row gap-4">
                    <form action="{{ route('admin.newsletters.index') }}" method="GET" class="flex-grow">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by email..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('admin.newsletters.index') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                    <a href="{{ route('admin.newsletters.export') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 whitespace-nowrap flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export CSV
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">Subscribed At</th>
                            <th class="py-3 px-4 text-right text-sm font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($subscribers as $subscriber)
                            <tr>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $subscriber->email }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $subscriber->is_subscribed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $subscriber->is_subscribed ? 'Subscribed' : 'Unsubscribed' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-700">{{ $subscriber->created_at->format('M d, Y') }}</td>
                                <td class="py-4 px-4 text-sm text-right">
                                    <form action="{{ route('admin.newsletters.destroy', $subscriber->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this subscriber?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">No subscribers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $subscribers->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
