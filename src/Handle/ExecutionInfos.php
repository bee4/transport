<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Handle
 */

namespace Bee4\Transport\Handle;

/**
 * Handle execution informations implementation
 * @package Bee4\Transport\Handle
 * @method ExecutionInfos status(integer $status)      Set the execution status
 * @method ExecutionInfos headers(array $headers)      Set headers
 * @method ExecutionInfos effectiveUrl(string $url)    Effective URL for the request
 * @method ExecutionInfos transactionTime(float $time) Total request process duration in second
 * @method ExecutionInfos contentType(string $type)    Content-Type header for the request
 */
class ExecutionInfos
{
    /**
     * Handle used to perform the execution
     */
    private $handle;

    /**
     * Execution status code
     * @var integer
     */
    private $status;

    /**
     * Header collection
     * @var string
     */
    private $headers;

    /**
     * Effective URL
     * @var string
     */
    private $effectiveUrl;

    /**
     * Transaction time
     * @var float
     */
    private $transactionTime;

    /**
     * Content type for the request
     * @var string
     */
    private $contentType;

    /**
     * Build an ExecutioInfos instance
     * @param HandleInterface $handle
     */
    public function __construct(
        HandleInterface $handle,
        callable $resolver = null
    ) {
        $this->handle = $handle;
    }

    /**
     * Retrieve current handle
     * @return HandleInterface
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Retrieve a property value
     * @param  string $name Property name
     * @return mixed
     */
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \BadMethodCallException('Invalid property name: '.$name);
        }

        if (null === $this->$name && isset($this->resolver)) {
            $this->$name = call_user_func($this->resolver, $name);
        }

        return $this->$name;
    }

    /**
     * Set a property
     * @param  string $name
     * @param  array  $arguments
     * @return ExecutionInfos
     */
    public function __call($name, array $arguments)
    {
        //Define getter and setter for each valid property
        if (property_exists($this, $name) && count($arguments) == 1) {
            $this->$name = $arguments[0];
            return $this;
        } else {
            throw new \BadMethodCallException('Invalid method: '.$name);
        }
    }
}
