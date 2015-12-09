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

use Bee4\Transport\Message\Request\AbstractRequest;

class HttpRequest extends AbstractRequest
{
    //1XX - Informational
    const STATUS_100 = "100 Continue";
    const STATUS_101 = "101 Switching Protocols";
    const STATUS_102 = "102 Processing (WebDAV; RFC 2518)";
    //2XX - Success
    const STATUS_200 = "200 OK";
    const STATUS_201 = "201 Created";
    const STATUS_202 = "202 Accepted";
    const STATUS_203 = "203 Non-Authoritative Information (since HTTP/1.1)";
    const STATUS_204 = "204 No Content";
    const STATUS_205 = "205 Reset Content";
    const STATUS_206 = "206 Partial Content";
    const STATUS_207 = "207 Multi-Status (WebDAV; RFC 4918)";
    const STATUS_208 = "208 Already Reported (WebDAV; RFC 5842)";
    const STATUS_226 = "226 IM Used (RFC 3229)";
    //3XX - Redirection
    const STATUS_300 = "300 Multiple Choices";
    const STATUS_301 = "301 Moved Permanently";
    const STATUS_302 = "302 Found";
    const STATUS_303 = "303 See Other (since HTTP/1.1)";
    const STATUS_304 = "304 Not Modified";
    const STATUS_305 = "305 Use Proxy (since HTTP/1.1)";
    const STATUS_306 = "306 Switch Proxy";
    const STATUS_307 = "307 Temporary Redirect (since HTTP/1.1)";
    const STATUS_308 = "308 Permanent Redirect (Experimental RFC; RFC 7238)";
    //4XX - Client error
    const STATUS_400 = "400 Bad Request";
    const STATUS_401 = "401 Unauthorized";
    const STATUS_402 = "402 Payment Required";
    const STATUS_403 = "403 Forbidden";
    const STATUS_404 = "404 Not Found";
    const STATUS_405 = "405 Method Not Allowed";
    const STATUS_406 = "406 Not Acceptable";
    const STATUS_407 = "407 Proxy Authentication Required";
    const STATUS_408 = "408 Request Timeout";
    const STATUS_409 = "409 Conflict";
    const STATUS_410 = "410 Gone";
    const STATUS_411 = "411 Length Required";
    const STATUS_412 = "412 Precondition Failed";
    const STATUS_413 = "413 Request Entity Too Large";
    const STATUS_414 = "414 Request-URI Too Long";
    const STATUS_415 = "415 Unsupported Media Type";
    const STATUS_416 = "416 Requested Range Not Satisfiable";
    const STATUS_417 = "417 Expectation Failed";
    const STATUS_418 = "418 I'm a teapot (RFC 2324)";
    const STATUS_422 = "422 Unprocessable Entity (WebDAV; RFC 4918)";
    const STATUS_423 = "423 Locked (WebDAV; RFC 4918)";
    const STATUS_424 = "424 Failed Dependency (WebDAV; RFC 4918)";
    const STATUS_426 = "426 Upgrade Required";
    const STATUS_428 = "428 Precondition Required (RFC 6585)";
    const STATUS_429 = "429 Too Many Requests (RFC 6585)";
    const STATUS_431 = "431 Request Header Fields Too Large (RFC 6585)";
    const STATUS_440 = "440 Login Timeout (Microsoft)";
    const STATUS_444 = "444 No Response (Nginx)";
    const STATUS_449 = "449 Retry With (Microsoft)";
    const STATUS_450 = "450 Blocked by Windows Parental Controls (Microsoft)";
    const STATUS_451 = "Unavailable For Legal Reasons (Internet draft)";
    const STATUS_494 = "494 Request Header Too Large (Nginx)";
    const STATUS_495 = "495 Cert Error (Nginx)";
    const STATUS_496 = "496 No Cert (Nginx)";
    const STATUS_497 = "497 HTTP to HTTPS (Nginx)";
    const STATUS_498 = "498 Token expired/invalid (Esri)";
    const STATUS_499 = "499 Client Closed Request (Nginx)";
    //5XX - Server Error
    const STATUS_500 = "500 Internal Server Error";
    const STATUS_501 = "501 Not Implemented";
    const STATUS_502 = "502 Bad Gateway";
    const STATUS_503 = "503 Service Unavailable";
    const STATUS_504 = "504 Gateway Timeout";
    const STATUS_505 = "505 HTTP Version Not Supported";
    const STATUS_506 = "506 Variant Also Negotiates (RFC 2295)";
    const STATUS_507 = "507 Insufficient Storage (WebDAV; RFC 4918)";
    const STATUS_508 = "508 Loop Detected (WebDAV; RFC 5842)";
    const STATUS_509 = "509 Bandwidth Limit Exceeded (Apache bw/limited extension)";
    const STATUS_510 = "510 Not Extended (RFC 2774)";
    const STATUS_511 = "511 Network Authentication Required (RFC 6585)";

    /**
     * Send the request and prepend some headers
     * @return \Bee4\Transport\Message\Response
     */
    public function send()
    {
        $this->addOption(CURLOPT_HTTPHEADER, $this->getHeaderLines());
        $this->addOption(CURLOPT_USERAGENT, $this->getUserAgent());

        return parent::send();
    }

    /**
     * Prepare the request execution by adding specific cURL parameters
     */
    protected function prepare()
    {
    }
}
