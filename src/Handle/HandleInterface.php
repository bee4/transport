<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Handle
 */

namespace Bee4\Transport\Handle;

use Bee4\Transport\Message\Request\AbstractRequest;

/**
 * Handle factory
 * @package Bee4\Transport\Handle
 */
interface HandleInterface
{
    /**
     * Prepare the handle to be configured
     * @param AbstractRequest $request
     */
    public function prepare(AbstractRequest $request);

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

    /**
     * Retrieve details from the previous handle execution
     * @return ExecutionInfos
     */
    public function infos();
}
