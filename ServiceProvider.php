<?php

namespace Darinlarimore\StatamicRive;

use Statamic\Providers\AddonServiceProvider;
use Darinlarimore\StatamicRive\Fieldtypes\rive;

class ServiceProvider extends AddonServiceProvider
{
    // register assets
    protected $vite = [
        'input' => [
            'resources/js/main.js',
            'resources/css/main.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {
        // register field type
        rive::register();

        // register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rive');
    }
}
