<?php

require_once(__DIR__.'/src/Core.php');

if (!function_exists('random_factor')) {
	function random_factor($lang = 'en', $spacing = ' ', $adjectives = 1, $nouns = 1) {
		return RandomFactor\Core::generate($lang, $spacing, $adjectives, $nouns);
	}
}