<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Http\Message
 */

namespace Bee4\Http\Message;

/**
 * Build a response from cURL response
 * @package Bee4\Http\Message
 */
class ResponseFactory {
	protected static $headers;

	/**
	 * Build a new reponse object from cURL execution result
	 * @param string $content Response content
	 * @param array $curlInfo Curl details about the last execution
	 */
	public static function build($content, $curlInfo) {
		$response = new Response();

		if( strpos($content, "HTTP/1.1 100 Continue") === 0 ) {
			$content = substr($content, 25);
		}

		//Headers are returned with content, so we extract it
		if( strpos($content,'HTTP/') === 0 ) {
			$lines = [];
			while( ($line = substr($content, 0, strpos($content, "\r\n"))) != "" ) {
				$content = substr($content, strlen($line)+2);

				if( preg_match('/^([A-Za-z\-]+): (.*)/', $line, $matches) )
					$response->addHeader(strtolower($matches[1]), $matches[2]);
			}
			$content = substr($content, strlen($line)+2);
		} else {
			if( isset($curlInfo['content_type']) ) {
				$response->addHeader('content-type', $curlInfo['content_type']);
			}
		}
		if( isset( $curlInfo['http_code']) ) {
			$response->setStatus($curlInfo['http_code']);
		}

		$response->setBody($content);
		$response->addHeader('content-length', strlen($content));

		return $response;
	}
}