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

use Bee4\Transport\Message\WithBodyStreamTrait;

/**
 * HTTP POST Request object
 * @package Bee4\Transport\Message\Request\Http
 */
class Put extends HttpRequest
{
    use WithBodyStreamTrait;

    protected function prepare()
    {
        $this->addOption('method', 'PUT');
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
