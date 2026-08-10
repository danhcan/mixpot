<?php

namespace Inovector\Mixpost\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Inovector\Mixpost\Http\Actions\PublishPost;
use Inovector\Mixpost\Http\Resources\PostResource;

class SchedulePostController extends Controller
{
    public function __invoke(Post $post): JsonResponse
    {
        $post->load('accounts', 'versions');

        if ($post->accounts()->count() === 0 || $post->versions()->count() === 0) {
            return response()->json('This post cannot be published!', 422);
        }

        (new PublishPost)($post);

        return response()->json('The post has been published.');
    }
}
