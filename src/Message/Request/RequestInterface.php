<?php

/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request
 */

namespace Bee4\Transport\Message\Request;

use Bee4\Transport\Message\MessageInterface;

/**
 * @package Bee4\Transport\Message\Request
 */
interface RequestInterface extends MessageInterface
{
    const HTTP = 'http';
    const FTP = 'ftp';

    /**
     * To send a request, a client must be linked
     * @return \Bee4\Transport\Message\Response
     */
    public function send();

    /**
     * Retrieve the list of configured options
     * @return array
     */
    public function getOptions();
}