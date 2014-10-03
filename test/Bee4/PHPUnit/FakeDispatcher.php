<?php
/**
 * This file is part of the httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2013
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\PHPUnit
 */

namespace Bee4\PHPUnit;

use Bee4\Events\DispatcherInterface;
use Bee4\Events\EventInterface;

class FakeDispatcher implements DispatcherInterface
{
    /**
     * Listener collection
     * @var array
     */
    protected $listeners = [];

    /**
     * @param string $name
     * @param EventInterface $event
     * @return EventInterface
     */
    public function dispatch($name, EventInterface $event) {
        if( isset($this->listeners[$name]) ) {
            foreach( $this->listeners[$name] as $priority ) {
                foreach( $priority as $callable ) {
                    call_user_func($callable, $event, $name, $this);
                }
            }
        }

        return $event;
    }

    /**
     * Add a listener for the given event
     * @param string $name
     * @param Callable $listener
     * @param int $priority
     * @return DispatcherInterface
     */
    public function addListener( $name, $listener, $priority = 0 ) {
        $this->listeners[$name][$priority][] = $listener;
        return $this;
    }
} 