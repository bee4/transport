<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Handle
 */

namespace Bee4\Transport\Handle;

/**
 * Handle factory
 * @package Bee4\Transport\Handle
 */
interface HandleInterface
{
    /**
     * Execute the handle and retrieve the result
     * @throws \Exception
     */
    public function execute();

    /**
     * Reset the current handle to allow reusing
     * @return boolean
     */
    public function reset();
}
