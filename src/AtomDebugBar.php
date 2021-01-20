<?php


namespace Atom\Debug;

use Atom\DI\Exceptions\CircularDependencyException;
use Atom\DI\Exceptions\ContainerException;
use Atom\DI\Exceptions\NotFoundException;
use Atom\DI\Exceptions\StorageNotFoundException;
use Atom\Event\Exceptions\ListenerAlreadyAttachedToEvent;
use Atom\Web\Events\MiddlewareLoaded;
use Atom\Debug\Collectors\MiddlewareCollector;
use Atom\Debug\Listeners\MiddlewareLoadedListener;
use Atom\Web\Application;
use DebugBar\DebugBarException;
use DebugBar\StandardDebugBar;

class AtomDebugBar extends StandardDebugBar
{
    /**
     * AtomDebugBar constructor.
     * @param Application $app
     * @throws DebugBarException
     * @throws CircularDependencyException
     * @throws ContainerException
     * @throws NotFoundException
     * @throws StorageNotFoundException
     * @throws ListenerAlreadyAttachedToEvent
     */
    public function __construct(Application $app)
    {
        parent::__construct();

        $middlewareCollector = new MiddlewareCollector();
        $this->addCollector($middlewareCollector);
        $app->eventDispatcher()
            ->addEventListener(
                MiddlewareLoaded::class,
                new MiddlewareLoadedListener($middlewareCollector)
            );
    }
}
