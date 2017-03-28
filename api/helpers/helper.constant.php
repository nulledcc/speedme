<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{

    class constant extends helper {
        private static $constant_name = false;

        /**
         * @param bool $constant_name
         * @return constant
         */
        public static function get($constant_name = false){
            if($constant_name){
                self::$constant_name = $constant_name;
            }
            return new self;
        }

        /**
         * @param bool $constant_name
         * @param bool $value
         * @param bool $to_upper_case
         * @return constant
         */
        public static function set($constant_name = false, $value = false, $to_upper_case = true){
            if($constant_name){
                self::$constant_name = $constant_name;
                if($to_upper_case){
                    self::$constant_name = strtoupper(self::$constant_name);
                }
                self::$constant_name = str_replace(' ','_',self::$constant_name);
                $value = ($value !== false) ? $value :  self::$constant_name;
                define(self::$constant_name,$value);
            }
            return new self;
        }

        /**
         * @return bool|mixed
         */
        public function constant(){
            if(defined(self::$constant_name)){
                return constant(self::$constant_name);
            }else{
                return self::$constant_name;
            }
        }
    }
}