<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Ftp
 */

namespace Bee4\Transport\Message\Request\Ftp;

use Bee4\Transport\Message\Request\AbstractRequest;

class FtpRequest extends AbstractRequest
{
    //1XX - The requested action is being initiated, expect another reply before proceeding with a new command.
    //110 -> In this case, the text is exact and not left to the particular implementation;
    //       it must read: STATUS_MARK yyyy = mmmm = where yyyy is User-process data stream marker,
    //       and mmmm server's equivalent marker (note the spaces between markers and \"=\").
    const STATUS_110 = "Restart marker replay.";
    const STATUS_120 = "Service ready in nnn minutes.";
    const STATUS_125 = "Data connection already open; transfer starting.";
    const STATUS_150 = "File status okay; about to open data connection.";
    //2XX - The requested action has been successfully completed.
    const STATUS_202 = "Command not implemented, superfluous at this site.";
    const STATUS_211 = "System status, or system help reply.";
    const STATUS_212 = "Directory status.";
    const STATUS_213 = "File status.";
    //214 -> This reply is useful only to the human user.
    const STATUS_214 = "Help message. On how to use the server or the meaning of a particular non-standard command.";
    const STATUS_215 = "NAME system type. Where NAME is an official system name from the registry kept by IANA";
    const STATUS_220 = "Service ready for new user.";
    const STATUS_221 = "Service closing control connection.";
    const STATUS_225 = "Data connection open; no transfer in progress.";
    //226 -> Requested file action successful (for example, file transfer or file abort).";
    const STATUS_226 = "Closing data connection.";
    const STATUS_227 = "Entering Passive Mode (h1,h2,h3,h4,p1,p2).";
    const STATUS_228 = "Entering Long Passive Mode (long address, port).";
    const STATUS_229 = "Entering Extended Passive Mode (|||port|).";
    const STATUS_230 = "User logged in, proceed. Logged out if appropriate.";
    const STATUS_231 = "User logged out; service terminated.";
    const STATUS_232 = "Logout command noted, will complete when transfer done.";
    const STATUS_250 = "Requested file action okay, completed.";
    const STATUS_257 = "\"PATHNAME\" created.";
    //3XX - The command has been accepted, but the requested action is on hold, pending receipt of further information.
    const STATUS_331 = "User name okay, need password.";
    const STATUS_332 = "Need account for login.";
    const STATUS_350 = "Requested file action pending further information";
    //4XX - The command was not accepted and the requested action did not take place,
    //      but the error condition is temporary and the action may be requested again.
    //421 -> This may be a reply to any command if the service knows it must shut down.
    const STATUS_421 = "Service not available, closing control connection.";
    const STATUS_425 = "Can't open data connection.";
    const STATUS_426 = "Connection closed; transfer aborted.";
    const STATUS_430 = "Invalid username or password";
    const STATUS_434 = "Requested host unavailable.";
    const STATUS_450 = "Requested file action not taken.";
    const STATUS_451 = "Requested action aborted. Local error in processing.";
    const STATUS_452 = "Requested action not taken. Insufficient storage space in system. File unavailable.";
    //5XX - Syntax error, command unrecognized and the requested action did not take place.
    //      This may include errors such as command line too long.
    const STATUS_501 = "Syntax error in parameters or arguments.";
    const STATUS_502 = "Command not implemented.";
    const STATUS_503 = "Bad sequence of commands.";
    const STATUS_504 = "Command not implemented for that parameter.";
    const STATUS_530 = "Not logged in.";
    const STATUS_532 = "Need account for storing files.";
    const STATUS_550 = "Requested action not taken. File unavailable (e.g., file not found, no access).";
    const STATUS_551 = "Requested action aborted. Page type unknown.";
    const STATUS_552 = "Requested file action aborted. Exceeded storage allocation (for current directory or dataset).";
    const STATUS_553 = "Requested action not taken. File name not allowed.";
    //6XX - Replies regarding confidentiality and integrity
    const STATUS_631 = "Integrity protected reply.";
    const STATUS_632 = "Confidentiality and integrity protected reply.";
    const STATUS_633 = "Confidentiality protected reply.";
    //100XX - Common Winsock Error Codes
    const STATUS_10054 = "Connection reset by peer. The connection was forcibly closed by the remote host.";
    const STATUS_10060 = "Cannot connect to remote server.";
    const STATUS_10061 = "Cannot connect to remote server. The connection is actively refused by the server.";
    const STATUS_10066 = "Directory not empty.";
    const STATUS_10068 = "Too many users, server is full.";

    /**
     * Prepare the request execution by adding specific cURL parameters
     */
    protected function prepare()
    {
        //Force passice mode if not specified
        $this->addOption('passive', true);

        //To make call on different files, we must retrieve the root and apply commands to the path
        $tmp = clone $this->getUrl();
        $tmp->path('');
        $this->addOption('url', $tmp->toString());
    }
}
