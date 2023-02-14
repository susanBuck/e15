<?php

class StringProcessor
{
    # Properties
    private $inputString;
     
    # Methods
    public function __construct($inputString)
    {
        $this->inputString = $inputString;
    }

    public function isBigWord() 
    {
        return strlen($this->inputString) > 10;
    }
 
    # DEMO: This function is not complete
    public function isPalindrome()
    {
        return false;
    }

    # DEMO: This function is not complete
    public function getVowelCount()
    {
        return rand(0, 5);
    }
}