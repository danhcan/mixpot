<?php

namespace Inovector\Mixpost;

use Inovector\Mixpost\Abstracts\SocialProviderManager as SocialProviderManagerAbstract;
use Inovector\Mixpost\Facades\ServiceManager;
use Inovector\Mixpost\SocialProviders\Meta\FacebookPageProvider;

class SocialProviderManager extends SocialProviderManagerAbstract
{
    protected array $providers = [];

    public function providers(): array
    {
        if (! empty($this->providers)) {
            return $this->providers;
        }

        return $this->providers = [
            'facebook_page' => FacebookPageProvider::class,
        ];
    }

    protected function connectFacebookPageProvider()
    {
        $config = ServiceManager::get('facebook', 'configuration');

        $config['redirect'] = route('mixpost.callbackSocialProvider', ['provider' => 'facebook_page']);

        return $this->buildConnectionProvider(FacebookPageProvider::class, $config);
    }
}
