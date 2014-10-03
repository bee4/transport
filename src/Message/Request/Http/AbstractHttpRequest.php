<?php

/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Http
 */

namespace Bee4\Transport\Message\Request\Http;

use Bee4\Transport\Message\Request\AbstractRequest;

abstract class AbstractHttpRequest extends AbstractRequest
{
    /**
     * Request UserAgent
     * This property is only useful with HTTP
     * @var string
     */
    protected $ua;

    /**
     * Send the request and prepend some headers
     */
    public function send() {
        $this->addCurlOption(CURLOPT_HTTPHEADER, $this->getHeaderLines());
        $this->addCurlOption(CURLOPT_USERAGENT, $this->getUserAgent());

        return parent::send();
    }

    /**
     * Get the client UA for all requests
     * @return string
     */
    public function getUserAgent() {
        return $this->ua;
    }

    /**
     * Set the client UA for all requests
     * @param string $ua
     * @return string
     */
    public function setUserAgent($ua) {
        $this->ua = $ua;
    }
} 