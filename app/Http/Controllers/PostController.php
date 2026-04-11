<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Models\Post;
use App\Repositories\Post\PostRepositoryContract;
use App\Repositories\Tag\TagRepositoryContract;
use App\Services\Post\PostServiceContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryContract $postRepository,
        private readonly TagRepositoryContract $tagRepository,
        private readonly PostServiceContract $postService,
    ) {}

    public function index(Request $request): View
    {
        $posts = $this->postRepository->paginate(filtersData: $request->query());
        $tags = $this->tagRepository->all();

        return view('posts.index', compact('posts', 'tags'));
    }

    public function create(): View
    {
        $tags = $this->tagRepository->all();

        return view('posts.create', compact('tags'));
    }

    public function store(PostStoreRequest $request): RedirectResponse
    {
        $data = $request->getDTO();

        $this->postService->create($data);

        return redirect()->route('posts.index');
    }

    public function myPosts(Request $request): View
    {
        $posts = $this->postRepository->getByUser(userId: $request->user()->getKey(), filtersData: $request->query());
        $tags = $this->tagRepository->all();

        return view('posts.my', compact('posts', 'tags'));
    }

    public function show(Post $post)
    {
        dd($post->title);
    }
}
