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
 * FTP HEAD Request object used to check if resources are really here
 * @package Bee4\Transport\Message\Request\Ftp
 */
class Head extends FtpRequest
{
    protected function prepare()
    {
        parent::prepare();

        $this->addOption(CURLOPT_NOBODY, true);
        //apply MDTM action on the file, if not valid status is 550 the simplest way for HEAD
        $this->addOption(CURLOPT_QUOTE, ['MDTM '.$this->getUrl()->path()]);
    }
}
