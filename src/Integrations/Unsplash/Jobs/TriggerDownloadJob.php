<?php

namespace Inovector\Mixpost\Integrations\Unsplash\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Inovector\Mixpost\Integrations\Unsplash\Unsplash;

class TriggerDownloadJob
{
    use Dispatchable;

    public function __construct(public readonly string $downloadLocation) {}

    public function handle(Unsplash $unsplash): void
    {
        $unsplash->downloadPhoto($this->downloadLocation);
    }
}
