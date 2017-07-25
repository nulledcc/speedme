<?php
/*speedme framework
*Author : Davit G.
*contact-email: dxjan@ya.ru*/

namespace speedme\views {

    use speedme;
    use speedme\core;
    use speedme\helper\get;
    use speedme\route;
    use speedme\configuration;
    use speedme\model;

    interface viewsInterface
    {
        public function render($data = array());
    }

    abstract class viewsAbstract
    {
        public function renderView($data = '')
        {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    echo $value;
                }
            }
        }
    }

    class view extends viewsAbstract implements viewsInterface
    {
        private static $template = array();
        public static $page_title = 'Page title';
        public static $html_lang_attribute = 'lang="en"';
        public static $buffer = '';
        public static $header = '';
        public static $body = '';
        public static $footer = '';
        public static $navigation = '';
        public static $manual = array();
        public static $header_data = array();
        public static $footer_data = array();
        public static $cache_engine = '';

        public static function cache()
        {
            self::$cache_engine = (isset(configuration\main::get()['cache_system'])) ? configuration\main::get()['cache_system'] : 'mini_cache';
            self::$cache_engine = "speedme\\" . self::$cache_engine;
            return self::$cache_engine;
        }

        /**
         * @return int
         */
        public static function initTemplate()
        {
            $cache = self::cache();
            $cache_enabled = false;
            $cache_key = false;
            $method_func = "false";
            $method_action = false;
            $temp_control = $control = (isset($_REQUEST['urlr'])) ? route::route(htmlentities($_REQUEST['urlr'])) : route::route("index/index");
            $controller_name = 'index';
            $action_name = 'index';
            if (is_array($control)) {
                if (class_exists($control['controller'])) {
                    $controller = new $control['controller']($control);

                    $controller_name = $control['controller'];
                    if (is_null($control['action']) && !method_exists($controller, "actionIndex")) {
                        $control['action'] = array();
                        $control['action'][] = $controller_name;
                    }
                    if (count($control['action']) > 0) {
                        if (isset($control['action'][0])) {
                            $method_action = strtr($control['action'][0], route::$language_route);

                            unset($control['action'][0]);
                            $control['action'] = array_filter(array_values($control['action']));
                            if (is_array($control['action']) && count($control['action']) > 0) {
                                route::$actions = $control['action'];
                            }
                            if (method_exists($controller, "action" . ucfirst(strtolower($method_action)))) {
                                $method_func = "action" . ucfirst(strtolower($method_action));

                                if (isset($controller->cache) && isset($controller->cache[$method_func])) {
                                    $cache_enabled = true;
                                    $cache_key = $control['controller'] . "_" . $method_func;

                                    if ($data = $cache::get($cache_key)->cache()) {
                                        echo $data;
                                        return 0;
                                    }
                                }
                                if (!$controller->$method_func($control)) {
                                    //exit;
                                }
                                $action_name = strtolower($method_action);
                            }else{
                                $control =  $temp_control;
                                if (method_exists($controller, "action" . ucfirst(strtolower($control['controller'])))) {
                                    $method_func = "action" . ucfirst(strtolower($control['controller']));

                                    if (isset($controller->cache) && isset($controller->cache[$method_func])) {
                                        $cache_enabled = true;
                                        $cache_key = $control['controller'] . "_" . $method_func;

                                        if ($data = $cache::get($cache_key)->cache()) {
                                            echo $data;
                                            return 0;
                                        }
                                    }
                                    if (!$controller->$method_func($control)) {
                                        //exit;
                                    }
                                    $action_name = strtolower($method_action);
                                }
                            }
                        }
                    } else {
                        if (method_exists($controller, "actionIndex")) {
                            $method_func = "actionIndex";
                            if (isset($controller->cache) && isset($controller->cache[$method_func])) {
                                $cache_enabled = true;
                                $cache_key = $control['controller'] . "_" . $method_func;

                                if ($data = $cache::get($cache_key)->cache()) {
                                    echo $data;
                                    return 0;
                                }
                            }
                            $controller->actionIndex($control);
                        }
                    }
                }
            }
            self::$navigation = (is_file("api/template/navigation.php")) ? file_get_contents("api/template/navigation.php") : '';
            if (is_array(self::$template) && count(self::$template) > 0) {
                foreach (self::$template as $key => $value) {
                    if ($key == 'header') {
                        self::$body = (is_file("api/views/{$value}.php")) ? file_get_contents("api/views/{$value}.php") : '';
                    }
                    if ($key == 'navigation') {
                        self::$navigation = (is_file("api/views/{$value}.php")) ? file_get_contents("api/views/{$value}.php") : '';
                    }
                    if ($key == 'body') {
                        self::$body = (is_file("api/views/{$value}.php")) ? file_get_contents("api/views/{$value}.php") : '';
                    }
                    if ($key == 'footer') {
                        self::$footer = (is_file("api/views/{$value}.php")) ? file_get_contents("api/views/{$value}.php") : '';
                    }
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                header("HTTP/1.1 404 Not Found");
                header("Status: 404 Not Found");
                self::$navigation = '';
                self::$body = (is_file("api/views/errorpages/404.php")) ? file_get_contents("api/views/errorpages/404.php") : 'NO DEFAULT VIEW FILE';
                self::$footer = '';
                configuration\main::$configuration['root_render']['404'] = true;
                configuration\main::$configuration['default_template']['header'][] = '<meta name="keywords" content="seo,search,engine,optimisation,search engine optimisation,aliexpress, aliexpress best product,404 page,404">';
                configuration\main::$configuration['default_template']['header'][] = '<meta name="description" content="The search engine optimised 404 page that have aliexpress products in it,ads service.">';
                //configuration\main::$configuration['default_template']['header'][] = '';
                //header('location:/');
            }

            $root_render = isset(configuration\main::get()['root_render']) ? configuration\main::get()['root_render'] : false;
            self::$buffer .= (isset($root_render['header']) && is_file('api/views/' . $root_render['header'] . '.php')) ? str_replace('{header}', self::$header, file_get_contents('api/views/' . $root_render['header'] . '.php')) : str_replace('{header}', self::$header, file_get_contents('api/template/header.php'));
            self::$buffer .= (isset($root_render['body']) && is_file('api/views/' . $root_render['body'] . '.php')) ? str_replace("{navigation}", self::$navigation, file_get_contents('api/views/' . $root_render['body'] . '.php')) : str_replace("{navigation}", self::$navigation, file_get_contents('api/template/body.php'));
            self::$buffer = str_replace("{body}", self::$body, self::$buffer);
            if (!isset($root_render['404'])) {
                self::$buffer .= (isset($root_render['footer']) && is_file('api/views/' . $root_render['footer'] . '.php')) ? str_replace("{footer}", self::$footer, file_get_contents('api/views/' . $root_render['footer'] . '.php')) : str_replace("{footer}", self::$footer, file_get_contents('api/template/footer.php'));
            }


            self::$manual["{page_title}"] = self::$page_title;
            self::$manual["{html_lang_attribute}"] = self::$html_lang_attribute;
            self::$manual['{alert_title}'] = (isset(self::$manual['{alert_title}'])) ? self::$manual['{alert_title}'] : '';
            self::$manual['{alert_content}'] = (isset(self::$manual['{alert_content}'])) ? self::$manual['{alert_content}'] : '';
            self::$manual['{sys_controller_name}'] = $controller_name;
            self::$manual['{sys_action_name}'] = $action_name;
            if (is_array(configuration\main::get()['default_template']) && count(configuration\main::get()['default_template']) > 0) {

                if (is_array(configuration\main::get()['default_template']['header']) && count(configuration\main::get()['default_template']['header']) > 0) {

                    self::$header_data = array_merge(configuration\main::get()['default_template']['header'], self::$header_data);
                }
                if (is_array(configuration\main::get()['default_template']['footer']) && count(configuration\main::get()['default_template']['footer']) > 0) {

                    self::$footer_data = array_merge(configuration\main::get()['default_template']['footer'], self::$footer_data);
                }
            }
            $h_data = '';
            $f_data = '';
            if (is_array(self::$header_data) && count(self::$header_data) > 0) {
                foreach (self::$header_data as $h_value) {
                    $h_data .= $h_value . "\n\t\t";
                }
            }
            if (is_array(self::$footer_data) && count(self::$footer_data) > 0) {
                foreach (self::$footer_data as $f_value) {
                    $f_data .= $f_value . "\n\t\t";
                }
            }
            $h_data = trim($h_data);
            $f_data = trim($f_data);
            self::$buffer = str_replace('{header_data}', $h_data, self::$buffer);
            self::$buffer = str_replace('{footer_data}', $f_data, self::$buffer);
            if (is_array(self::$manual) && count(self::$manual) > 0) {
                self::$buffer = str_replace(array_keys(self::$manual), self::$manual, self::$buffer);
            }
            if ($cache_enabled) {
                $cache::set($cache_key, self::$buffer, $controller->cache[$method_func]);
            }
            if ($method_action) {
                $method_action = strtolower($method_action);
                self::$buffer = str_replace('{active_' . $method_action . '}', ' active ', self::$buffer);
            }
            self::$buffer = preg_replace("/\{active\_[A-Za-z0-9]{1,12}\}/", '', self::$buffer);
            self::$buffer = str_replace('{breadcrumbs}', '', self::$buffer);
            /*if(class_exists('speedme\helper\js')){
                echo speedme\helper\js::minify(self::$buffer);
            }else{
                echo self::$buffer;
            }*/
            echo self::$buffer;
            return 0;
        }

        /**
         * @param array $data
         */
        public function render($data = array())
        {
            if (is_array($data) && count($data) > 0) {
                foreach ($data as $key => $value) {
                    self::$template[$key] = $value;
                }
            }
        }

        /**
         * @param bool $key
         * @param string $value
         */
        public static function template($key = false, $value = '')
        {
            if ($key) {
                if (is_string($value) || is_numeric($value)) {
                    self::$manual[$key] = $value;
                } else {
                    if (configuration\debug::$enable) {
                        $message_data = core::executed_line();
                        $error_text = '';
                        if (isset($message_data[1])) {
                            if (isset($message_data[1]['file'])) {
                                $error_text .= 'File: ' . $message_data[1]['file'];
                            }
                            if (isset($message_data[1]['line'])) {
                                $error_text .= '<br/>Line: ' . $message_data[1]['line'];
                            }
                        }
                        core::debug('Template render ' . $key . ' must have string or number value. Type of value is: ' . gettype($value) . ' has been provided.<br/>' . $error_text, 'Render error.', true);
                    }

                }
            }
        }

        /**
         *
         */
        public static function load()
        {
            self::initTemplate();
        }
    }
}