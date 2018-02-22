<?php

if (!function_exists('random_factor')) {
    function random_factor($lang = 'en', $spacing = ' ', $adjectives = 1, $nouns = 1)
    {
        return marcuspi\RandomFactor\Words::create()
            ->language($lang)
            ->spacing($spacing)
            ->adjectives($adjectives)
            ->nouns($nouns)
            ->generate();
    }
}
