<?php

namespace Inovector\Mixpost\Actions;

use Inovector\Mixpost\Models\Account;
use Inovector\Mixpost\Models\Post;

class PublishPost
{
    public function __invoke(Post $post): void
    {
        if ($post->isInHistory()) {
            return;
        }

        $post->setPublished();

        foreach ($post->accounts as $account) {
            $this->publishToAccount($account, $post);
        }
    }

    protected function publishToAccount(Account $account, Post $post): void
    {
        if (! $account->isServiceActive()) {
            $post->insertErrors($account, ['Service disabled']);

            return;
        }

        if ($account->isUnauthorized()) {
            $post->insertErrors($account, ['Access token expired']);

            return;
        }

        $accountPublishPost = new AccountPublishPost();
        $response = $accountPublishPost($account, $post);

        if ($response->isUnauthorized()) {
            $account->setUnauthorized();
            $post->insertErrors($account, ['Access token expired']);

            return;
        }

        if ($response->hasError()) {
            $post->insertErrors($account, $response->context());

            return;
        }

        $post->insertProviderData($account, $response);
    }
}
