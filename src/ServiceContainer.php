<?php

namespace Bibace\Foundation;

use Pimple\Container;

class ServiceContainer extends Container
{
    protected $providers = [];

    protected $userConfig = [];

    public function __construct(array $config, array $prepends=[])
    {
        $this->registerProviders($this->getProviders());

        parent::__construct($prepends);

        $this->userConfig = $config;
    }

    public function getConfig()
    {
        $base = [
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'http://www.vivide.com.au',
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
            RequestServiceProvider::class,
            HttpClientServiceProvider::class
        ], $this->providers);
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}