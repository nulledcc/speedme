<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme {
    use speedme\configuration;
    class core
    {
        public static function browser(){
            return $_SERVER['HTTP_USER_AGENT'];
        }
        /**
         * @return mixed
         */
        public static function ip(){
            if (isset($_SERVER)) {
                if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && ip2long($_SERVER["HTTP_X_FORWARDED_FOR"]) !== false) {
                    $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } elseif (isset($_SERVER["HTTP_CLIENT_IP"])  && ip2long($_SERVER["HTTP_CLIENT_IP"]) !== false) {
                    $ip_address = $_SERVER["HTTP_CLIENT_IP"];
                } else {
                    $ip_address = $_SERVER["REMOTE_ADDR"];
                }
            } else {
                if (getenv('HTTP_X_FORWARDED_FOR') && ip2long(getenv('HTTP_X_FORWARDED_FOR')) !== false) {
                    $ip_address = getenv('HTTP_X_FORWARDED_FOR');
                } elseif (getenv('HTTP_CLIENT_IP') && ip2long(getenv('HTTP_CLIENT_IP')) !== false) {
                    $ip_address = getenv('HTTP_CLIENT_IP');
                } else {
                    $ip_address = getenv('REMOTE_ADDR');
                }
            }
            return $ip_address;
        }
        /**
         * @param $debug
         * @param string $header
         * @param bool $die
         * @param array $colors
         */
        public static function debug($debug, $header = "", $die = false, $colors = array('EFECEC', '000000'))
        {
            if (configuration\debug::$enable) {
                if(!isset($colors[0])){
                    $colors[0] = '#EFECEC';
                }else{
                    if(strpos($colors[0],'#') === false){
                        $colors[0] = "#".$colors[0];
                    }
                }
                if(!isset($colors[1])){
                    $colors[1] = '#000000';
                }else{
                    if(strpos($colors[1],'#') === false){
                        $colors[1] = "#".$colors[1];
                    }
                }
                echo '<div style="background:' . $colors[0] . ';color:' . $colors[1] . ';border:1px solid #333;margin-top:5px;margin-bottom:5px;padding:2px;width:100%;">';
                echo '<div style="background:#BFBFBF;color:#555;width:100%;margin-bottom:5px;font-weight:bold;">' . $header . '</div>';
                if (!is_array($debug)) {
                    echo($debug);
                } elseif (is_array($debug)) {
                    $pos = array_search('.', $debug);
                    unset($debug[$pos]);
                    $pos = array_search('..', $debug);
                    unset($debug[$pos]);
                    $pos = array_search('index.php', $debug);
                    unset($debug[$pos]);
                    print_r(array_values($debug));
                }
                echo '</div>';
            }
            if ($die) {
                $die = ($die === true) ? '' : $die;
                die('<div>' . $die . '</div>');
            }
        }
        public static function executed_line($message = false,$other = false){
            $log_info = debug_backtrace();
            if($message){
                $log_info['message'] = $message;
            }
            if(is_array($other)){
                $log_info['other'] = $other;
            }
            return $log_info;
        }
    }
    class route{
        public static $actions = false;

        /**
         * @param $data
         * @param string $default
         * @return array|string
         * class alert-link can be used inside href link
         */
        public static function route($data = false, $default = 'index'){
            if($data){
                $data = str_replace("<?php","",$data);
                $data = str_replace("<?","",$data);
                $data = str_replace("?>","",$data);
                $data = explode("/",$data);
                $data = array_filter($data, create_function('$value', 'return $value !== "";'));
                if(isset($data[0]) && isset($data[1])){
                    $full_data = $data;
                    unset($data[0]);
                    $data = array_values($data);
                    return array('controller'=>$full_data[0],'action'=>array_values($data));
                }else if(isset($data[0])){
                    return array('controller'=>$data[0],'action'=>null);
                }
            }
            return $default;
        }

        /**
         * @param bool $data
         */
        public static function add_action($data = false){
            self::$actions = $data;
        }

    }
    class mini_cache{
        public static $dir_checked = false;
        private static $cache_key = false;
        private static $cache_data = false;
        private static $status = false;
        /**
         * @return bool|string
         */
        private static function get_folder(){
            if(self::$dir_checked === false) {
                if (!isset(configuration\main::get()['cache_folder']) || (isset(configuration\main::get()['cache_folder']) && strlen(str_replace("/", "", configuration\main::get()['cache_folder'])) <= 0)) {
                    configuration\main::$configuration['cache_folder'] = 'api/cache';
                }
                if (!is_dir(configuration\main::$configuration['cache_folder'])) {
                    if (!mkdir(configuration\main::$configuration['cache_folder'], 0755)) {
                        core::debug("Unable to create caching folder.", 'CACHE FOLDER');
                    }else{
                        if(file_put_contents(configuration\main::$configuration['cache_folder']."/index.php", "<?php\nheader('location:../');\n?>") === false) {
                            core::debug("Unable to create caching folder.", 'Index.php');
                        }
                    }
                } else {
                    self::$dir_checked = true;
                    configuration\main::$configuration['cache_folder'] = 'api/cache';
                    return configuration\main::$configuration['cache_folder'];
                }
            }else{
                return configuration\main::$configuration['cache_folder'];
            }
            self::$dir_checked = true;
            return false;
        }

        /**
         * @param bool $cache_key
         * @param bool $data
         * @param int $expiration
         * @return mini_cache
         */
        public static function set($cache_key = false, $data = false, $expiration = 0){
            self::$cache_key = $cache_key;
            self::$cache_data = $data;
            //create cache file and cache info file
            if($folder = self::get_folder()){
                $folder .= "/";
                $folder = str_replace('//','/',$folder);
                $cache_file = $folder.$cache_key.".html";
                $cache_file_expiration = $folder.$cache_key.'.expiration';
                $time_now = strtotime(gmdate("Y-m-d H:i:s"));
                $expiration += $time_now;
                if($cache_key !== false && $data !== false){
                    if (file_put_contents($cache_file_expiration, $expiration) !== false) {
                        if(file_put_contents($cache_file, $data) !== false){
                            self::$status = true;
                        }
                    }
                }
            }
            return new self;
        }

        /**
         * @param bool $cache_key
         * @return mini_cache
         */
        public static function get($cache_key = false){
            self::$cache_key = $cache_key;
            self::$cache_data = false;
            self::$status = false;
            if($folder = self::get_folder()){
                $folder .= "/";
                $folder = str_replace('//','/',$folder);
                $cache_file = $folder.$cache_key.".html";
                $cache_file_expiration = $folder.$cache_key.'.expiration';
                if($cache_key !== false){
                    if (is_file($cache_file_expiration)) {
                        if(($expiration = file_get_contents($cache_file_expiration)) !== false){

                            if($expiration > 0){
                                $time_now = strtotime(gmdate("Y-m-d H:i:s"));
                                if($expiration < $time_now){
                                    return new self;
                                }
                            }
                            if(is_file($cache_file)){
                                if($data = file_get_contents($cache_file)){
                                    self::$cache_data = $data;
                                    self::$status = true;
                                }
                            }
                        }

                    }
                }
            }

            return new self;
        }

        /**
         * @return boolean
         */
        public function status()
        {
            return self::$status;
        }

        /**
         * @return bool | string
         */
        public function cache(){
            return self::$cache_data;
        }

        /**
         * @param string $data
         * @param int $expiration
         * @param bool $class
         * @param bool $method
         * @return mini_cache
         */
        public static function md5_cache($data = '', $expiration = 0, $class = false, $method = false){
            $initial_data = $data;
            if(is_array($data) || is_object($data)){
                $data = json_encode($data);
            }
            $md5 = md5($data);
            if(!self::get($md5)->cache()){
                $data_generated = $initial_data;
                if($class && $method && class_exists($class) && method_exists($class,$method)){
                    $data_generated = call_user_func(array($class, $method), $data_generated);
                }
                self::set($md5,$data_generated,$expiration);
            }
            return new self;
        }
    }
}