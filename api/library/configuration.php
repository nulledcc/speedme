<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\configuration{
    class db
    {
        public static $drive = 'mysql';
        public static $host = 'localhost';
        public static $base = 'speedme';
        public static $user = 'root';
        public static $pass = '';
        public static $dsn = 'mysql:dbname=speedme;host=localhost';
        public static $options = array(
                            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                                        );

        function __construct()
        {
            self::$host = self::$drive.':dbname='.self::$base.';host='.self::$host;
        }
    }
    class debug{
        public static $enable = true;

    }
    class main{
        public static $configuration = [];
        public static $security_key = '15A%JAN@#KLOKPK*P7891909';

        /**
         * @return array
         */
        public static function get(){
            if(!isset(self::$configuration['cache_root'])) {
                self::$configuration['cache_root'] = $_SERVER['DOCUMENT_ROOT'];
            }
            if(!isset(self::$configuration['cache_root'])) {
                self::$configuration['cache_root'] = $_SERVER['DOCUMENT_ROOT'];
            }
            if(!isset(self::$configuration['cache_system'])) {
                self::$configuration['cache_system'] = 'mini_cache';
            }
            if(!isset(self::$configuration['cache_root'])) {
                self::$configuration['cache_root'] = 'api/cache';
            }
            if(!isset(self::$configuration['default_template'])){
                self::$configuration['default_template'] = [
                    'header'=>[
                        '<!--Import Google Icon Font-->',
                        '<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">',
                        '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">',
                        '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">',
                        '<link href="/favicon.ico" rel="icon" type="image/x-icon" />',
                        '<link rel="stylesheet" href="/template/style.css">',
                        '<meta name="robots" content="index, follow">',
                        '<meta name="author" content="Davit G.">'
                    ],
                    'footer'=>[
                        '<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>',
                        '<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>',
                        '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>'
                    ]
                ];
            }

            return self::$configuration;
        }
        public static function set($key = false,$value = ''){
            if($key){
                self::$configuration[$key] = $value;
                return true;
            }
            return false;
        }
    }
}


