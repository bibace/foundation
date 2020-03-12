<?php 

namespace Bibace\Foundation\Providers;

use Symfony\Component\HttpFoundation\Request;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RequestServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple) 
    {
        $pimple['request'] = function($app) {
            return Request::createFromGlobals();
        };
    }
}