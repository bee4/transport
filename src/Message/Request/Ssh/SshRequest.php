<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Ssh
 */

namespace Bee4\Transport\Message\Request\Ssh;

use Bee4\Transport\Message\Request\AbstractRequest;

class SshRequest extends AbstractRequest
{
    const STATUS_0  = "0  OK";
    const STATUS_1  = "1  EOF";
    const STATUS_2  = "2  No such file";
    const STATUS_3  = "3  Permission denied";
    const STATUS_4  = "4  Failure";
    const STATUS_5  = "5  Bad message";
    const STATUS_6  = "6  No connection";
    const STATUS_7  = "7  Connection lost";
    const STATUS_8  = "8  Operation unsupported";
    const STATUS_9  = "9  Invalid handle";
    const STATUS_10 = "10 No such path";
    const STATUS_11 = "11 File already exists";
    const STATUS_12 = "12 Write protect";
    const STATUS_13 = "13 No media";
    const STATUS_14 = "14 No space on file-system";
    const STATUS_15 = "15 Quota exceeded";
    const STATUS_16 = "16 Unknown principal";
    const STATUS_17 = "17 Lock conflict";
    const STATUS_18 = "18 Directory not empty";
    const STATUS_19 = "19 Not a directory";
    const STATUS_20 = "20 Invalid filename";
    const STATUS_21 = "21 Link loop";
    const STATUS_22 = "22 Cannot delete";
    const STATUS_23 = "23 Invalid parameter";
    const STATUS_24 = "24 File is a directory";
    const STATUS_25 = "25 Range lock conflict";
    const STATUS_26 = "26 Range lock refused";
    const STATUS_27 = "27 Delete pending";
    const STATUS_28 = "28 File corrupt";
    const STATUS_29 = "29 Owner invalid";
    const STATUS_30 = "30 Group invalid";
    const STATUS_31 = "31 No matching byte range lock";

    /**
     * Prepare the request execution by adding specific cURL parameters
     */
    protected function prepare()
    {
        $this->addOption(CURLOPT_SSH_AUTH_TYPES, CURLSSH_AUTH_ANY);
        $this->addOption(CURLOPT_PROTOCOLS, CURLPROTO_SCP|CURLPROTO_SFTP);
    }
}
