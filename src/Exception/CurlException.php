<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Exception
 */

namespace Bee4\Transport\Exception;

use Bee4\Transport\Message\Response;

/**
 * Define cURL handle wrapper
 * @package Bee4\Transport\Exception
 */
class CurlException extends \Exception
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * Set the error response
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
