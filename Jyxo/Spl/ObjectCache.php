<?php declare(strict_types = 1);

/**
 * Jyxo PHP Library
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/jyxo/php/blob/master/license.txt
 */

namespace Jyxo\Spl;

/**
 * Simple object cache so we don't have to create them or write caching over again.
 *
 * Example:
 * <code>
 * $key = 'User_Friends/' . $user->username();
 * return \Jyxo\Spl\ObjectCache::get($key) ?: \Jyxo\Spl\ObjectCache::set($key, new \User\Friends($this->context, $user));
 * </code>
 *
 * @category Jyxo
 * @package Jyxo\Spl
 * @copyright Copyright (c) 2005-2011 Jyxo, s.r.o.
 * @license https://github.com/jyxo/php/blob/master/license.txt
 * @author Jakub Tománek
 */
class ObjectCache implements \IteratorAggregate
{
	/**
	 * Object storage.
	 *
	 * @var array
	 */
	private $storage = [];

	/**
	 * Returns default storage for static access.
	 *
	 * @return \Jyxo\Spl\ObjectCache
	 */
	public static function getInstance(): self
	{
		static $instance = null;
		if (null === $instance) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Returns an object from the default storage.
	 *
	 * @param string $key Object key
	 *
	 * @return SplObject
	 */
	public static function get($key)
	{
		return self::getInstance()->$key;
	}

	/**
	 * Clear the whole storage.
	 *
	 * @return \Jyxo\Spl\ObjectCache
	 */
	public function clear(): self
	{
		$this->storage = [];
		return $this;
	}

	/**
	 * Saves an object into the default storage.
	 *
	 * @param string $key Object key
	 * @param SplObject $value Object
	 *
	 * @return SplObject saved object
	 */
	public static function set($key, $value)
	{
		self::getInstance()->$key = $value;
		return $value;
	}

	/**
	 * Returns an object from an own storage.
	 *
	 * @param string $key Object key
	 *
	 * @return SplObject
	 */
	public function __get($key)
	{
		return isset($this->storage[$key]) ? $this->storage[$key] : null;
	}

	/**
	 * Saves an object into an own storage.
	 *
	 * @param string $key Object key
	 * @param SplObject $value Object
	 */
	public function __set($key, $value)
	{
		$this->storage[$key] = $value;
	}

	/**
	 * Returns if there's an object with key $key in the storage.
	 *
	 * @param string $key Object key
	 * @return boolean
	 */
	public function __isset($key)
	{
		return isset($this->storage[$key]);
	}

	/**
	 * Deletes an object with key $key from the storage.
	 *
	 * @param mixed $key Object key
	 */
	public function __unset($key)
	{
		unset ($this->storage[$key]);
	}

	/**
	 * Returns an iterator.
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->storage);
	}
}
