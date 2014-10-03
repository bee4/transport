<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Transfer\Message
 */

namespace Bee4\Test\Transfer\Message;

/**
 * AbstractMessage unit test definition
 * @package Bee4\Test\Transfer\Message
 */
class WithBodyTraitTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test all headers collection manipulation function
	 */
	public function testBody() {
		$mock = $this->getObjectForTrait('Bee4\Transfer\Message\WithBodyTrait');

		$this->assertFalse($mock->getBody());
		$mock->setBody('Just a sample body');
		$this->assertEquals('Just a sample body', $mock->getBody());
	}
}
