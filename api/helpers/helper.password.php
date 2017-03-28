<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    use speedme\configuration;
    class password extends helper {
        public static $generated_password = null;
        public static $action = null;

        /**
         * @return password
         */
        public static function generate(){
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789*%&#$@";
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            self::$generated_password = implode($pass);
            self::$action = 'generated_password';
            return new self;
        }

        /**
         * @return bool|null
         */
        public function get(){
            if(self::$action == 'generated_password'){
                return self::$generated_password;
            }else{
                return false;
            }
        }

        /**
         * @param bool $password
         * @return bool|string
         */
        public static function hash_pass($password = false){
            if($password !== false){
               $password =  md5(md5($password).configuration\main::$security_key.md5($password));
            }
            return $password;
        }
    }
}