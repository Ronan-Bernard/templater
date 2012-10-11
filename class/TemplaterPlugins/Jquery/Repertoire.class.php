<?php

/**
 * Plugin de test. Ne fait rien à part afficher les params qu'on lui fournit
 * appel : @TEST
 * 
 * @package Templater
 * @author Ronan Bernard - @ronan_php
 */


class TemplaterPlugins_Jquery_Repertoire implements interface_TemplaterPlugin
{
    private $params;
    
    public function __construct(Array $params)
    {
        $this->params = $params;
    }
    
    public function executer()
    {
        if ($this->params[0] == "ready") {
            return $this->readyRepertoire();
        } else {
            return '<div class="exception">Argument incorrect</div>';
        }
    }
    
    private function readyRepertoire()
    {
        $js = '<script type="text/javascript">'
            . '$(document).ready(function(){ '
            ;
        if (count($this->params) > 2) {
            
        }
        $repertoire = $this->params[1];
        $js .= $this->codeRepertoire($repertoire);
        $js .= '});'
            . '</script>'
            ;
        return $js;
    }

    private function codeRepertoire($repertoire)
    {
        $code = '';
        $rep = opendir($repertoire);
        while (false !== ($entry = readdir($rep))) {
            if (($entry != '.') && ($entry != '..')) {
                $code .= file_get_contents($repertoire.$entry);
            }
        }
        closedir($rep);
        return $code;
    }

}
    