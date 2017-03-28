<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{

    use speedme\configuration;
    use speedme\mini_cache;

    class html extends helper {
        public static $base_root = '';
        public static $manual_root = '';
        public static $html_tag = '';

        /**
         * html constructor.
         */
        public function __construct()
        {
            self::$base_root = (class_exists('main')) ? configuration\main::get()->configuration['base_root'] : '';
        }

        /**
         * @param array $data
         * @param bool $inner
         * @return html|null|string
         */
        public static function tag($data = array(), $inner = false){
            /*$cache = new mini_cache();
            $identifier = '__tag_htmlHelper';
            $md5_option = md5(serialize(func_get_args()).$identifier);
            if($cached = $cache::get($md5_option)->cache()){
                self::$html_tag =  unserialize($cached);
                return new self;
            }*/
            $html = NULL;
            $attributes = '';
            try{
                if(is_array($data)){
                    if(!isset($data['name'])){
                        throw new \Exception('Tag name must be specified',4865);
                    }
                    if(!isset($data['value'])){
                        throw new \Exception('Tag value must be specified',4865);
                    }
                    if(isset($data['attributes']) && is_array($data['attributes'])){
                        foreach ($data['attributes'] as $attr_name => $attr_value){
                            if(is_array($attr_value) || is_object($attr_value)){
                                $attr_value = json_decode(json_encode($attr_value),true);
                                $attr_value = implode(" ",$attr_value);
                                $attributes .= ' '.$attr_name.'="'.$attr_value.'"';
                            }else{
                                if(!is_numeric($attr_name)) {
                                    $attributes .= ' ' . $attr_name . '="' . $attr_value . '"';
                                }
                            }
                        }
                    }
                    if(isset($data['value']) && (is_array($data['value']) || is_object($data['value'])) && !$inner){
                        $values = $data['value'];
                        $data['value'] = '';
                        foreach ($values as $attr_name => $attr_value){
                            $data['value'] .= ' '.$attr_name.'="'.$attr_value.'"';
                        }
                    }else if(isset($data['value']) && !is_array($data['value']) && !is_object($data['value']) && !$inner){
                        $data['value'] = ' value="'.$data['value'].'"';
                    }
                    if($inner){
                        $html = '<'. $data['name'] .' '.$attributes.'>'.$data['value'].'</'. $data['name'] .'>';
                    }else{
                        $html = '<'. $data['name'] .' '.$attributes.' '.$data['value'].' />';
                    }
                    $html = str_replace('  ',' ',$html);
                    self::$html_tag = $html."\n";
                    //$cache::set($md5_option,serialize(self::$html_tag),100000000);
                }else{
                    throw new \Exception('Method need array',4865);
                }
            }catch (\Exception $e){
                $tag_unique = uniqid();
                parent::debug($e->getMessage()." - L: ".$e->getLine().' ID: '.$tag_unique,$e->getFile());
                return '{error in tag '.$tag_unique.'}';
            }
            return new self;
        }

        /**
         * @return string
         */
        public function self(){
            return self::$html_tag;
        }

        /**
         * @param string $innerHtml
         * @param string $attributes
         * @return string
         */
        public static function div($innerHtml = '', $attributes = ''){
            self::tag([
                'name' => 'div',
                'value' => $innerHtml,
                'attributes' => $attributes
            ],true);
            return self::$html_tag;
        }

        /**
         * @param string $src
         * @param string $attributes
         * @return string
         */
        public static function  img($src ='', $attributes = ''){
            self::tag([
                'name' => 'img',
                'value' => ["src"=>$src],
                'attributes' => $attributes
            ]);
            return self::$html_tag;
        }

        /**
         * @param string $innerHtml
         * @param string $href
         * @param array|string $attributes
         * @return string
         */
        public static function  a($innerHtml = '',$href = '', $attributes = array()){
            $attributes['href'] = $href;
            self::tag([
                'name' => 'a',
                'value' => $innerHtml,
                'attributes' => $attributes
            ],true);
            return self::$html_tag;
        }

        /**
         * @param string $innerHtml
         * @param string $attributes
         * @return string
         */
        public static function  nav($innerHtml = '', $attributes = ''){
            self::tag([
                'name' => 'nav',
                'value' => $innerHtml,
                'attributes' => $attributes
            ],true);
            return self::$html_tag;
        }

        /**
         * @param bool $src
         * @param bool $innerJs
         * @param string $attributes
         * @return string
         * @internal param bool $innerJs
         */
        public static function  script($src = false, $innerJs = false, $attributes = ''){
            $isInner = ($src) ? false : true;
            $value = ($src) ? ['src'=>$src] : $innerJs;
            self::tag([
                'name' => 'script',
                'value' => $value,
                'attributes' => $attributes
            ],$isInner);
            return self::$html_tag;
        }

        /**
         * @param string $innerHtml
         * @param string $attributes
         * @return string
         */
        public static function form($innerHtml = '', $attributes = ''){
            self::tag([
                'name' => 'form',
                'value' => $innerHtml,
                'attributes' => $attributes
            ],true);
            return self::$html_tag;
        }

        /**
         * @param string $name
         * @param string $type
         * @param string $attributes
         * @return string
         */
        public static function input($name = '', $type = 'text', $attributes = ''){
            $legal_attributes = array('button','checkbox','file','hidden','image','password','radio','reset','submit','text');
            $legal_attributes_html5 = array('color','date','datetime','datetime-local','email','number','range','search','tel','time','url','month','week');
            $attributes['type'] = (!isset( $attributes['type']) && $type) ? $type :  ((isset($attributes['type'])) ? $attributes['type'] : 'text');
            $attributes['name'] = (!isset( $attributes['name']) && $name) ? $name : '';
            $value = (isset($attributes['value'])) ? $attributes['value'] : '';
            unset($attributes['value']);
            if(!in_array($attributes['type'],$legal_attributes)){
                if(!in_array($attributes['type'],$legal_attributes_html5)){
                    self::debug(self::executed_line("Input form type not defined as legal."),'INFO');
                }else{
                    self::debug(self::executed_line("Input form type is html5 standard."),'INFO');
                }
            }
            self::tag([
                'name' => 'input',
                'value' => $value,
                'attributes' => $attributes
            ],false);
            return self::$html_tag;
        }

        /**
         * @param string $innerText
         * @param string $attributes
         * @return string
         */
        public static function text($innerText = '', $attributes = ''){

            self::tag([
                'name' => 'textarea',
                'value' => $innerText,
                'attributes' => $attributes
            ],true);
            return self::$html_tag;
        }

        /**
         * @param int $size
         * @param string $innerHtml
         * @param string $attributes
         * @return string
         */
        public static function h($size = 1, $innerHtml = '', $attributes = ''){
            self::tag([
                'name' => 'h'.$size,
                'value' => $innerHtml,
                'attributes' => $attributes
            ],true);
            return self::$html_tag;
        }

        /**
         * @param string $tag_name
         * @param string $innerHtml
         * @param string $attributes
         * @param bool $is_inner
         * @return string
         */
        public static function custom($tag_name = 'div', $innerHtml = '', $attributes = '',$is_inner = true){
            self::tag([
                'name' => $tag_name,
                'value' => $innerHtml,
                'attributes' => $attributes
            ],$is_inner);
            return self::$html_tag;
        }
        public static function build_form($data = array(),$validation= false){

        }

        /**
         * @param $css
         * @return mixed
         */
        public static function mini_css($css){
            /* remove comments */
            $css = preg_replace( '!/*[^*]\**+([^/][^*]\**+)\*/!', '', $css );
            /* remove tabs, spaces, newlines, etc. */
            $css = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css );
            return $css;
        }
    }
}