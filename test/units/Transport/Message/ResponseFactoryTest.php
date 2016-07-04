<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Transport\Message
 */

namespace Bee4\Test\Transport\Message;

use Bee4\PHPUnit\HttpClientTestCase;
use Bee4\Transport\Client;
use Bee4\Transport\MagicHandler;
use Bee4\Transport\Message\Response;
use Bee4\Transport\Message\ResponseFactory;

/**
 * ResponseFactory unit test definition
 * @package Bee4\Test\Transport\Message
 */
class ResponseFactoryTest extends HttpClientTestCase
{
    public function testBuild()
    {
        $client = new MagicHandler(new Client(self::getBaseUrl()));
        $request = $client->get();
        $request->addHeader('Content-Type', 'text/html');
        $request->setUserAgent('Bee4 - BeeBot/v1.0');
        $response = $request->send();

        $headers = $response->getHeaders();
        $this->assertArrayHasKey('content-type', $headers);
        $this->assertArrayHasKey('content-length', $headers);

        $requestHeaders = $request->getHeaders();
        $this->assertArrayHasKey('content-type', $requestHeaders);
        $this->assertArrayHasKey('user-agent', $requestHeaders);
    }

    /**
     * @dataProvider headerProvider
     * @param type $headers
     * @param type $length
     * @param array $valid
     */
    public function testParseHeaders($headers, $length, array $valid = [])
    {
        $response = new Response();
        $rest = ResponseFactory::parseHeaders($headers, $response);

        $this->assertEquals($length, strlen($rest));
        foreach ($valid as $name => $value) {
            $this->assertEquals($value, $response->getHeader($name));
        }
    }

    public function headerProvider()
    {
        return [
            [
                "HTTP/1.1 100 Continue\r\n".
                "\r\n".
                "HTTP/1.1 200 OK\r\n".
                "Content-Type: text/html; charset=UTF-8\r\n".
                "Content-Length: 17\r\n".
                "\r\n".
                "Just some content",
                17,
                ["Content-Length" => 17, "Content-Type" => 'text/html; charset=UTF-8']
            ],
            [
                "HTTP/1.1 200 OK\r\n".
                "Content-Type: application/json\r\n".
                "Content-Length: 0\r\n".
                "",
                0,
                ["Content-Length" => 0, "Content-Type" => 'application/json']
            ],
            [
                "HTTP/1.1 302 Found\r\n".
                "Content-Length: 0\r\n".
                "Location: http://www.google.fr\r\n",
                0,
                ["Content-Length" => 0, "Location" => 'http://www.google.fr']
            ]
        ];
    }
}
