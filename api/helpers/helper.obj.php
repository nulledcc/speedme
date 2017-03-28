<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class obj extends \stdClass {
        public $__default = '';
        public static function from_array($array = array()){
            return json_decode(json_encode($array));
        }
        public static function to_array($object = array()){
            return json_decode(json_encode($object),true);
        }
        public function __toString()
        {
            return $this->__default;
        }
    }
}