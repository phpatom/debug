<?php


namespace Atom\Debug\Listeners;

use Atom\Event\AbstractEventListener;
use Atom\Web\Events\MiddlewareLoaded;
use Atom\Debug\Collectors\MiddlewareCollector;

class MiddlewareLoadedListener extends AbstractEventListener
{
    /**
     * @var MiddlewareCollector
     */
    private $collector;

    public function __construct(MiddlewareCollector $collector)
    {
        $this->collector = $collector;
    }

    public function on($event): void
    {
        /**
         * @var $event MiddlewareLoaded
         */
        $this->collector->addMiddleware($event->getRelatedMiddleware());
    }
}
