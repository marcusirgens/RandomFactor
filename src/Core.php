<?php

namespace RandomFactor;

class Core 
{
    private static $languages = [
        'no' => 'no',
        'en' => 'en'
    ];
    
    private static $adjectives = [];
    private static $nouns = [];

    private static $adjective_count = 0;
    private static $noun_count = 0;

    private static $imported_lang = '';
    private static $imported = false;
    
    public static function generate($lang, $spacing, $adjectives, $nouns) {

        // Doing this check here increases performance
        if((self::$imported_lang != $lang) || !self::$imported) { 
            self::import_lang($lang);
        }

        return  self::$adjectives[rand(0,  self::$adjective_count - 1)] . 
                $spacing . 
                self::$nouns[rand(0,  self::$noun_count - 1)];
 
    }
    
    private static function import_lang($lang) {
            if (!in_array($lang, self::$languages)) {
                throw new \Exception('Language <b>' . $lang . '</b> not found');
            }
            
            if (!file_exists(__DIR__ . '/lang/' . $lang . '.json')) {
                throw new \Exception('Language file <b>' . __DIR__ . '/lang/' . $lang . '.json</b> not found');
            }
            
            $wordlist = json_decode(file_get_contents(__DIR__ . '/lang/' . $lang . '.json'), TRUE);
            
            self::$adjectives = $wordlist['adjectives'];
            self::$adjective_count = $wordlist['data']['count']['adjectives'];
            
            self::$nouns = $wordlist['nouns'];
            self::$noun_count = $wordlist['data']['count']['nouns'];
            
            self::$imported_lang = $lang;
            self::$imported = true;
            
    }
}
?>