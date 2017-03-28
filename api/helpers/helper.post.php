<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class post extends helper {
        public static $POST_KEY = false;
        public static $POST_VALUE = false;

        /**
         * @param bool $POST_KEY
         * @param bool $default
         * @param bool $filter
         * @param bool $array_request
         * @return bool
         */
        public static function get($POST_KEY = false, $default = false,$filter = false,$array_request = false){
            self::$POST_VALUE = false;
            if($POST_KEY !== false && isset($_POST[$POST_KEY])){
                if(!$array_request && is_array($_POST[$POST_KEY])){
                    if(isset($_POST[$POST_KEY][0])){
                        $_POST[$POST_KEY] = $_POST[$POST_KEY][0];
                    }else{
                        return $default;
                    }
                }
                $POST_KEY = htmlspecialchars(htmlentities($POST_KEY));
                self::$POST_KEY = $POST_KEY;
                self::$POST_VALUE = $_POST[$POST_KEY];
            }else if($default !== false){
                $_POST[$POST_KEY] = $default;
                self::$POST_VALUE = $_POST[$POST_KEY];

            }
            if($filter && isset($_POST[$POST_KEY])){
                if($filter == 'int'){
                    if($array_request){
                        $_POST[$POST_KEY] = array_map("is_numeric",$_POST[$POST_KEY]);
                    }else if(!is_numeric(self::$POST_VALUE)){
                        self::$POST_VALUE = $default;
                    }
                }
                if($filter == 'xss'){
                    if($array_request){
                        $_POST[$POST_KEY] = array_map("htmlentities",$_POST[$POST_KEY]);
                        $_POST[$POST_KEY] = array_map("htmlspecialchars",$_POST[$POST_KEY]);
                    }else{
                        self::$POST_VALUE = htmlspecialchars(htmlentities($_POST[$POST_KEY]));
                    }
                }
            }
            return self::$POST_VALUE;
        }

        /**
         * @param bool $POST_KEY
         * @param bool $value
         * @param bool $to_upper_case
         * @return bool|mixed
         */
        public static function set($POST_KEY = false, $value = false, $to_upper_case = false){
            if($POST_KEY){
                self::$POST_KEY = $POST_KEY;
                if($to_upper_case){
                    self::$POST_KEY = strtoupper(self::$POST_KEY);
                }
                self::$POST_KEY = str_replace(' ','_',self::$POST_KEY);
                self::$POST_VALUE = ($value !== false) ? $value :  self::$POST_KEY;
                $_POST[self::$POST_KEY] = self::$POST_VALUE;
                return self::$POST_VALUE;
            }
            return false;
        }
    }
}