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

use Bee4\Transport\Collection;

/**
 * Configuration implementation
 * @package Bee4\Transport\Configuration
 */
class Configuration extends Collection
{
    /**
     * Default configuration values
     */
    const DEFAULTS = [
        'allow_redirects' => [
            'max' => null,
            'referer' => true,
        ],
        'connect_timeout' => 0,
        'accept_encoding' => null,
        'user_agent' => null,
        'http_errors' => false,
        'timeout' => 30,
        'verify' => false,

        'method' => 'GET',
        'url' => null,
        'body' => null,
        'upload' => false
    ];

    /**
     * Build a configuration instance
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(array_merge(
            self::DEFAULTS,
            $data
        ));
    }

    /**
     * Check if redirects are allowed
     * @return boolean
     */
    public function redirectsAllowed()
    {
        return $this['allow_redirects']!==false;
    }

    /**
     * Check if has body
     * @return boolean
     */
    public function hasBody()
    {
        return $this['body']!==false;
    }

    /**
     * Define how much redirects must be followed, default null = infinite
     * @return Configuration|integer|null
     */
    public function allowRedirectsMax($max = null)
    {
        return $this->arrayValue('allow_redirects', 'max', $max);
    }

    /**
     * Define if referer must be set during redirection
     * @return Configuration|boolean
     */
    public function allowRedirectsReferer($referer = null)
    {
        return $this->arrayValue('allow_redirects', 'referer', $referer);
    }

    /**
     * Retrieve configuration property value
     * @param  string $name Property name
     * @return mixed
     */
    public function __get($name)
    {
        if (!$this->offsetExists($name)) {
            throw new \InvalidArgumentException('Invalid configuration key given !');
        }

        return $this[$name];
    }

    /**
     * Set a configuration value
     * @param string $name  Property name
     * @param mixed  $value Value to be set
     */
    public function __set($name, $value)
    {
        if (!$this->offsetExists($name) || is_array($this[$name])) {
            throw new \InvalidArgumentException('Invalid configuration key given !');
        }

        $this[$name] = $value;
    }

    /**
     * Allow to set an array value in the collection
     * @param  string $key      Key to retrieve the array in the collection
     * @param  string $arrayKey Array key to set
     * @param  mixed  $value    Value to be set or null
     * @return mixed
     */
    protected function arrayValue($key, $arrayKey, $value = null)
    {
        $array = $this[$key];
        $is = is_array($array);
        if (null !== $value) {
            if (!$is) {
                $array = self::DEFAULTS[$key];
            }
            $array[$arrayKey] = $value;
            $this[$key] = $array;
            return null;
        } else {
            return $is && isset($array[$arrayKey])
                ?$array[$arrayKey]
                :null;
        }
    }
}
