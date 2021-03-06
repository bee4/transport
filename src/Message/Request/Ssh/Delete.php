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
 * SSH DELETE Request object => Remove files from remote
 * @package Bee4\Transport\Message\Request\Ssh
 */
class Delete extends SshRequest
{
    protected function prepare()
    {
        parent::prepare();

        $this->addOption('body', false);
        $this->addOption('commands.post', ['rm '.$this->getUrl()->path()]);
    }
}
