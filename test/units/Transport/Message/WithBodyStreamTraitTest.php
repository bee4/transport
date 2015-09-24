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

require __DIR__.'/WithBodyTraitTest.php';

/**
 * WithBodyStreamTrait unit test definition
 * @package Bee4\Test\Transport\Message
 */
class WithBodyStreamTraitTest extends WithBodyTraitTest
{
	/**
	 * Test all headers collection manipulation function
	 */
	public function testBody($mock = null) {
		$mock = $this->getObjectForTrait('Bee4\Transport\Message\WithBodyStreamTrait');
		parent::testBody($mock);

		$stream = tmpfile();
		fwrite($stream, 'toto');
		$mock->setBody($stream);

		$this->assertEquals($stream, $mock->getBody());
		$this->assertTrue($mock->hasBodyStream());
		$this->assertEquals(4, $mock->getBodyLength());
	}
}
