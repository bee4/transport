bee4/transport v1.1.0
=====================

[![Build Status](https://travis-ci.org/bee4/transport.svg?branch=develop)](https://travis-ci.org/bee4/transport)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/bee4/transport/badges/quality-score.png?s=e908698796250470837da1aee3d5f1de58abe42b)](https://scrutinizer-ci.com/g/bee4/transport/)
[![Code Coverage](https://scrutinizer-ci.com/g/bee4/transport/badges/coverage.png?s=458223269fcf1205044aaa271d0bbfc08f1c7f95)](https://scrutinizer-ci.com/g/bee4/transport/)

[![License](https://poser.pugx.org/bee4/transport/license.png)](https://packagist.org/packages/bee4/transport)

This library is a transport client that can be used to handle HTTP, FTP or other protocols calls. All protocols are processed the same way and the API is a simple `Request` > `Response` mechanism.

It is inspired by the Guzzle 3 implementation with a simpler approach (no curl_multi, no SSL...), just Request and Response handling. For the moment cURL is the only implementation and all Requests options are [`CURL_*`](http://php.net/manual/fr/function.curl-setopt.php) options...


Installing
----------
[![Latest Stable Version](https://poser.pugx.org/bee4/transport/v/stable.png)](https://packagist.org/packages/bee4/transport)
[![Total Downloads](https://poser.pugx.org/bee4/transport/downloads.png)](https://packagist.org/packages/bee4/transport)
[![Latest Unstable Version](https://poser.pugx.org/bee4/transport/v/unstable.png)](https://packagist.org/packages/bee4/transport)

This project can be installed using Composer. Add the following to your composer.json:

```JSON
{
    "require": {
        "bee4/transport": "~1.1"
    }
}
```

or run this command:

```Shell
composer require bee4/transport:~1.1
```

Example
-------

You must create a `Client` instance then built the request and send it to retrieve the response.

```PHP
<?php
$client = new Bee4\Transport\MagicHandler();
$request = $client->get('http://www.example.com', ['Accept: text/html']);
$response = $request->send();

$respose->getStatusMessage(); //Retrieve the status definition example: 301 Moved Permanently
$respose->getBody(); //Retrieve response content

//The same is possible with FTP
$request = $client->head('ftp://user@pass:host.com/path')->send();
//Remove a file
$client->delete('ftp://user@pass:host.com/path/to/file.php')->send();
//Upload a file
$client->put('ftp://user@pass:host.com/path/to/file.php')
  ->setBody('File content here')
  ->send();
```

A mapping is done between HTTP methods name and FTP calls to maintain the same API. `head` is used for FTP the same way than HTTP, to check if the resource is here.