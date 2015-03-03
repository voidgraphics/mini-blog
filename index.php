<?php
error_reporting(E_ALL); # Activer le reportage des erreurs
ini_set('display_errors', 1); # Afficher les erreurs dans le navigateur
//Définition de l’include_path, à adapter selon votre configuration
set_include_path('configs:controllers:models:'.get_include_path());

//Enregistrement de la fonction à exécuter à chaque nouvelle instanciation
spl_autoload_register(function ($className) {
    include($className . '.class.php');
});

//Gestion de la white list des routes
include('routes.php');
$routeParts = explode('/', $routes['default']);
$a = isset($_REQUEST['a']) ? $_REQUEST['a'] : $routeParts[0];
$e = isset($_REQUEST['e']) ? $_REQUEST['e'] : $routeParts[1];
$route = $a . '/' . $e;
if (!in_array($route, $routes)) {
    header('Location: http://localhost/index.php?a=view&e=error&x=1');
    //À remplacer par une redirection vers view/error/x
}


//Détermination du controleur à utiliser
$controllerName = 'C_' . ucfirst($e);
$controller = new $controllerName;

//Exécution de la fonction correspondant à l’action demandée
$data = call_user_func([$controller,$a]);

#extract parce que je le vaux bien
extract($data);
//$data contient toujours une clé 'view' et une clé 'data'

//Inclusion de la vue maîtresse
include('views/layout.php');