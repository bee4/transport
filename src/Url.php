<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

/**
 * Define a valid URL component
 * Allow to check if it's a valid Url and define all components
 * @package Bee4\Transport
 *
 * @method string|Url scheme(string $value = null) Getter and setter for scheme property
 * @method string|Url host(string $value = null) Getter and setter for host property
 * @method int|Url port(int $value = null) Getter and setter for port property
 * @method string|Url user(string $value = null) Getter and setter for user property
 * @method string|Url pass(string $value = null) Getter and setter for pass property
 * @method string|Url path(string $value = null) Getter and setter for path property
 * @method string|Url query(string $value = null) Getter and setter for query property
 * @method string|Url fragment(string $value = null) Getter and setter for fragment property
 */
class Url
{
	/**
	 * @var string
	 */
	protected $scheme;

	/**
	 * @var string
	 */
	protected $host;

	/**
	 * @var int
	 */
	protected $port;

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
	 * Standard ports for specific schemes
	 * @var array
	 */
	private static $defaultPorts = [
		'http' => 80,
		'https' => 443,
		'ftp' => 21,
		'ssh' => 22
	];

	/**
	 * @param string $url
	 */
	public function __construct( $url ) {
		if( !is_string($url) ) {
			throw new \InvalidArgumentException('url given must be a valid string!');
		}
		if( !Url::isValid($url) ) {
			throw new \InvalidArgumentException('url given is not a valid url (according to PHP FILTER_VALIDATE_URL). '.$url);
		}

		//Define default entries
		if( ($parsed = parse_url($url)) !== false ) {
			foreach( $parsed as $name => $value ) {
				$this->$name($value);
			}
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

			if( trim($this->port) != '' ) {
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
				return $this->retrieve($name);
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
	 * Transform to string with dynamic cast
	 * @return String
	 */
	public function __toString() {
		try {
			return $this->toString();
		} catch (\Exception $ex) {
			return __CLASS__.'::INVALID';
		}
	}

	/**
	 * Fill a property with the given value
	 * @param string $name
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	protected function populate( $name, $value ) {
		switch( $name ) {
			case 'port':
				if( !is_int($value) ) {
					throw new \InvalidArgumentException('Value given to set "'.$name.'" must be a valid int!!');
				}
				if( isset(self::$defaultPorts[$this->scheme]) && $value == self::$defaultPorts[$this->scheme] ) {
					break;
				}
				$this->$name = $value;
				break;
			case 'host':
				if(strpos($value, ':') !== false ) {
					$tmp = explode(':', $value);
					$this->port((int)$tmp[1]);
					$value = $tmp[0];
				}
			default:
				if( !is_string($value) ) {
					throw new \InvalidArgumentException('Value given to set "'.$name.'" must be a valid string!!');
				}
				$this->$name = $value;
				break;
		}
	}

	/**
	 * Property name to retrieve from the current object
	 * This function is defined only for the special port case
	 * @param string $name
	 * @return mixed
	 */
	protected function retrieve($name) {
		switch( $name ) {
			case 'port':
				if( is_null($this->$name) && isset(self::$defaultPorts[$this->scheme]) ) {
					return self::$defaultPorts[$this->scheme];
				}
			default:
				return $this->$name;
		}
	}
}
