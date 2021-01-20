<?php


namespace Atom\Debug;

use Atom\Kernel\Kernel;
use Atom\Kernel\Contracts\ServiceProviderContract;
use Atom\DI\Exceptions\CircularDependencyException;
use Atom\DI\Exceptions\ContainerException;
use Atom\DI\Exceptions\NotFoundException;
use Atom\DI\Exceptions\StorageNotFoundException;
use Atom\Web\Exceptions\RequestHandlerException;
use Atom\Web\Application;
use InvalidArgumentException;

class DebugBar implements ServiceProviderContract
{
    /**
     * @param Kernel $app
     * @throws CircularDependencyException
     * @throws ContainerException
     * @throws NotFoundException
     * @throws StorageNotFoundException
     * @throws RequestHandlerException
     */
    public function register(Kernel $app)
    {
        if (!$app->env()->isDev() && !($app->env()->get("APP_DEBUG"))) {
            return;
        }
        if (!($app instanceof Application)) {
            throw new InvalidArgumentException("Debug bar can only be use with Application");
        }
        $debugBar = $app->container()->get(AtomDebugBar::class);
        $app->container()->singletons()->bindInstance($debugBar);
        $app->requestHandler()->add(DebugBarAssetMiddleware::class);
        $app->requestHandler()->add(DebugBarMiddleware::class);
    }
}
