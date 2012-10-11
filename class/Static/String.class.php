<?php

/**
 * @package Templater
 * @author Ronan Bernard - @ronan_php
 */

class Static_String
{
    private $params;
    
    static function nettoieParams($t)
    {
        $t = trim($t);
        if ($t[0] == "'") {
            $t = substr($t,1,(strlen($t)-2));
        }
        return $t;
    }
}