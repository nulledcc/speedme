<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
$memory_usage_start = memory_get_usage();
$start_time = microtime(true);
include('init.php');
use speedme\views\view;
use speedme\core;
\speedme\helper\session::set('LAST_REQUEST_URI',$_SERVER['REQUEST_URI']);
view::load();
$end_time = microtime(true);
$memory_usage_end = memory_get_usage();

if(core::ip() == "127.0.0.1"){
    echo "Load time ".($end_time-$start_time)." seconds. - Memory ".($memory_usage_end-$memory_usage_start)." bytes or ".(($memory_usage_end-$memory_usage_start)/1024)." MB";
}