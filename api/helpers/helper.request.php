<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class request extends helper {

        public static $REQUEST_KEY = false;
        public static $REQUEST_VALUE = false;
        public static $xss_filter = false;

        /**
         * @param bool $REQUEST_KEY
         * @param bool $default
         * @param bool $array_request
         * @return bool|string
         */
        public static function get($REQUEST_KEY = false, $default = false,$array_request = false){

            if($REQUEST_KEY !== false && isset($_REQUEST[$REQUEST_KEY])){
                if(!$array_request && is_array($_REQUEST[$REQUEST_KEY])){
                    if(isset($_REQUEST[$REQUEST_KEY][0])){
                        $_REQUEST[$REQUEST_KEY] = $_REQUEST[$REQUEST_KEY][0];
                    }else{
                        return $default;
                    }
                }
                $REQUEST_KEY = htmlspecialchars(htmlentities($REQUEST_KEY));
                self::$REQUEST_KEY = $REQUEST_KEY;
                if(self::$xss_filter){
                    if($array_request){
                        $_REQUEST[$REQUEST_KEY] = array_map("htmlentities",$_REQUEST[$REQUEST_KEY]);
                        $_REQUEST[$REQUEST_KEY] = array_map("htmlspecialchars",$_REQUEST[$REQUEST_KEY]);
                    }else{
                        self::$REQUEST_VALUE = htmlspecialchars(htmlentities($_REQUEST[$REQUEST_KEY]));
                    }

                }else{
                    self::$REQUEST_VALUE = $_REQUEST[$REQUEST_KEY];
                }
                return self::$REQUEST_VALUE;
            }else if($default !== false){
                $_REQUEST[$REQUEST_KEY] = $default;
                self::$REQUEST_VALUE = $_REQUEST[$REQUEST_KEY];
                return self::$REQUEST_VALUE;
            }
            return false;
        }

        /**
         * @param bool $REQUEST_KEY
         * @param bool $value
         * @param bool $to_upper_case
         * @return bool|mixed
         */
        public static function set($REQUEST_KEY = false, $value = false, $to_upper_case = false){
            if($REQUEST_KEY){
                self::$REQUEST_KEY = $REQUEST_KEY;
                if($to_upper_case){
                    self::$REQUEST_KEY = strtoupper(self::$REQUEST_KEY);
                }
                self::$REQUEST_KEY = str_replace(' ','_',self::$REQUEST_KEY);
                self::$REQUEST_VALUE = ($value !== false) ? $value :  self::$REQUEST_KEY;
                $_REQUEST[self::$REQUEST_KEY] = self::$REQUEST_VALUE;
                return self::$REQUEST_VALUE;
            }
            return false;
        }
    }
}