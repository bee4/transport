<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Configuration
 */

namespace Bee4\Transport\Configuration;

/**
 * FTP Configuration implementation
 * @package Bee4\Transport\Configuration
 * @property boolean $passive Is the passive mode must be used for the current request ?
 */
class FtpConfiguration extends Configuration
{
    use HasCommand;

    /**
     * Default configuration values
     */
    const DEFAULTS = [
        'commands' => [
            'request' => null,
            'post' => null
        ],
        'passive' => true
    ];

    /**
     * Build a configuration instance
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct(array_merge(
            self::DEFAULTS,
            $data
        ));
    }
}
