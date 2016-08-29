<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Ssh
 */

namespace Bee4\Transport\Message\Request\Ssh;

/**
 * SSH HEAD Request object
 * @package Bee4\Transport\Message\Request\Ssh
 */
class Head extends SshRequest
{
    protected function prepare()
    {
        $this->addOption('body', false);
    }
}
