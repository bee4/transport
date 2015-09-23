<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
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
        if( $this->hasBodyStream() ) {
            $this->addOption(CURLOPT_PUT, true);
            $this->addOption(CURLOPT_INFILE, $this->getBody());
            $this->addOption(CURLOPT_INFILESIZE, $this->getBodyLength());
        } else {
            $this->addOption(CURLOPT_CUSTOMREQUEST, 'PUT');
            $this->addOption(CURLOPT_POSTFIELDS, $this->getBody());
        }
    }

    /**
     * Handle resource management
     */
    public function __destruct()
    {
        if( $this->hasOption(CURLOPT_INFILE) ) {
            $options = $this->getOptions();
            fclose($options[CURLOPT_INFILE]);
        }
    }
}
