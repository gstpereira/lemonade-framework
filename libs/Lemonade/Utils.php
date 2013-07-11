<?php
/**
* Class for functions Utils framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

/**
* Show data
* @param array $data data for show
* @return Void
*/
function pr($data) {
	echo "<pre>" . print_r($data, true) . "</pre>";
}