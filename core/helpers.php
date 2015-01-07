<?php
/**
 * ============ HELPERS LIBS =============
 * 
 * This is a helper functon lists 
 * 
 * =======================================
 */


/**
 * Convert array, so return is an array
 * 
 * @param array|object $input
 * @return array
 */
function convertArray($input)
{
	if (is_object($input))
	{
		$json = json_encode($input);
		$input = json_decode($json, 1);
	}

	return is_array($input) ? $input : array();
}

/**
 * Determine if a string contains a substring
 * 
 * @param string $substring
 * @param string $string
 * @return bool
 */
function contains($string, $substring)
{
	return (strpos($string, $substring) !== false);
}