<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Test\Http
 */

namespace Bee4\Test\Http;

use Bee4\Http\Url;

/**
 * Check behaviour of Url helper
 * @package Bee4\Test\Http
 */
class UrlTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Provide a list of testable URLs
	 * @return array
	 */
	public function provideUrls() {
		return [
			['invalid-url-given', false],
			['www.jeux.com', false],
			['www.jeux.com/without-scheme.html', false],
			['http://www.bee4.fr'],
			['ftp://www.bee4.fr/a-page.html'],
			['http://www.bee4.fr:8080/a-page.html?with=query'],
			['http://www.bee4.fr:1349/a-page.html?with=query#and-fragment'],
			['http://user:pass@www.bee4.fr/a-page.html?with=query#and-fragment'],
			['http://user@bee4.fr/a-page.html?with=query#and-fragment'],
			['ssh://user:pass@host.com/a-page/'],
			['mailto:dev@bee4.fr']
		];
	}

	/**
	 * @param string $url Url to be tested
	 * @param boolean $valid True if the given URL is considered has a valid one
	 * @dataProvider provideUrls
	 */
	public function testUrl($url, $valid = true) {
		$this->assertEquals($valid, Url::isValid($url));

		if( $valid == false ) {
			$this->setExpectedException('\InvalidArgumentException');
		}

		$object = new Url($url);
		$this->assertEquals($url, (string)$object);
	}

	/**
	 * Check that it is possible to update a loaded URL
	 */
	public function testUrlUpdate() {
		$url = new Url('http://www.bee4.fr');

		$this->assertEquals('http', $url->scheme());
		$this->assertEquals('www.bee4.fr', $url->host());
		$this->assertEquals(80, $url->port());

		$url->scheme('https');
		$this->assertEquals('https', $url->scheme());
		$this->assertEquals(443, $url->port());

		$url->path('/page.html');
		$url->query('nb=20');
		$url->fragment('anchor');

		$this->assertEquals('https://www.bee4.fr/page.html?nb=20#anchor', (string)$url);
	}

	/**
	 * Check authentication detection
	 */
	public function testHasAuth() {
		$urlWithoutAuth = new Url('http://www.bee4.fr');
		$this->assertFalse($urlWithoutAuth->hasAuth());
		$urlWithAuth = new Url('http://user:pass@www.bee4.fr');
		$this->assertTrue($urlWithAuth->hasAuth());
	}

	/**
	 * Url must be called with a valid string has parameter
	 * @expectedException \InvalidArgumentException
	 */
	public function testBadConstruct() {
		new Url(0);
	}

	/**
	 * Check exception when call an invalid property
	 * @expectedException \BadMethodCallException
	 */
	public function testBadProperty() {
		$url = new Url('http://www.bee4.fr');
		$url->unknown();
	}

	/**
	 * Check exception when call a valid property with invalid parameters
	 * @expectedException \BadMethodCallException
	 */
	public function testBadPropertyParameters() {
		$url = new Url('http://www.bee4.fr');
		$url->scheme('param1', 'param2');
	}

	/**
	 * Check exception when try to build an invalid URL (after a bad set)
	 * @expectedException \RuntimeException
	 */
	public function testInvalidToString() {
		$url = new Url('http://www.bee4.fr');
		$url->host('');
		$url->toString();
	}

	public function testSetInvalidPort() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->port('invalid');
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidScheme() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->scheme(null);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidHost() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->host(0);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidUser() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->user(new \stdClass);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidPass() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->pass(0);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidPath() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->path(null);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidQuery() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->query(null);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}

	public function testSetInvalidFragment() {
		$url = new Url('http://www.bee4.fr');
		try {
			$url->fragment(null);
			$this->fail();
		} catch( \InvalidArgumentException $error ) {
			$this->assertTrue(true);
		}
	}
}
