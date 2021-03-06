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

/**
 * Build a response from an Handle response
 * @package Bee4\Transport\Message
 */
class ResponseFactory
{
    /**
     * Build a new reponse object from handle execution result
     * @param  string                  $content Response content
     * @param  ExecutionInfos          $infos   Execution details
     * @param  Request\AbstractRequest $request
     * @return Response
     */
    public static function build(
        $content,
        ExecutionInfos $infos,
        Request\AbstractRequest $request
    ) {
        $response = new Response($request);
        $response->setStatus($infos->status);
        $response->setTransactionTime($infos->transactionTime);
        $response->setExecutionInfos($infos);

        //Populate request headers with all really sent headers
        if (!empty($infos->headers)) {
            self::parseHeaders(
                $infos->headers,
                $request
            );
        }

        //Headers are returned with content, so we extract it
        $content = self::parseHeaders($content, $response);

        $response->setBody($content);

        return $response;
    }

    /**
     * Parse headers from content and populate response with it
     * @param string $content
     * @param \Bee4\Transport\Message\AbstractMessage $message
     * @return string
     */
    public static function parseHeaders($content, AbstractMessage $message)
    {
        $namespace = explode('\\', get_class($message));
        $name = strtoupper(array_pop($namespace));

        if (strpos($content, 'HTTP/') === 0 || strpos($content, $name) === 0) {
            $line = self::nibbleLine($content);
            if (preg_match('/^HTTP\/[0-9]{1}\.[0-9]{1} (?P<code>[0-9]+) (?P<message>.*)$/', $line, $matches) &&
                $matches["code"] == "100"
            ) {
                self::nibbleLine($content);
            }
            while (($line = self::nibbleLine($content)) != "") {
                if (preg_match('/^([A-Za-z\-]+): (.*)/', $line, $matches)) {
                    $message->addHeader($matches[1], $matches[2]);
                }
            }
        }

        return $content;
    }

    /**
     * Read a line inside a string, remove the read line from the string and return the line
     * @param string $content
     * @param string $eol
     * @return string
     */
    private static function nibbleLine(&$content, $eol = "\r\n")
    {
        $line = substr($content, 0, strpos($content, $eol));
        $content = substr($content, strlen($line)+2);
        return $line;
    }
}
