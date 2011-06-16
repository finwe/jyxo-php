<?php

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

namespace Jyxo\Input\Filter;

/**
 * Filter for prepending "http://" if missing.
 *
 * @category Jyxo
 * @package Jyxo\Input
 * @subpackage Filter
 * @copyright Copyright (c) 2005-2011 Jyxo, s.r.o.
 * @license https://github.com/jyxo/php/blob/master/license.txt
 * @author Jaroslav Hanslík
 */
class SanitizeUrl extends \Jyxo\Input\Filter\AbstractFilter
{
	/**
	 * Filters a value.
	 *
	 * @param mixed $in Input value
	 * @return mixed
	 */
	protected function filterValue($in)
	{
		if (!preg_match('~^(?:http|ftp)s?://~i', $in)) {
			$in = 'http://' .  $in;
		}

		return $in;
	}
}