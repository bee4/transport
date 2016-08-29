<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message
 */

namespace Bee4\Transport\Message;

use Bee4\Transport\Handle\ExecutionInfos;
use Bee4\Transport\Exception\RuntimeException;
use Bee4\Transport\Message\Request\AbstractRequest;

/**
 * Response wrapper
 * @package Bee4\Transport\Message
 */
class Response extends AbstractMessage
{
    use WithBodyTrait;

    /**
     * The request which allow to generate this response
     * @var AbstractRequest
     */
    protected $request;

    /**
     * The execution details which helped to build the request
     * @var ExecutionInfos
     */
    protected $infos;

    /**
     * HTTP Status code
     * @var integer
     */
    protected $status;

    /**
     * HTTP total transaction time in second
     * @var double
     */
    protected $transactionTime;

    /**
     * Build the response with Request dependency injection
     * @param AbstractRequest $request
     */
    public function __construct(AbstractRequest $request = null)
    {
        parent::__construct();
        $this->request = $request;
    }

    /**
     * Set the linked request
     * @param AbstractRequest $request
     * @return Response
     */
    public function setRequest(AbstractRequest $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return AbstractRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the execution infos
     * @param ExecutionInfos $infos
     * @return Response
     */
    public function setExecutionInfos(ExecutionInfos $infos)
    {
        $this->infos = $infos;
        return $this;
    }

    /**
     * @return ExecutionInfos
     */
    public function getExecutionInfos()
    {
        return $this->infos;
    }

    /**
     * @param int $code
     * @return Response
     */
    public function setStatus($code)
    {
        $this->status = (int)$code;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->request->getStatusMessage($this->status);
    }

    /**
     * @param double $time
     * @return Response
     * @throws RuntimeException
     */
    public function setTransactionTime($time)
    {
        if (!is_numeric($time) || $time < 0) {
            throw new RuntimeException("Invalid response time format");
        }
        $this->transactionTime = (float)$time;
        return $this;
    }

    /**
     * @return double
     */
    public function getTransactionTime()
    {
        return $this->transactionTime;
    }

    /**
     * Try to json_decode the response body
     * @return string
     * @throws RuntimeException
     */
    public function json()
    {
        $json = json_decode($this->getBody(), true);
        if ($json === null) {
            throw new RuntimeException(sprintf(
                "Can't decode response as JSON: %s",
                function_exists('json_last_error_msg')?
                    json_last_error_msg():
                    'Error code '.json_last_error()
            ));
        }
        return $json;
    }
}
