@props(['post'])

<article
    class="bg-white rounded-xl shadow-md p-2 hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col h-full">
    <div class="p-5 flex flex-col flex-grow">
        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
            <time datetime="{{ $post->created_at->toIso8601String() }}">
                {{ $post->created_at->format('Y.m.d') }}
            </time>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                {{ $post->user->name }} | {{$post->getCurrentStateLabel()}}
            </span>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
        </h2>

        <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
            {{ $post->content }}
        </p>

        <div class="flex flex-wrap gap-2 mt-auto">
            @foreach($post->tags as $tag)
                <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-md">
                    #{{ $tag->name }}
                </span>
            @endforeach
        </div>
    </div>
</article>
