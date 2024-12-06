@extends('layouts.app')

@section('title', 'Shorten URL')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Shorten a URL</h2>
        
        <form action="{{ route('urls.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="original_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Original URL
                </label>
                <input 
                    type="url" 
                    id="original_url" 
                    name="original_url" 
                    value="{{ old('original_url') }}"
                    placeholder="https://example.com/very-long-url"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>
            
            <div class="mb-6">
                <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                    Expiration Date (Optional)
                </label>
                <input 
                    type="datetime-local" 
                    id="expires_at" 
                    name="expires_at" 
                    value="{{ old('expires_at') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <p class="text-sm text-gray-600 mt-1">Leave empty for permanent links</p>
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Shorten URL
            </button>
        </form>
    </div>
</div>
@endsection