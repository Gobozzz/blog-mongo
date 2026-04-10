<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\Post\PostRepositoryContract;
use App\Repositories\Tag\TagRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryContract $postRepository,
        private readonly TagRepositoryContract  $tagRepository,
    )
    {
    }

    public function index(Request $request): View
    {
        $posts = $this->postRepository->paginate(filtersData: $request->query());
        $tags = $this->tagRepository->all();

        return view('posts', compact('posts', 'tags'));
    }
}
