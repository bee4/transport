<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Http
 */

namespace Bee4\Transport\Message\Request\Http;

/**
 * HTTP GET Request object
 * @package Bee4\Transport\Message\Request\Http
 */
class Get extends HttpRequest
{
    protected function prepare()
    {
        $this->addOption('method', 'GET');
    }
}
