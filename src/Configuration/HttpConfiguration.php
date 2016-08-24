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
 * HTTP Configuration implementation
 * @package Bee4\Transport\Configuration
 */
class HttpConfiguration extends Configuration
{
    /**
     * Default configuration values
     */
    const DEFAULTS = [
        'commands' => [
            'request' => null,
            'post' => null
        ]
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
