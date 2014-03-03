<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Http
 */

namespace Bee4\Http;

/**
 * Define a valid URL component
 * Allow to check if it's a valid Url and define all components
 * @package Bee4\Http
 */
class Url
{
	/**
	 * @var string
	 */
	protected $scheme = 'http';

	/**
	 * @var string
	 */
	protected $host;

	/**
	 * @var int
	 */
	protected $port = 80;

	/**
	 * @var string
	 */
	protected $user;

	/**
	 * @var string
	 */
	protected $pass;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var string
	 */
	protected $query;

	/**
	 * @var string
	 */
	protected $fragment;

	/**
	 * @param string $url
	 */
	public function __construct( $url ) {
		if( !is_string($url) ) {
			throw new \InvalidArgumentException('url given must be a valid string!');
		}
		if( !Url::isValid($url) ) {
			throw new \InvalidArgumentException('url given is not a valid url (according to PHP FILTER_VALIDATE_URL)');
		}

		$parsed = parse_url($url);
		foreach( $parsed as $name => $value ) {
			$this->populate($name, $value);
		}
	}

	/**
	 * Check if the given string is an URL or not
	 * @param string $url
	 * @return boolean
	 */
	public static function isValid($url) {
		return filter_var($url, FILTER_VALIDATE_URL)!==false;
	}

	/**
	 * Check if the current URL use Basic Auth or not
	 * @return boolean
	 */
	public function hasAuth() {
		return isset($this->user)&&isset($this->pass);
	}

	/**
	 * Rebuilt the URL with all known parts
	 * @return string
	 */
	public function toString() {
		$url = $this->scheme.':';
		if( trim($this->host) != '' ) {
			$url .= '//';
			if( trim( $this->user ) != '' ) {
				$url .= $this->user.((trim($this->pass) != '')?':'.$this->pass:'').'@';
			}
			$url .= $this->host;

			if( trim($this->port) != '' && $this->port != 80 ) {
				$url .= ':'.$this->port;
			}
		}

		$url .= (trim($this->path) != '')?$this->path:'';
		$url .= (trim($this->query) != '')?'?'.$this->query:'';
		$url .= (trim($this->fragment) != '')?'#'.$this->fragment:'';

		if( !self::isValid($url) ) {
			throw new \RuntimeException('Built URL is not a valid one: '.$url);
		}

		return $url;
	}

	/**
	 * Encapsulate all setters / getters and method calls
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 * @throws \BadMethodCallException
	 */
	public function __call($name, array $arguments) {
		//Define getter and setter for each valid property
		if(property_exists($this, $name)) {
			if( count( $arguments ) == 0 ) {
				return $this->$name;
			} elseif( count( $arguments ) == 1 ) {
				$this->populate($name, $arguments[0]);
				return $this;
			} else {
				throw new \BadMethodCallException('Invalid parameters given for: '.$name);
			}
		} else {
			throw new \BadMethodCallException('Invalid method in Url implementation: '.$name);
		}
	}

	/**
	 *
	 * @param type $name
	 * @param type $value
	 * @throws \InvalidArgumentException
	 */
	protected function populate( $name, $value ) {
		switch( $name ) {
			case 'port':
				if( !is_int($value) ) {
					throw new \InvalidArgumentException('Value given to set "'.$name.'" must be a valid int!!');
				}
				$this->$name = (int)$value;
				break;
			default:
				if( !is_string($value) ) {
					throw new \InvalidArgumentException('Value given to set "'.$name.'" must be a valid string!!');
				}
				$this->$name = $value;
				break;
		}
	}
}
