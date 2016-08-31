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

use Bee4\Transport\ClientFactory as SUT;
use Bee4\Transport as LUT;

/**
 * Check behaviour of ClientFactory helper
 * @package Bee4\Test\Transport
 */
class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $client = SUT::create();
        $this->assertInstanceOf(LUT\MagicHandler::class, $client);
    }
}
