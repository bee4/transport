<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Configuration
 */

namespace Bee4\Transport\Configuration;

/**
 * Trait to handle commands property
 * @package Bee4\Transport\Configuration
 */
trait HasCommand
{
    /**
     * Define which command must be ran with the request
     * @param mixed $command Command to be ran before actual request is performed
     * @return Configuration|mixed
     */
    public function commandsRequest($command = null)
    {
        return $this->arrayValue('commands', 'request', $command);
    }

    /**
     * Define which command must be ran after the request
     * @param mixed $command Command to be ran after actual request is performed
     * @return Configuration|mixed
     */
    public function commandsPost($command = null)
    {
        return $this->arrayValue('commands', 'post', $command);
    }

    /**
     * Allow to set an array value in the collection
     * @param  string $key      Key to retrieve the array in the collection
     * @param  string $arrayKey Array key to set
     * @param  mixed  $value    Value to be set or null
     * @return mixed
     */
    abstract protected function arrayValue($key, $arrayKey, $value = null);
}
