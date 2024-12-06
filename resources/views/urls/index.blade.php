@extends('layouts.app')

@section('title', 'URL Shortener - Home')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Recent URLs</h2>
        
        @if($urls->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Original URL</th>
                            <th class="px-4 py-2 text-left">Short Code</th>
                            <th class="px-4 py-2 text-left">Clicks</th>
                            <th class="px-4 py-2 text-left">Created</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urls as $url)
                            <tr class="border-b">
                                <td class="px-4 py-2">
                                    <a href="{{ $url->original_url }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ Str::limit($url->original_url, 50) }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <code class="bg-gray-100 px-2 py-1 rounded">{{ $url->short_code }}</code>
                                </td>
                                <td class="px-4 py-2">{{ $url->clicks }}</td>
                                <td class="px-4 py-2">{{ $url->created_at->format('M j, Y') }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('urls.stats', $url->short_code) }}" class="text-blue-600 hover:underline">
                                        Stats
                                    </a>
                                    <span class="mx-2">|</span>
                                    <button onclick="copyToClipboard('{{ url($url->short_code) }}')" class="text-green-600 hover:underline">
                                        Copy
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $urls->links() }}
            </div>
        @else
            <p class="text-gray-600">No URLs have been shortened yet.</p>
        @endif
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