<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class session extends helper {
        private static $session_name = 'PHPSESSID';

        /**
         * session constructor.
         * @param string $session_name
         */
        function __construct($session_name = 'PHPSESSID')
        {
            self::$session_name = $session_name;
            return session_name($session_name);
        }

        /**
         * @param bool $name
         * @param bool $value
         * @return mixed
         */
        public static function set($name = false, $value = false){
            $_SESSION[$name] = $value;
            return $_SESSION[$name];
        }

        /**
         * @param bool $name
         * @param bool $default
         * @return bool
         */
        public static function get($name = false, $default = false){
            if(isset($_SESSION[$name])){
                return $_SESSION[$name];
            }else if($default !== false){
                $_SESSION[$name] = $default;
                return $default;
            }else{
                return false;
            }
        }

        /**
         * @param array $option
         * @return session
         */
        public static function init($option = []){
            if(session_id()){
                session_regenerate_id(true);
            }else{
                session_start($option);
            }
            return new self;
        }
        public static function id(){
            if($id = session_id()){
               return $id;
            }
            return false;
        }
        /**
         * @return session
         */
        public static function destroy(){
            if(session_id()) {
                @session_destroy();
            }
            return new self;
        }
    }
}