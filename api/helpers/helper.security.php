<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    use speedme\configuration;

    class security extends helper {
        private static $token = null;
        private static $action = 'token';

        /**
         * @return security
         */
        public static function generate(){
            self::$token = md5(md5(uniqid()).configuration\main::$security_key);
            return new self;
        }

        /**
         * @param string $indent
         * @return null
         */
        public function token($indent = 'token'){
            if(isset($_SESSION[$indent]) && self::$action == 'session'){
                return $_SESSION[$indent];
            }else if(isset($_COOKIE[$indent]) && self::$action == 'cookie'){
                return $_COOKIE[$indent];
            }
            return self::$token;
        }

        /**
         * @return security
         */
        public static function session(){
            self::$action = 'session';
            return new self;
        }

        /**
         * @return security
         */
        public static function cookie(){
            self::$action = 'cookie';
            return new self;
        }

        /**
         * @param array $data
         * @return string
         */
        public static function data_token($data = array()){
            $data_keys = implode(",",array_keys($data));
            $data_values = implode(",",$data);
            return md5(md5($data_keys).configuration\main::$security_key.md5($data_values));
        }

        /**
         * @param string $indent
         * @return mixed
         */
        public function to_session($indent = 'token'){
            $_SESSION[$indent] = self::$token;
            return $_SESSION[$indent];
        }

        /**
         * @param string $indent
         * @param int $timestamp
         * @param string $path
         * @param string $domain
         * @param bool $secure
         * @param bool $http_only
         */
        public function to_cookie($indent = 'token', $timestamp = 0, $path = '', $domain='', $secure = false, $http_only = false){
            setcookie($indent, self::$token, $timestamp, $path, $domain, $secure,$http_only);
        }
    }
}