<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('posts.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               maxlength="255"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Максимум 255 символов</p>
                    </div>

                    <div x-data="{ content: '{{ old('content') }}', maxLength: 1000 }">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Содержание</label>
                        <textarea name="content"
                                  id="content"
                                  x-model="content"
                                  maxlength="1000"
                                  rows="6"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-500 @enderror"></textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-gray-500">Максимум 1000 символов</p>
                            <p class="text-xs font-medium"
                               :class="content.length > maxLength ? 'text-red-600' : 'text-gray-500'">
                                <span x-text="content.length"></span> / <span x-text="maxLength"></span>
                            </p>
                        </div>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-700 mb-2">Теги</span>
                        <div class="flex flex-wrap gap-3">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center">
                                    <input type="checkbox"
                                           name="tags[]"
                                           value="{{ $tag->id }}"
                                           @if(is_array(old('tags')) && in_array($tag->id, old('tags'))) checked @endif
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('tags')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Создать пост
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
