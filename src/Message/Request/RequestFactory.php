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

use Bee4\Transport\Configuration\Configuration;
use Bee4\Transport\Exception\InvalidArgumentException;
use Bee4\Transport\Exception\UnknownProtocolException;
use Bee4\Transport\Url;

/**
 * Static object in charge to build and initialize Request instance
 * @package Bee4\Transport\Message\Request
 */
class RequestFactory
{
    /**
     * Configuration to use when building Request
     * @var Configuration
     */
    protected $configuration;

    /**
     * Initialize the Request factory
     * @param Configuration|null $config
     */
    public function __construct(Configuration $config = null)
    {
        if(null !== $config) {
            $this->setConfiguration($config);
        }
    }

    /**
     * Set configuration to use when building requests
     * @param Configuration $config
     * @return RequestFactory
     */
    public function setConfiguration(Configuration $config)
    {
        $this->configuration = $config;
    }

    /**
     * Build a new request from parameters
     * @param string $method
     * @param Url $url
     * @param array $headers
     * @return AbstractRequest
     * @throws UnknownProtocolException
     * @throws InvalidArgumentException
     */
    public function build($method, Url $url, array $headers)
    {
        if (($scheme = self::isAllowedScheme((string)$url->scheme())) === false) {
            throw new UnknownProtocolException(sprintf(
                "You can't request a transfer on unsupported protocol '%s'!",
                $url->scheme()
            ));
        }

        $scheme = ucfirst($scheme);
        $name = __NAMESPACE__.'\\'.$scheme.'\\'.ucfirst(strtolower($method));
        if (!class_exists($name)) {
            throw new InvalidArgumentException('Method given is not a valid request: '.$method);
        }

        $configurationClass = '\Bee4\Transport\Configuration\\'.$scheme.'Configuration';
        $request = new $name(
            $url,
            $headers,
            new $configurationClass(
                $this->configuration!==null?$this->configuration->toArray():[]
            )
        );

        return $request;
    }

    /**
     * Validate scheme by checking if its an allowed one
     * @param string $scheme
     * @return boolean|string If invalid, false, else return the request known one
     */
    private static function isAllowedScheme($scheme)
    {
        if (preg_match(AbstractRequest::HTTP, $scheme) === 1) {
            return 'http';
        } elseif (preg_match(AbstractRequest::FTP, $scheme) === 1) {
            return 'ftp';
        } elseif (preg_match(AbstractRequest::SSH, $scheme) === 1) {
            return 'ssh';
        } else {
            return false;
        }
    }
}
