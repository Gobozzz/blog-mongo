@props([
    'action' => '#',
    'tags' => [],
])

<form method="GET" action="{{ $action }}" class="my-4 space-y-4">
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
                           @if(is_array(request('f_tag')) && in_array($tag->slug, request('f_tag'))) checked @endif
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
                onclick="window.location.href='{{ $action }}'"
                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">
            Сбросить фильтры
        </button>
    </div>
</form>
