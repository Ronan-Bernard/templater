<?php

/**
 * Micro-moteur de templates.
 * Elle ne fait que du html, donc si c'est tout cassé sur IE, c'est pas sa faute.
 * 
 * @package Templater
 * @author Ronan Bernard - @ronan_php
 */


class Templater
{
    private $layout_code;
    private $html;
    private $blocs;
    private $fonctions;
    private $optionsDefaut = array(
        'templatesRepertoire' => 'templates',
        'extension' => 'php'
    );
    private $options;
    
    public function __construct($layout = 'default', $optionsPassees = array())
    {
        // initialiser les options
        $this->options = array_merge($this->optionsDefaut, $optionsPassees);        
        
        // ouvrir le fichier de layout de template selon la nomenclature prevue
        
        // chemin type : templates/layout_nomlayout.extension
        $layout_file = $this->options['templatesRepertoire'] 
                        . '/layout_' 
                        . $layout 
                        . '.' . $this->options['extension']
                        ;
        if (!$this->layout_code = file_get_contents($layout_file)) {
            throw new Exception('Erreur d\'acc&egrave;s au fichier de layout');
        }
    }
    
    public function affiche($return = false)
    {
        // assembler les blocs dans le layout
        $this->html .= $this->parse($this->layout_code);
        
        
        if ($return) {
            return $this->html;
        } else {
            echo $this->html;
        }
    }
    protected function parse($html)
    {
        $html = $this->parseBlocs($html);
        
        $html = $this->parseFonctions($html);
        
        
        return $html;
    }
    
    private function parseBlocs($html)
    {
        // remplacer les blocs par les bouts de template correspondants
        $expressionBlocs = '/#[A-Z\/\_]+/';
        preg_match_all($expressionBlocs, $html, $this->blocs);

        if (!empty($this->blocs)) {
            foreach ($this->blocs[0] as $bloc) {
                // $bloc est de la forme #REP/FICHIER
                $chemin_bloc = 'templates/' 
                                . strtolower(substr($bloc, 1)) 
                                . '.' . $this->optionsDefaut['extension']
                                ;
                ob_start();
                    include($chemin_bloc);
                    $contenu_bloc = ob_get_contents();
                ob_end_clean();
                $html = str_replace($bloc, $contenu_bloc, $html);
            }
        }
        return $html;
    }
    
    private function parseFonctions($html)
    {
        // [0] contient l'appel complet, [1] contient la fonction sans @, [2] contient les params
        $expressionFonctions = '/(?<=[[:blank:]])@([A-Z\/_]+)({[A-Z0-9a-z,\'\/]+})?/';
        preg_match_all($expressionFonctions, $html, $this->fonctions);
        
        // remplacer les appels de fonction
        if (!empty($this->fonctions)) {
                $params = array();
            for ($i=0; $i < count($this->fonctions[0]); $i++) {
                $preParams = $this->fonctions[2][$i];
                if (!empty($preParams)) {
                    $ligneParams = substr($preParams,1,(strlen($preParams)-2));
                    $tabParams = explode(',',$ligneParams);
                    foreach ($tabParams as $unParam) {
                        $params[] = Static_String::nettoieParams($unParam);
                    }
                }

                // nom du plugin
                $preNomPlugin = explode('/', $this->fonctions[1][$i]);
                $cheminPlugin = 'TemplaterPlugins';
                foreach ($preNomPlugin as $rep) {
                    $cheminPlugin .= '_' . ucfirst(strtolower($rep));
                }
                
                // tentative d'appel du plugin
                if (class_exists($cheminPlugin)) {
                    $plugin = new $cheminPlugin($params);
                    $html = str_replace($this->fonctions[0][$i], $plugin->executer(), $html);
                } else {
                    throw new Exception('Appel d\'un plugin inexistant : ' . $nomPlugin);
                }
            }
        }
        return $html;
    }
    
    
    
    /**
     * Fonction pour remplacer le contenu d'un des blocs
     * @param String bloc, le nom du ###BLOC### , sensible à la casse
     * @param String file, le chemin sous /templates/ du fichier à insérer dans le bloc
     * @param String contenu, alternative à $file, transmettre directement du code html
     */
    public function decorer($bloc, $file, $contenu = '')
    {
        // cible une zone et va la remplacer par un bout de template
    }
    
    
}
