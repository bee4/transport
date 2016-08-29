<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Test\Transport\Configuration
 */

namespace Bee4\Test\Transport\Configuration;

use Bee4\Transport\Configuration\FtpConfiguration;

/**
 * @package Bee4\Test\Transport\Configuration
 */
class FtpConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $conf = new FtpConfiguration();

        $this->assertArrayHasKey('commands', $conf);
    }

    public function testCommandsRequest()
    {
        $conf = new FtpConfiguration();

        $this->assertNull($conf->commandsRequest());
        $conf->commandsRequest('a command');
        $this->assertEquals('a command', $conf->commandsRequest());
    }

    public function testCommandsPost()
    {
        $conf = new FtpConfiguration();

        $this->assertNull($conf->commandsPost());
        $conf->commandsPost('a command');
        $this->assertEquals('a command', $conf->commandsPost());
    }
}
