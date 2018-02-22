<?php
declare(strict_types=1);

namespace marcuspi\RandomFactor;

class Words
{
    private static $languages = [
        'no' => 'no-nb',
        'en' => 'en'
    ];
    
    private $language;
    private $spacing;
    private $nouns;
    private $adjectives;
    
    /**
     * Creates new Words.
     *
     * @access public
     * @param string $language The language to use (default: "en")
     * @param string $spacing Character(s) to used to split the words (default: " ")
     * @param int $nouns Number of nouns (default: 1)
     * @param int $adjectives Number of adjectives (default: 1)
     */
    public function __construct($language = "en", $spacing = " ", $nouns = 1, $adjectives = 1)
    {
        $this->language($language);
        $this->spacing($spacing);
        $this->nouns($nouns);
        $this->adjectives($adjectives);
    }
    
    /**
     * Sets which language that should be used
     *
     * @access public
     * @param string $language One of "no", "en".
     * @return self
     */
    public function language(string $language): Words
    {
        if (!array_key_exists(mb_strtolower($language), static::$languages)) {
            throw new \Exception('Language \'' . $language . '\' not found');
        }
        
        $this->language = mb_strtolower($language);
        
        return $this;
    }
    
    /**
     * Sets the character(s) to used to split the words
     *
     * @access public
     * @param string $spacing
     * @return self
     */
    public function spacing(string $spacing): Words
    {
        $this->spacing = $spacing;
        
        return $this;
    }
    
    /**
     * Sets the number of nouns
     *
     * @access public
     * @param int $nouns A positive integer
     * @return self
     */
    public function nouns(int $nouns): Words
    {
        if ($nouns < 0) {
            throw new \Exception('Number of nouns must be a positive integer');
        }
        
        $this->nouns = $nouns;
        
        return $this;
    }
    
    /**
     * Sets the number of adjectives
     *
     * @access public
     * @param int $adjectives A positive integer
     * @return self
     */
    public function adjectives(int $adjectives): Words
    {
        if ($adjectives < 0) {
            throw new \Exception('Number of adjectives must be a positive integer');
        }
        
        $this->adjectives = $adjectives;
        
        return $this;
    }
    
    /**
     * Static creation.
     *
     * @access public
     * @static
     * @return self
     */
    public static function create()
    {
        return new static;
    }
    
    /**
     * Generates the random words.
     *
     * @access public
     * @return string
     */
    public function generate(): string
    {
        
        $wordlist = $this->readWordList();
        
        $words = [];
        
        for ($i = 0; $i < $this->adjectives; $i++) {
            $words[] = $wordlist['adjectives'][random_int(0, count($wordlist['adjectives']) - 1)];
        }
        
        for ($i = 0; $i < $this->nouns; $i++) {
            $words[] = $wordlist['nouns'][random_int(0, count($wordlist['nouns']) - 1)];
        }
        
        return implode($this->spacing, $words);
    }
    
    /**
     * Alias for self::generate()
     *
     * @access public
     * @return string
     */
    public function __toString(): string
    {
        return $this->generate();
    }
    
    private function readWordList(): array
    {
        $wordfile = __DIR__ . '/lang/' . static::$languages[$this->language] . '.json';
        
        if (!file_exists($wordfile)) {
            throw new \Exception('Language file \'' . $wordfile . '\' not found');
        }
        
        return json_decode(file_get_contents($wordfile), true);
    }
}
