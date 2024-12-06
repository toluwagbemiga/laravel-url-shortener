@extends('layouts.app')

@section('title', 'URL Statistics')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">URL Statistics</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Short URL</label>
                <div class="flex items-center space-x-2">
                    <code class="bg-gray-100 px-3 py-2 rounded flex-1">{{ url($url->short_code) }}</code>
                    <button onclick="copyToClipboard('{{ url($url->short_code) }}')" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                        Copy
                    </button>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Original URL</label>
                <a href="{{ $url->original_url }}" target="_blank" class="text-blue-600 hover:underline break-all">
                    {{ $url->original_url }}
                </a>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Clicks</label>
                    <div class="text-3xl font-bold text-blue-600">{{ $url->clicks }}</div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                    <div class="text-lg">{{ $url->created_at->format('M j, Y g:i A') }}</div>
                </div>
            </div>
            
            @if($url->expires_at)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expires</label>
                    <div class="text-lg {{ $url->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                        {{ $url->expires_at->format('M j, Y g:i A') }}
                        @if($url->isExpired())
                            (Expired)
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <div class="mt-6 pt-6 border-t">
            <a href="{{ route('urls.index') }}" class="text-blue-600 hover:underline">
                ← Back to URLs
            </a>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Short URL copied to clipboard!');
    });
}
</script>
@endsection