Templater
=========

Ma classe personnelle pour gérer des templates hors de tout CMS/framework standard. 
Purement expérimental, je ne pense pas que ça ait d'intérêt pour quelqu'un d'autre moi (au moins pas tant que je n'aurai pas écrit une centaine de plugins, un mécanisme de gestion du cache, et une doc adaptée).

Autoload
========
J'utilise généralement la même classe d'autoload dans toutes mes applications en php pur, je ne l'ai pas inclus ici mais les classes de Templater se basent dessus :

function __autoload($class_name){
	$class_path = str_replace('_', '/', $class_name);
	require_once 'class/' . $class_path . '.class.php';
}


Usage
=====

Instancier avec en argument le layout à utiliser, puis exécuter affiche() pour 
envoyer à l'affichage