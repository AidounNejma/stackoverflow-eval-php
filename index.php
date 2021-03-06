<?php

session_start();
use App\database\Database;
use App\Model\UserModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#Pour avoir un print_r amélioré
function debug( $arg ){

    echo "<div style='background:#fda500; z-index:1000; padding:15px;'>";

        $trace = debug_backtrace();
        //debug_backtrace() : fonction interne de PHP qui retourne un array avec des infos à l'endroit où l'on fait appel à la fonction.

        echo "<p>Debug demandé dans le fichier : ". $trace[0]['file'] ." à la ligne ". $trace[0]['line'] ."</p>";

        echo "<pre>";
            print_r( $arg );
        echo "</pre>";

    echo "</div>";
}

require 'vendor/autoload.php';

class Application
{
    const AUTHORIZED_PAGES = [
        'index' => [
            'controller' => 'QuestionController',
            'method' => 'index'
        ],
        'question' => [
            'controller' => 'QuestionController',
            'method' => 'showQuestion'
        ],
        'answer' => [
            'controller' => 'AnswerController',
            'method' => 'create'
        ],
        'register' => [
            'controller' => 'UserController',
            'method' => 'register'
        ],
        'login' => [
            'controller' => 'UserController',
            'method' => 'logIn'
        ],
        'logout' => [
            'controller' => 'UserController',
            'method' => 'logout'
        ],
        'ask' => [
            'controller' => 'QuestionController',
            'method' => 'pageAskQuestion'
        ],
        'askQuestion' => [
            'controller' => 'QuestionController',
            'method' => 'askQuestion'
        ],
        'error404' => [
            'controller' => 'ErrorController',
            'method' => 'error404'
        ],
    ];

    const ADMIN_PAGES = [
        'allQuestions' => [
            'controller' => 'QuestionController',
            'method' => 'allQuestionsAdmin'
        ],
        'allUsers' => [
            'controller' => 'UserController',
            'method' => 'allUsersAdmin'
        ],
        'allAnswers' => [
            'controller' => 'AnswerController',
            'method' => 'allAnswersAdmin'
        ],
        'deleteQuestion' => [
            'controller' => 'QuestionController',
            'method' => 'deleteQuestion'
        ],
        'editQuestion' => [
            'controller' => 'QuestionController',
            'method' => 'editQuestion'
        ],
        'deleteAnswer' => [
            'controller' => 'AnswerController',
            'method' => 'deleteAnswer'
        ],
        'editAnswer' => [
            'controller' => 'AnswerController',
            'method' => 'editAnswer'
        ],
        'deleteUser' => [
            'controller' => 'UserController',
            'method' => 'deleteUser'
        ],
        'editUser' => [
            'controller' => 'UserController',
            'method' => 'editUser'
        ],
    ];

    const DEFAULT_ROUTE = 'index';

    private function match($route_name)
    {   

        #Je récupère l'id de l'utilisateur connecté
        if(isset($_SESSION['id']))
        {
            #Je créé un objet User
            $userModel = new UserModel();
            $userConnected = $_SESSION['id'];

            #Je recherche l'utilisateur connecté dans la bdd
            $user = $userModel->findById($userConnected);

            #Je récupère le statut de l'utilisateur connecté
            $userStatus = $user[0]->getStatus();
        }
        

        // Je vérifie si la clé existe dans la liste des pages autorisées
        if (isset(self::AUTHORIZED_PAGES[$route_name])) 
        {
            $route = self::AUTHORIZED_PAGES[$route_name];
        }   #Si la route entrée est une page admin, et que le statut de la personne connectée est = 1
            elseif(isset(self::ADMIN_PAGES[$route_name]) && $userStatus == 1)
        {   #Alors on retourne la page Admin
            $route = self::ADMIN_PAGES[$route_name];
        } 
            else {
            $route = self::AUTHORIZED_PAGES['error404'];
        }

        return $route;
    }

    public function run()
    {
        // Je récupère la route demandée dans l'url
        // Si la page n'est pas spécifiée (ex: on arrive pour la première fois sur le site)
        // On redirige vers la page d'accueil
        $route_name = $_GET['page'] ?? self::DEFAULT_ROUTE;

        // je vérifie si la route demandée existe
        $route = $this->match($route_name);

        // dump($route);

        // j'instancie le controller correspondant à la route demandée
        $controller_name = 'App\Controller\\' . $route['controller'];
        $controller = new $controller_name();
        // j'appelle la méthode correspondante à la route demandée
        $method_name = $route['method'];
        $controller->$method_name();

    }
    
}


$application = new Application();
$application->run();

