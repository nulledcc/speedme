<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class server extends helper {
        /**
         * @return int
         */
        public static function load(){
            if(function_exists('sys_getloadavg')){
                $data = sys_getloadavg();
                if(isset($data[0])){
                    return $data[0]*100;
                }
            }else if(function_exists('shell_exec')){
                $str = substr(strrchr(shell_exec("uptime"),":"),1);
                $avs = array_map("trim",explode(",",$str));
                if(isset($avs[0])){
                    return $avs[0]*100;
                }
            }
            return 0;
        }
    }
}