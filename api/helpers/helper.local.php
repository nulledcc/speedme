<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class local extends helper {
        public static $current = 'en';
        public static function get(){
            if($local = htmlentities(cookie::get('local',self::$current))){
                if(in_array(strtolower($local),['en','pt','ru','es','fr','id','it','nl','tr','vi','th','de','ko','ja','ar','pl','he'])){
                    self::$current = $local;
                }
            }
            return new self;
        }
        public static function set($local = 'en'){
            if(in_array($local,['en','pt','ru','es','fr','id','it','nl','tr','vi','th','de','ko','ja','ar','pl','he'])){
                self::$current = $local;
                cookie::set('local',self::$current);
            }
            return new self;
        }
        public function local(){
            return self::$current;
        }
    }
}