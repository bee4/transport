<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

use Bee4\Transport\Message\Request\AbstractRequest;

/**
 * Http client canvas
 * @package Bee4\Transport
 */
interface ClientInterface
{
    /**
     * Send the request
     * @param AbstractRequest $request The request to be send
     * @return Message\Response
     * @throws \Exception
     */
    public function send(AbstractRequest $request);

    /**
     * Create the request object
     * @param string $method
     * @param string $url
     * @param array $headers
     * @return AbstractRequest
     */
    public function createRequest($method, $url = '', array $headers = []);
}
