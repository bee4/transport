<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Ftp
 */

namespace Bee4\Transport\Message\Request\Ftp;

/**
 * FTP GET Request object => Retrieve the file
 * @package Bee4\Transport\Message\Request\Ftp
 */
class Get extends FtpRequest
{
    protected function prepare()
    {
        parent::prepare();
        $this->addOption('url', $this->getUrl());
    }
}
