<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class currency extends helper {
        public static $current = 'USD';
        public static function get(){
            if($currency = htmlentities(cookie::get('currency'))){
                if(in_array($currency,['USD','RUB','GBP','BRL','CAD','AUD','EUR','INR','UAH','JPY','MXN','IDR','TRY','SEK'])){
                    self::$current = $currency;
                }

            }
            return new self;
        }
        public static function set($currency = 'USD'){
            if(in_array($currency,['USD','RUB','GBP','BRL','CAD','AUD','EUR','INR','UAH','JPY','MXN','IDR','TRY','SEK'])){
                self::$current = $currency;
                cookie::set('currency',self::$current);
            }

            return new self;
        }
        public function currency(){
            return self::$current;
        }
    }
}