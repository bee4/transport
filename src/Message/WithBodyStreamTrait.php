<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message
 */
namespace Bee4\Transport\Message;

use \InvalidArgumentException;

/**
 * Allow the body to be a stream
 * @package Bee4\Transport\Message
 */
trait WithBodyStreamTrait
{
    use WithBodyTrait {
        WithBodyTrait::setBody as private setStringBody;
    }

    /**
     * Set body with stream acceptance
     * @param resource|string $body Request body
     */
    public function setBody($body)
    {
        if( is_string($body) ) {
            return $this->setStringBody($body);
        }

        if( !is_resource($body) ) {
            throw new InvalidArgumentException('Body must be a stream !');
        }
        if( !stream_is_local($body) ) {
            throw new InvalidArgumentException('Body must be a local stream !');
        }

        rewind($body);
        $this->body = $body;
    }

    /**
     * Check if the current body is a stream or not
     * @return boolean
     */
    public function hasBodyStream()
    {
        return is_resource($this->getBody());
    }

    /**
     * Retrieve stream meta data if available
     * @return array|null
     */
    public function getMetaData()
    {
        if( $this->hasBodyStream() ) {
            return stream_get_meta_data($this->getBody());
        }
        return null;
    }

    /**
     * Retrieve the body length from string or stream
     * @return integer
     */
    public function getBodyLength()
    {
        $md = $this->getMetaData();
        return null !== $md
            ?filesize($md['uri'])
            :strlen($this->getBody());
    }
}
