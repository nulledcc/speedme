<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class text extends helper {
        public static function str_limit($value, $limit = 100, $end = '...')
        {
            $limit = $limit - mb_strlen($end);
            $value_len = mb_strlen($value);
            return $limit < $value_len ? mb_substr($value, 0, mb_strrpos($value, ' ', $limit - $value_len)) . $end : $value;
        }
    }
}