<?php

namespace Inovector\Mixpost\Http\Requests;

use Illuminate\Support\Facades\DB;
use Inovector\Mixpost\Enums\PostStatus;
use Inovector\Mixpost\Models\Post;
use Inovector\Mixpost\Util;

class StorePost extends PostFormRequest
{
    public function handle()
    {
        return DB::transaction(function () {
            $record = Post::create([
                'status' => PostStatus::PUBLISHED,
                'published_at' => now(),
            ]);

            $record->accounts()->attach($this->input('accounts', []));
            $record->tags()->attach($this->input('tags'));
            $record->versions()->createMany($this->input('versions'));

            return $record;
        });
    }
}
