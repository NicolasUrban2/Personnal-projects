<?php

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    // application name
    $appName = "mazeGenerator";

    // default action
    $action = "formulaire"; // form

    if(key_exists("action", $_POST))
    {
        $action = $_POST['action'];
    }

    require_once 'lib/core.php';
    require_once 'application/controller/mainController.php';
    
    foreach(glob('application/model/*.class.php') as $model)
    {
        include_once $model;
    }

    session_start();
    
    $context = context::getInstance();
    $context->init($appName);

    $view = $context->executeAction($action, $_POST);
    
    if($view === false)
    {
        echo "Action non reconnue";
        die;
    }
    elseif($view!=context::NONE)
    {
        $template_view="application/view/".$action.$view.".php";
        include("application/layout/".$context->getLayout().".php");    // template_view included in the layout
    }
    
?>