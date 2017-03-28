<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class cookie extends helper {

        /**
         * @param bool $name
         * @param string $value
         * @param int $expire
         * @param string $path
         * @param string $domain
         * @param bool $secure
         * @param bool $http_only
         * @return bool
         */
        public static function set($name = false, $value = "", $expire = 0, $path = "" , $domain = "" , $secure = false , $http_only = false){
            if($name !== false){
                return setcookie($name,$value,$expire,$path,$domain,$secure,$http_only);
            }else{
                return false;
            }
        }

        /**
         * @param bool $name
         * @return bool
         */
        public static function get($name = false, $default = false){
            if(isset($_COOKIE[$name])){
                return $_COOKIE[$name];
            }else if($default !== false){
                $_COOKIE[$name] = $default;
                return $default;
            }else{
                return false;
            }
        }

        /**
         * @param bool $name
         * @return cookie|bool
         */
        public static function destroy($name = false){
           if($name !== false){
               $past = time() - 3600;
               return setcookie( $name, '', $past, '/' );
           }
            return new self;
        }

        /**
         * @return cookie
         */
        function all(){
            if (is_array($_COOKIE) && count($_COOKIE) > 0){
                $cookies = $_COOKIE;
                foreach ($cookies as $key => $value) {
                    unset($_COOKIE[$key]);
                    setcookie($key, null, -1, '/');
                }
            }
            return new self;
        }
    }
}