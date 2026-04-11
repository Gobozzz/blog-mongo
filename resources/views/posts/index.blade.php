<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }} |
            <a class="text-blue-500 underline" href="{{route('posts.create')}}">Create new post</a> |
            <a class="text-blue-500 underline" href="{{route('posts.my')}}">My Posts</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 overflow-hidden shadow-sm sm:rounded-lg">
                <x-posts.filters :action="route('posts.index')" :tags="$tags"/>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($posts as $post)
                        <x-posts.post-card :post="$post"/>
                    @endforeach
                </div>
                <div class="my-5">
                    {{$posts->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
