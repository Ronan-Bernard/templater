<?php

/**
 * Plugin de test. Ne fait rien à part afficher les params qu'on lui fournit
 * appel : @TEST
 * 
 * @package Templater
 * @author Ronan Bernard - @ronan_php
 */


class TemplaterPlugins_Test implements interface_TemplaterPlugin
{
    public static function executer(Array $params)
    {
    
        return 'test';
    }
        
}
    