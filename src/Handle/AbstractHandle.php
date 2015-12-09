<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Handle
 */
namespace Bee4\Transport\Handle;

/**
 * Add information container capabilities
 * @package Bee4\Transport\Handle
 */
abstract class AbstractHandle implements HandleInterface
{
    /**
     * Last execution details
     * @var string
     */
    protected $infos = [];

    /**
     * cURL option to be used to execute current handle
     * @var array
     */
    protected $options = [];

    /**
     * Check if execution details contain requested info
     * @param string $name
     * @return boolean
     */
    public function hasInfo($name)
    {
        return isset($this->infos[$name]);
    }

    /**
     * Return last execution detail
     * @param string $name
     * @return int|string|double
     */
    public function getInfo($name)
    {
        if ($this->hasInfo($name)) {
            return $this->infos[$name];
        }

        return null;
    }

    /**
     * Retrieve all infos
     * @return array
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Add an option to the handle
     * @param int $name
     * @param mixed $value
     * @return Handle
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * Add an option to the handle
     * @param int $name
     * @param mixed $value
     * @return Handle
     */
    public function addOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     * Add multiple option at once
     * @param string[] $options
     * @return Handle
     */
    public function addOptions(array $options)
    {
        foreach ($options as $name => $value) {
            $this->addOption($name, $value);
        }
        return $this;
    }
}
