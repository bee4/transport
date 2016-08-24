<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request
 */

namespace Bee4\Transport\Message\Request;

use Bee4\Transport\Message\AbstractMessage;
use Bee4\Transport\Configuration\Configuration;
use Bee4\Transport\Client;
use Bee4\Transport\Url;
use Bee4\Transport\Exception\RuntimeException;

/**
 * HTTP Request object
 * @package Bee4\Transport\Message\Request
 */
abstract class AbstractRequest extends AbstractMessage
{
    //Compatible SCHEME
    const HTTP = '/^http/';
    const FTP = '/^ftp/';
    const SSH = '/sftp|scp/';

    /**
     * Current client instance
     * @var Client
     */
    protected $client;

    /**
     * Current request configuration
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Url
     */
    protected $url;

    /**
     * Construct a new request object
     * @param Url $url
     * @param array $headers
     */
    public function __construct(Url $url, array $headers = [], Configuration $configuration = null)
    {
        parent::__construct();

        $this->url = $url;
        $this->configuration = $configuration===null?new Configuration:$configuration;
        $this->addHeaders($headers);
    }

    /**
     * Set the linked client
     * @param Client $client
     * @return AbstractRequest
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * URL accessor
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * cURL option collection accessor
     * @return Configuration
     */
    public function getOptions()
    {
        return $this->configuration;
    }

    /**
     * Add specifically curl option list to current request
     * @param array $options
     * @return AbstractRequest
     */
    public function addOptions(array $options)
    {
        foreach ($options as $name => $value) {
            $this->addOption($name, $value);
        }

        return $this;
    }

    /**
     * Add an option for current request
     * @param int $name
     * @param mixed $value
     * @return AbstractRequest
     */
    public function addOption($name, $value)
    {
        if (strpos($name, '.') !== false) {
            $method = explode('.', $name);
            $method = array_shift($method).implode('', array_map('ucfirst', $method));
            $this->configuration->$method($value);
        } elseif ($name === 'user_agent') {
            $this->setUserAgent($value);
        } else {
            $this->configuration->$name = $value;
        }

        return $this;
    }

    /**
     * Check if an option exists
     * @param mixed $name
     * @return boolean
     */
    public function hasOption($name)
    {
        return $this->configuration->offsetExists($name);
    }

    /**
     * Prepare the request execution by adding specific cURL parameters
     */
    abstract protected function prepare();

    /**
     * Send method.
     * To send a request, a client must be linked
     * @return \Bee4\Transport\Message\Response
     * @throws RuntimeException
     */
    public function send()
    {
        if (!$this->client) {
            throw new RuntimeException('A client must be set on the request');
        }

        if (null === $this->configuration->url) {
            $this->configuration->url = $this->getUrl()->toString();
        }
        $this->prepare();

        return $this->client->send($this);
    }

    /**
     * Retrieve the status message for the current request based on STATUS_XXX constants
     * @param string $status
     * @return string
     */
    public function getStatusMessage($status)
    {
        $name = get_called_class().'::STATUS_'.$status;
        return defined($name)?constant($name):'';
    }

    /**
     * Get the client UA for all requests
     * @return string
     */
    public function getUserAgent()
    {
        return $this->configuration->user_agent;
    }

    /**
     * Set the client UA for current request
     * @param string $ua
     * @return AbstractRequest
     */
    public function setUserAgent($ua)
    {
        $this->configuration->user_agent = $ua;
        $this->addHeader('User-Agent', $ua);

        return $this;
    }
}
