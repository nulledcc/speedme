<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class get extends helper {
        public static $GET_KEY = false;
        public static $GET_VALUE = false;

        /**
         * @param bool $GET_KEY
         * @param bool $default
         * @param bool $filter
         * @param bool $array_request
         * @return bool
         */
        public static function get($GET_KEY = false, $default = false,$filter = false,$array_request = false){
            self::$GET_VALUE = false;
            if($GET_KEY !== false && isset($_GET[$GET_KEY])){
                if(!$array_request && is_array($_GET[$GET_KEY])){
                    if(isset($_GET[$GET_KEY][0])){
                        $_GET[$GET_KEY] = $_GET[$GET_KEY][0];
                    }else{
                        return $default;
                    }
                }
                $GET_KEY = htmlspecialchars(htmlentities($GET_KEY));
                self::$GET_KEY = $GET_KEY;
                self::$GET_VALUE = $_GET[$GET_KEY];
            }else if($default !== false){
                $_GET[$GET_KEY] = $default;
                self::$GET_VALUE = $_GET[$GET_KEY];

            }
            if($filter && isset($_GET[$GET_KEY])){
                if($filter == 'int'){
                    if($array_request){
                        $_GET[$GET_KEY] = array_map("is_numeric",$_GET[$GET_KEY]);
                    }else if(!is_numeric(self::$GET_VALUE)){
                        self::$GET_VALUE = $default;
                    }
                }
                if($filter == 'xss'){
                    if($array_request){
                        $_GET[$GET_KEY] = array_map("htmlentities",$_GET[$GET_KEY]);
                        $_GET[$GET_KEY] = array_map("htmlspecialchars",$_GET[$GET_KEY]);
                    }else{
                        self::$GET_VALUE = htmlspecialchars(htmlentities($_GET[$GET_KEY]));
                    }
                }
            }
            return self::$GET_VALUE;
        }

        /**
         * @param bool $GET_KEY
         * @param bool $value
         * @param bool $to_upper_case
         * @return bool|mixed
         */
        public static function set($GET_KEY = false, $value = false, $to_upper_case = false){
            if($GET_KEY){
                self::$GET_KEY = $GET_KEY;
                if($to_upper_case){
                    self::$GET_KEY = strtoupper(self::$GET_KEY);
                }
                self::$GET_KEY = str_replace(' ','_',self::$GET_KEY);
                self::$GET_VALUE = ($value !== false) ? $value :  self::$GET_KEY;
                $_GET[self::$GET_KEY] = self::$GET_VALUE;
                return self::$GET_VALUE;
            }
            return false;
        }
    }
}