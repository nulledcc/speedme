<?php
/*speedme framework
*Author : Davit G.
*contact-email: dxjan@ya.ru*/
namespace speedme\db{
    use speedme;
    use speedme\configuration;
    interface baseInterface {
        public static function add();
        public static function edit();
        public static function view();
    }
    class db_pdo {

        public static $pdo = null;

        /**
         * @return db_pdo
         */
        public static function connect(){
            try{
                //init default or from config
                if(!self::$pdo){
                    self::$pdo = new \PDO(
                        configuration\db::$dsn,
                        configuration\db::$user,
                        configuration\db::$pass,
                        configuration\db::$options
                    );
                    if(self::$pdo)
                    {
                        self::$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, FALSE);
                        return new self;
                    }
                }
            }catch(\PDOException $e){
                speedme\core::debug($e->getMessage(),'PDO CONNECT ERROR',true);
            }
        }
        /**
         * @param $query
         * @param array $opExecute
         * @param bool $lastId
         * @return bool
         */
        public static function set($query, $opExecute = array(), $lastId = false){
            self::connect();
            try{
                $prepare = (is_object(self::$pdo) && method_exists(self::$pdo,'prepare')) ? self::$pdo->prepare($query) : false;
                if(is_object($prepare)){
                    $execute =  (!empty($opExecute) || $opExecute != null) ? $prepare->execute($opExecute) : $prepare->execute();
                    $lastId = self::$pdo->lastInsertId();
                    return ($lastId) ? $lastId : $execute;
                }else{
                    if(configuration\debug::$enable){
                        $options = json_encode($opExecute);
                        $mess = json_encode(self::$pdo->errorInfo());
                        speedme\core::debug('ERROR IN SET <br> PREPARE: '.$query.' <br> OPEXECUTE: '.$options.' <br> PDO: '.$mess,'PDO ERROR',false,array('000000','ffffff'));
                    }
                    return false;
                }
            }catch(\PDOException $e){
                speedme\core::debug($e->getMessage(),'PDO ERROR',true);
            }
            return false;
        }
        /**
         * @param $query
         * @param array $opExecute
         * @param int $type
         * @return bool
         */
        public static function get($query, $opExecute = array(), $type = \PDO::FETCH_ASSOC){
            self::connect();
            try{
                $prepare = (is_object(self::$pdo) && method_exists(self::$pdo,'prepare')) ? self::$pdo->prepare($query) : false;
                if(is_object($prepare)){
                    $execute =  (!empty($opExecute) || $opExecute != null) ? $prepare->execute($opExecute) : $prepare->execute();
                    if($execute){
                        $data = ($type) ? $prepare->fetchAll($type) : $prepare->fetchAll();
                        if(count($data) == 1){
                            $data = $data[0];
                        }
                        if($data){
                            return $data;
                        }else{
                            if(configuration\debug::$enable){
                                $options = json_encode($opExecute);
                                $mess = json_encode(self::$pdo->errorInfo());
                                speedme\core::debug('ERROR IN GET <br> PREPARE: '.$query.' <br> OPEXECUTE: '.$options.' <br> PDO: '.$mess,"PDO ERROR",false,array('000000','ffffff'));
                            }
                        }
                    }else{
                        if(configuration\debug::$enable){
                            $options = json_encode($opExecute);
                            $mess = json_encode(self::$pdo->errorInfo());
                            speedme\core::debug('ERROR IN GET <br> PREPARE: '.$query.' <br> OPEXECUTE: '.$options.' <br> PDO: '.$mess,"PDO ERROR",false,array('000000','ffffff'));
                        }
                    }
                }else{
                    if(configuration\debug::$enable){
                        $options = json_encode($opExecute);
                        $mess = json_encode(self::$pdo->errorInfo());
                        speedme\core::debug('ERROR IN GET <br> PREPARE: '.$query.' <br> OPEXECUTE: '.$options.' <br> PDO: '.$mess,"PDO ERROR",false,array('000000','ffffff'));
                    }
                    return false;
                }
            }catch(\PDOException $e){
                speedme\core::debug($e->getMessage(),'PDO ERROR',true);
            }
            return false;
        }

        /**
         * @param string $table_name
         * @param int $method
         * @return bool
         */
        public static function table_exist($table_name = '',$method = 1){
            self::connect();
            try {
                if($method == 1){
                    $prepare = (is_object(self::$pdo) && method_exists(self::$pdo,'prepare')) ? self::$pdo->prepare("SHOW TABLES LIKE '{$table_name}'") : false;
                    if($prepare && $prepare->rowCount() > 0){
                        return true;
                    }
                }else if($method == 2){
                    if(self::$pdo->query("SELECT 1 FROM `{$table_name}` LIMIT 1")){
                        return true;
                    }
                }

            }catch (\PDOException $e) {
                return FALSE;
            }
            return false;
        }
        /**
         * @return null
         */
        public static function disconnect(){
            self::$pdo = null;
            return self::$pdo;
        }
    }
}
