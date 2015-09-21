<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Events
 */

namespace Bee4\Transport\Events;

use Bee4\Events\EventInterface;

/**
 * Wrap error events
 * @package Bee4\Transport\Events
 */
class ErrorEvent implements EventInterface
{
    const ERROR = 'transport.error';

    /**
     * @var \Exception
     */
    protected $error;

    /**
     * @param \Exception $error
     */
    public function __construct(\Exception $error)
    {
        $this->error = $error;
    }

    /**
     * @return \Exception
     */
    public function getError()
    {
        return $this->error;
    }
}
