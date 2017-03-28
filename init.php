<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
ini_set("session.cookie_httponly", 1);
session_start();
header("X-Powered-By: speedme-framework");
header("X-Frame-Options: SAMEORIGIN");
error_reporting(E_ALL);
//loading manually
if(is_file('api/library/configuration.php')){
    if(!class_exists('configuration')) {
        include_once('api/library/configuration.php');
    }
}
if(is_file('api/library/core.php')){
    if(!class_exists('core')) {
        include_once('api/library/core.php');
    }
}
if(is_file('api/library/db.php')){
    if(!class_exists('db')) {
        include_once('api/library/db.php');
    }
}
if(is_file('api/library/views.php')){
    if(!class_exists('views')) {
        include_once('api/library/views.php');
    }
}
if(is_file('api/library/helper.php')){
    if(!class_exists('helper')) {
        include_once('api/library/helper.php');
    }
}
//autoload for alternate
spl_autoload_register(function ($name) {

    $parts = explode('\\', $name);
    $namespace_file = '';
    $namespace_name = '';
    if((in_array('helper',$parts) || in_array('model',$parts)) && count($parts) > 3){
        $namespace_file = $parts[2];
        $namespace_name = $parts[0]."\\".$parts[1]."\\".$parts[2]."\\".$parts[3];
    }else if((in_array('helper',$parts) || in_array('model',$parts)) && count($parts) > 2 && count($parts) <= 3){
        $namespace_file = $parts[2];
        $namespace_name = $parts[0]."\\".$parts[1]."\\".$parts[2];
    }
    //print_r($parts);
    $name =  end($parts);
    //echo $name."<br>";
    //echo $namespace_file.":".$namespace_name."<br>";
    if(is_file('api/helpers/helper.'.$name.'.php')){
        if(!class_exists($name)) {
            include_once('api/helpers/helper.' . $name . '.php');
        }
    }else if(is_file('api/helpers/helper.'.$namespace_file.'.php')){
        if(!class_exists($namespace_name)) {
            include_once('api/helpers/helper.' . $namespace_file . '.php');
        }
    }
    if(is_file('api/models/model.'.$name.'.php')){
        if(!class_exists($name)) {
            include_once('api/models/model.' . $name . '.php');
        }
    }else if(is_file('api/models/model.'.$namespace_file.'.php')){
        if(!class_exists($namespace_name)) {
            include_once('api/models/model.' . $namespace_file . '.php');
        }
    }

    if(is_file('api/controllers/controller.'.$name.'.php')){
        if(!class_exists($name)) {
            include_once('api/controllers/controller.' . $name . '.php');
        }
    }else if(is_file('api/controllers/controller.'.$namespace_file.'.php')){
        if(!class_exists($namespace_name)) {
            include_once('api/controllers/controller.' . $namespace_file . '.php');
        }
    }
});
set_error_handler('error_handler');

function error_handler($error_number = 0, $error_string = '', $error_file = '', $error_line = '',$error_context = array()){
    $error_data = "Error code: {$error_number}<br/>";
    $error_data .= "In file: {$error_file}<br/>";
    $error_data .= "Error line: {$error_line}<br/>";
    $error_data .= 'More: '.json_encode($error_context);
    \speedme\core::debug($error_data,$error_string,true);
}