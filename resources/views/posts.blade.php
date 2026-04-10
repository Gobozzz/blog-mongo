<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 overflow-hidden shadow-sm sm:rounded-lg">

                <form method="GET" action="{{ route('posts.index') }}" class="my-4 space-y-4">
                    <div>
                        <label for="f_search" class="block text-sm font-medium text-gray-700 mb-1">Поиск</label>
                        <input type="text"
                               name="f_search"
                               id="f_search"
                               value="{{ request('f_search') }}"
                               placeholder="Введите поисковый запрос..."
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">Теги</span>
                        <div class="space-y-2">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center">
                                    <input type="checkbox"
                                           name="f_tag[]"
                                           value="{{ $tag->slug }}"
                                           @if(is_array(request('f_tag')) && in_array($tag->slug, request('f_tag'))) checked
                                           @endif
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Применить фильтры
                        </button>

                        <button type="reset"
                                onclick="window.location.href='{{ route('posts.index') }}'"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">
                            Сбросить фильтры
                        </button>
                    </div>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($posts as $post)
                        <article
                            class="bg-white rounded-xl shadow-md p-2 hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <time datetime="2024-03-15">{{$post->created_at->format('Y.m.d')}}</time>
                                    <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{$post->user->name}}
                </span>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
                                    <a href="#">{{$post->title}}</a>
                                </h2>

                                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                    {{$post->content}}
                                </p>

                                <div class="flex flex-wrap gap-2 mt-auto">
                                    @foreach($post->tags as $tag)
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-md">#{{$tag->name}}</span>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="my-5">
                    {{$posts->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
