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

use Bee4\Transport\Message\Request\RequestFactory;
use Bee4\Transport\Url;

/**
 * RequestFactory unit test definition
 * @package Bee4\Test\Transport\Message
 */
class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $object = new RequestFactory();

        $get = $object->build('GET', new Url('http://www.bee4.fr'), ['Content-Type' => 'text/html']);
        $this->assertInstanceOf('\Bee4\Transport\Message\Request\Http\Get', $get);
        $this->assertEquals('text/html', $get->getHeader('Content-Type'));
        $post = $object->build('POST', new Url('http://www.bee4.fr'), ['Content-Length' => 128]);
        $this->assertInstanceOf('\Bee4\Transport\Message\Request\Http\Post', $post);
        $this->assertEquals(128, $post->getHeader('Content-Length'));
    }

    /**
     * @expectedException \Bee4\Transport\Exception\InvalidArgumentException
     */
    public function testInvalidRequestBuild()
    {
        $object = new RequestFactory();
        $object->build('UNKNOWN', new Url('http://www.bee4.fr'), []);
    }
}
