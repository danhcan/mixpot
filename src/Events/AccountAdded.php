<?php

namespace Inovector\Mixpost\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Inovector\Mixpost\Models\Account;

class AccountAdded
{
    use Dispatchable;

    public function __construct(public readonly Account $account) {}
}
