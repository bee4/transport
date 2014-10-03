<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Events
 */

namespace Bee4\Transport\Events;

use Bee4\Events\EventInterface;
use Bee4\Transport\Message\MessageInterface;

/**
 * Wrap message events
 * @package Bee4\Transport\Events
 */
class MessageEvent implements EventInterface
{
    const REQUEST = 'message.request';
    const RESPONSE = 'message.response';

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @param MessageInterface $message
     */
    public function __construct(MessageInterface $message) {
        $this->message = $message;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage() {
        return $this->message;
    }
} 