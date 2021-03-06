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

use Bee4\Transport\Message\WithBodyStreamTrait;
use Bee4\Transport\Exception\RuntimeException;

/**
 * SSH Put Request object => Use to upload files to remote
 * @package Bee4\Transport\Message\Request\Ssh
 */
class Put extends SshRequest
{
    use WithBodyStreamTrait;

    /**
     * Prepare current request to being executed
     * @throws RuntimeException
     */
    protected function prepare()
    {
        parent::prepare();

        if (!$this->hasBodyStream()) {
            if (false === $stream = tmpfile()) {
                throw new RuntimeException("Can't create temporary file.");
            }
            fwrite($stream, $this->getBody());
            rewind($stream);
            $this->setBody($stream);
        }

        $this->addOption('url', $this->getUrl());
        $this->addOption('upload', true);
        $this->addOption('body', $this->getBody());
    }

    /**
     * Handle resource management
     */
    public function __destruct()
    {
        if ($this->hasBodyStream()) {
            fclose($this->getBody());
        }
    }
}
