<?php

/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transfer\Message\Request
 */

namespace Bee4\Transfer\Message\Request;

/**
 * @package Bee4\Transfer\Message\Request
 */
interface RequestInterface {
    const HTTP = 'http';
    const FTP = 'ftp';

    /**
     * To send a request, a client must be linked
     * @return \Bee4\Transfer\Message\Response
     */
    public function send();

    /**
     * Retrieve the list of configured Curl options
     * @return array
     */
    public function getCurlOptions();
}