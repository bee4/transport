<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Test\Transport
 */

namespace Bee4\Test\Transport;

use Bee4\PHPUnit\HttpClientTestCase;
use Bee4\Transport\MagicHandler as SUT;
use Bee4\Transport as LUT;

/**
 * Check behaviour of ClientFactory helper
 * @package Bee4\Test\Transport
 */
class MagicHandlerTest extends HttpClientTestCase
{
    public function retrieveParameters()
    {
        return [
            ['get', 'http://localhost'],
            ['post', 'http://localhost'],
            ['put', 'http://localhost', ['Content-Type' => 'text/html']],
            ['delete', 'http://localhost'],
            ['head', 'http://localhost', ['Accept' => 'application/json']],
        ];
    }

    /**
     * @dataProvider retrieveParameters
     */
    public function testMagicCall($method, $url, $headers = [])
    {
        $client = new LUT\Client();
        $magic = new SUT($client);

        $result = call_user_func([$magic, $method], $url, $headers);

        $this->assertInstanceOf(LUT\Message\Request\AbstractRequest::class, $result);
        $class = substr(get_class($result), strrpos(get_class($result), '\\')+1);
        $this->assertEquals(ucfirst($method), $class);

        foreach($headers as $name => $value) {
            $this->assertEquals($value, $result->getHeader($name));
        }
    }

    public function testSend()
    {
        $config = new LUT\Configuration\Configuration;
        $config->url = self::getBaseUrl();
        $client = new LUT\Client('', $config);
        $magic = new SUT($client);

        $request = $magic->get(self::getBaseUrl());
        $response = $magic->send($request);

        $this->assertInstanceOf(LUT\Message\Response::class, $response);
    }
}
