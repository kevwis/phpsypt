<?php
/**
 * @namespace Wsk
 * @package Phpsypt
 * @subpackage Standard
 * @category encryption
 * @return Digestic encrypted string
 * @author Kev Wis* <wiskev@gmail.com>
 * @see Jasypt (Java simplified encryption) <http://www.jasypt.org/>
 * @version (beta) 0.1.0
 *
 *
 * (Phpsypt work with Jasypt 1.9)
 *
 * Jasypt is a java library which allows the developer
 * to add basic encryption capabilities to his/her projects
 * with minimum effort, and without the need of having deep
 * knowledge on how cryptography works.
 *
 */

class Wsk_Phpsypt_Standard_Byte_Digester {

  	static protected $_algorithm = 'sha512';
	static protected $_iteration = 1000;

	/**
	 *
	 * @return Array 128 bytes salt (ByteArray)
	 */
	static function generateSalt() {
		$salt = hash ( self::$_algorithm, uniqid () );
		return self::getBytes ( utf8_encode ( $salt ) );
	}

	/**
	 *
	 * @param unknown_type $string
	 * @return Array (ByteArray)
	 */
	static function getBytes($string) {
		$bytes = array_slice ( unpack ( "C*", "\0" . $string ), 1 );
		$bytes = array_map ( 'decbin', $bytes );
		return $bytes;
	}

	/**
	 *
	 * @param Array (ByteArray) $bytes
	 * @return string (ByteString)
	 */
	static function getString($bytes) {
		$bytes = array_map ( 'bindec', $bytes );
		$string = call_user_func_array ( "pack", array_merge ( array ("C*"), $bytes ) );
		return $string;
	}

	/**
	 *
	 * @param multitype $mixed
	 * @param Array (ByteArray) $salt
	 * @return string
	 */
	static function digest($mixed, $salt = null) {
		if (is_null ( $salt )) { $salt = self::generateSalt (); }
		if (is_array ( $mixed )) {
			$mixed = array_merge ( $salt, $mixed );
			for($i = 1; $i <= self::$_iteration; $i ++) {
				$mixed = hash ( self::$_algorithm, self::getString ( $mixed ), true );
				$mixed = self::getBytes ( $mixed );
			}
			$mixed = array_merge ( $salt, $mixed );
			return base64_encode ( self::getString ( $mixed ) );
		} else if (is_string ( $mixed )) {
			$bytes = self::getBytes ( $mixed );
			return self::digest ( $bytes, $salt );
		}
	}
}
