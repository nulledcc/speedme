<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class shield extends helper {
        private static $access_level = 0;
        private static $this_level = 0;

        /**
         * door constructor.
         * @param int $this_level
         * @param int $access_level
         */
        function __construct($this_level = 0, $access_level = 0){
            self::$access_level = $access_level;
            self::$this_level = $this_level;
            return new self;
        }

        /**
         * @return bool
         */
        public static function check(){
            if(!is_array(self::$access_level) && self::$this_level == self::$access_level){
                return true;
            }else if(is_array(self::$access_level) && in_array(self::$this_level,self::$access_level)){
                return true;
            }else{
                return false;
            }
        }
    }
}