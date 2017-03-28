<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{

    use speedme\mini_cache;

    class getbootstrap extends helper {
        /**
         * @param string $innerHtml
         * @param bool $is_fluid
         * @param array $attributes
         * @param string $tag_name
         * @return string
         */
        public static function container($innerHtml = '', $is_fluid = false, $attributes = array(), $tag_name = 'div'){
            if(is_array($attributes)){
                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){
                    if($is_fluid){
                        array_unshift($attributes['class'],'container-fluid');
                    }else{
                        array_unshift($attributes['class'],'container');
                    }
                }else if(isset($attributes['class'])){
                    if($is_fluid){
                        $attributes['class'] = 'container-fluid'.' '.$attributes['class'];
                    }else{
                        $attributes['class'] = 'container'.' '.$attributes['class'];
                    }
                }else{
                    if($is_fluid){
                        $attributes['class'] = 'container-fluid';
                    }else{
                        $attributes['class'] = 'container';
                    }
                }
            }
            return html::custom($tag_name,$innerHtml,$attributes);
        }

        /**
         * @param string $innerHtml
         * @param array $attributes
         * @param string $tag_name
         * @return \stdClass
         */
        public static function alert($innerHtml = '', $attributes = array(), $tag_name = 'div'){
            $cache = new mini_cache();
            $identifier = '__alert_getBootstrap';
            $md5_option = md5(serialize(func_get_args()).$identifier);
            if($cached = $cache::get($md5_option)->cache()){
                return unserialize($cached);
            }
            $return_object = new obj();
            $attributes_success = null;
            $attributes_info = null;
            $attributes_warning = null;
            $attributes_danger = null;

            if(is_array($attributes)){
                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){

                    $attributes_success = $attributes['class'];
                    array_unshift($attributes_success['class'],'alert-success');
                    array_unshift($attributes_success['class'],'alert');

                    $attributes_info = $attributes['class'];
                    array_unshift($attributes_info['class'],'alert-info');
                    array_unshift($attributes_info['class'],'alert');

                    $attributes_warning = $attributes['class'];
                    array_unshift($attributes_warning['class'],'alert-warning');
                    array_unshift($attributes_warning['class'],'alert');

                    $attributes_danger = $attributes['class'];
                    array_unshift($attributes_danger['class'],'alert-danger');
                    array_unshift($attributes_danger['class'],'alert');

                    array_unshift($attributes['class'],'alert');

                }else if(isset($attributes['class'])){
                    $attributes_success['class'] = 'alert alert-success'.' '.$attributes['class'];

                    $attributes_info['class'] = 'alert alert-info'.' '.$attributes['class'];

                    $attributes_warning['class'] = 'alert alert-warning'.' '.$attributes['class'];

                    $attributes_danger['class'] = 'alert alert-danger'.' '.$attributes['class'];

                    $attributes['class'] = 'alert'.' '.$attributes['class'];
                }else{
                    $attributes_success['class'] = 'alert alert-success';

                    $attributes_info['class'] = 'alert alert-info';

                    $attributes_warning['class'] = 'alert alert-warning';

                    $attributes_danger['class'] = 'alert alert-danger';

                    $attributes['class'] = 'alert';
                }
            }
            $attributes['role'] = 'alert';
            $attributes_success['role'] = 'alert';
            $attributes_info['role'] = 'alert';
            $attributes_warning['role'] = 'alert';
            $attributes_danger['role'] = 'alert';

            $return_object->success = html::custom($tag_name,$innerHtml,$attributes_success);
            $return_object->info = html::custom($tag_name,$innerHtml,$attributes_info);
            $return_object->warning = html::custom($tag_name,$innerHtml,$attributes_warning);
            $return_object->danger = html::custom($tag_name,$innerHtml,$attributes_danger);
            $return_object->default = html::custom($tag_name,$innerHtml,$attributes);
            $return_object->__default = $return_object->info;
            $cache::set($md5_option,serialize($return_object),100000000);
            return $return_object;
        }

        /**
         * @param string $innerHtml
         * @param bool $pill
         * @param array $attributes
         * @param string $tag_name
         * @return \stdClass
         */
        public static function badge($innerHtml = '', $pill = false, $attributes = array(), $tag_name = 'span'){
            $cache = new mini_cache();
            $identifier = '__badge_getBootstrap';
            $md5_option = md5(serialize(func_get_args()).$identifier);
            if($cached = $cache::get($md5_option)->cache()){
                return unserialize($cached);
            }

            $return_object = new obj();
            $attributes_default = null;
            $attributes_primary = null;
            $attributes_success = null;
            $attributes_info = null;
            $attributes_warning = null;
            $attributes_danger = null;

            if(is_array($attributes)){
                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){

                    $attributes_default = $attributes['class'];
                    array_unshift($attributes_default['class'],'badge-default');
                    if($pill){
                        array_unshift($attributes_default['class'],'badge-pill');
                    }
                    array_unshift($attributes_default['class'],'badge');

                    $attributes_primary = $attributes['class'];
                    array_unshift($attributes_primary['class'],'badge-primary');
                    if($pill){
                        array_unshift($attributes_primary['class'],'badge-pill');
                    }
                    array_unshift($attributes_primary['class'],'badge');

                    $attributes_success = $attributes['class'];
                    array_unshift($attributes_success['class'],'badge-success');
                    if($pill){
                        array_unshift($attributes_success['class'],'badge-pill');
                    }
                    array_unshift($attributes_success['class'],'badge');

                    $attributes_info = $attributes['class'];
                    array_unshift($attributes_info['class'],'badge-info');
                    if($pill){
                        array_unshift($attributes_info['class'],'badge-pill');
                    }
                    array_unshift($attributes_info['class'],'badge');

                    $attributes_warning = $attributes['class'];
                    array_unshift($attributes_warning['class'],'badge-warning');
                    if($pill){
                        array_unshift($attributes_warning['class'],'badge-pill');
                    }
                    array_unshift($attributes_warning['class'],'badge');

                    $attributes_danger = $attributes['class'];
                    array_unshift($attributes_danger['class'],'badge-danger');
                    if($pill){
                        array_unshift($attributes_danger['class'],'badge-pill');
                    }
                    array_unshift($attributes_danger['class'],'badge');

                    if($pill){
                        array_unshift($attributes['class'],'badge-pill');
                    }
                    array_unshift($attributes['class'],'badge');

                }else if(isset($attributes['class'])){

                    $set_pill = ($pill) ? ' badge-pill' : '';

                    $attributes_default['class'] = 'badge'.$set_pill.' badge-default '.$attributes['class'];

                    $attributes_primary['class'] = 'badge'.$set_pill.' badge-primary '.$attributes['class'];

                    $attributes_success['class'] = 'badge'.$set_pill.' badge-success '.$attributes['class'];

                    $attributes_info['class'] = 'badge'.$set_pill.' badge-info '.$attributes['class'];

                    $attributes_warning['class'] = 'badge'.$set_pill.' badge-warning '.$attributes['class'];

                    $attributes_danger['class'] = 'badge'.$set_pill.' badge-danger '.$attributes['class'];

                    $attributes['class'] = 'badge'.$set_pill.' '.$attributes['class'];
                }else{
                    $set_pill = ($pill) ? ' badge-pill' : '';

                    $attributes_default['class'] = 'badge'.$set_pill.' badge-default';

                    $attributes_primary['class'] = 'badge'.$set_pill.' badge-primary';

                    $attributes_success['class'] = 'badge'.$set_pill.' badge-success';

                    $attributes_info['class'] = 'badge'.$set_pill.' badge-info';

                    $attributes_warning['class'] = 'badge'.$set_pill.' badge-warning';

                    $attributes_danger['class'] = 'badge'.$set_pill.' badge-danger';

                    $attributes['class'] = 'badge'.$set_pill;
                }
            }

            $return_object->default = html::custom($tag_name,$innerHtml,$attributes_default);
            $return_object->primary = html::custom($tag_name,$innerHtml,$attributes_primary);
            $return_object->success = html::custom($tag_name,$innerHtml,$attributes_success);
            $return_object->info = html::custom($tag_name,$innerHtml,$attributes_info);
            $return_object->warning = html::custom($tag_name,$innerHtml,$attributes_warning);
            $return_object->danger = html::custom($tag_name,$innerHtml,$attributes_danger);
            $return_object->none = html::custom($tag_name,$innerHtml,$attributes);
            $return_object->__default = $return_object->primary;
            $cache::set($md5_option,serialize($return_object),100000000);
            return $return_object;
        }

        /**
         * @param array $breadcrumb_array['value'=>'page_name','href'=>'page_link','active'=>true,'attributes'=>['class'=>'some_class']]
         * @param int $mode
         * @return string
         */
        public static function breadcrumb($breadcrumb_array = array(), $mode = 1){
            $return_html = '';
            if(is_array($breadcrumb_array) && count($breadcrumb_array) > 0){
                if($mode == 1){
                    $return_html = '<ol class="breadcrumb">';
                    foreach ($breadcrumb_array as $value){
                        $attributes = (isset($value['attributes'])) ? $value['attributes'] : array();
                        $name = isset($value['value']) ? $value['value'] : false;

                        if(isset($value['active']) && $name){
                            if(is_array($attributes)){
                                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){
                                    array_unshift($attributes['class'],'active');
                                    array_unshift($attributes['class'],'breadcrumb-item');
                                }else if(isset($attributes['class'])){
                                    $attributes['class'] = 'breadcrumb-item active '.$attributes['class'];
                                }else{
                                    $attributes['class'] = 'breadcrumb-item active';
                                }
                            }
                            $return_html .= html::custom('li',$name,$attributes);
                        }else{
                            if(is_array($attributes)){
                                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){
                                    array_unshift($attributes['class'],'breadcrumb-item');
                                }else if(isset($attributes['class'])){
                                    $attributes['class'] = 'breadcrumb-item '.$attributes['class'];
                                }else{
                                    $attributes['class'] = 'breadcrumb-item';
                                }
                            }
                            if(isset($value['href']) && $name){
                                $return_html .= html::custom('li',
                                    html::a($name,$value['href']),
                                    $attributes
                                );
                            }else{
                                $return_html .= html::custom('li',$name,$attributes);
                            }
                        }
                    }
                    $return_html .= '</ol>';
                }else if($mode == 2){
                    $return_html = '<nav class="breadcrumb">';
                    foreach ($breadcrumb_array as $value){
                        $attributes = (isset($value['attributes'])) ? $value['attributes'] : array();
                        $name = isset($value['value']) ? $value['value'] : false;
                        if(isset($value['active']) && $name){
                            if(is_array($attributes)){
                                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){
                                    array_unshift($attributes['class'],'active');
                                    array_unshift($attributes['class'],'breadcrumb-item');
                                }else if(isset($attributes['class'])){
                                    $attributes['class'] = 'breadcrumb-item active '.$attributes['class'];
                                }else{
                                    $attributes['class'] = 'breadcrumb-item active';
                                }
                            }
                            $return_html .= html::custom('span',$name,$attributes);
                        }else{
                            if(is_array($attributes)){
                                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){
                                    array_unshift($attributes['class'],'breadcrumb-item');
                                }else if(isset($attributes['class'])){
                                    $attributes['class'] = 'breadcrumb-item '.$attributes['class'];
                                }else{
                                    $attributes['class'] = 'breadcrumb-item';
                                }
                            }
                            if(isset($value['href']) && $name){
                                $return_html .= html::a($name,$value['href'],$attributes);
                            }else{
                                $return_html .= html::custom('span',$name,$attributes);
                            }
                        }
                    }
                    $return_html .= '</nav>';
                }
            }
            return $return_html;
        }

        /**
         * @param string $name
         * @param bool $value
         * @param array $attributes
         * @param string $tag_name
         * @param bool $is_outline
         * @param string $type
         * @return \stdClass
         */
        public static function button($name = '', $value = false, $attributes = array(), $tag_name = 'button', $is_outline = false, $type = 'button'){
            $cache = new mini_cache();
            $identifier = '__button_getBootstrap';
            $md5_option = md5(serialize(func_get_args()).$identifier);
            if($cached = $cache::get($md5_option)->cache()){
                return unserialize($cached);
            }
            $return_object = new obj();
            $attributes_secondary = null;
            $attributes_primary = null;
            $attributes_success = null;
            $attributes_info = null;
            $attributes_warning = null;
            $attributes_danger = null;
            $attributes_link = null;
            $is_outline = ($is_outline) ? '-outline' : '';
            if(is_array($attributes)){
                if(isset($attributes['class']) && is_array($attributes['class']) && count($attributes['class']) > 0){

                    $attributes_secondary = $attributes['class'];
                    array_unshift($attributes_secondary['class'],'btn'.$is_outline.'-secondary');
                    array_unshift($attributes_secondary['class'],'btn');

                    $attributes_primary = $attributes['class'];
                    array_unshift($attributes_primary['class'],'btn'.$is_outline.'-primary');
                    array_unshift($attributes_primary['class'],'btn');

                    $attributes_success = $attributes['class'];
                    array_unshift($attributes_success['class'],'btn'.$is_outline.'-success');
                    array_unshift($attributes_success['class'],'btn');

                    $attributes_info = $attributes['class'];
                    array_unshift($attributes_info['class'],'btn'.$is_outline.'-info');
                    array_unshift($attributes_info['class'],'btn');

                    $attributes_warning = $attributes['class'];
                    array_unshift($attributes_warning['class'],'btn'.$is_outline.'-warning');
                    array_unshift($attributes_warning['class'],'btn');

                    $attributes_danger = $attributes['class'];
                    array_unshift($attributes_danger['class'],'btn'.$is_outline.'-danger');
                    array_unshift($attributes_danger['class'],'btn');

                    $attributes_link = $attributes['class'];
                    array_unshift($attributes_link['class'],'btn'.$is_outline.'-link');
                    array_unshift($attributes_link['class'],'btn');

                    array_unshift($attributes['class'],'btn');

                }else if(isset($attributes['class'])){

                    $attributes_secondary['class'] = 'btn btn'.$is_outline.'-secondary '.$attributes['class'];

                    $attributes_primary['class'] = 'btn btn'.$is_outline.'-primary '.$attributes['class'];

                    $attributes_success['class'] = 'btn btn'.$is_outline.'-success '.$attributes['class'];

                    $attributes_info['class'] = 'btn btn'.$is_outline.'-info '.$attributes['class'];

                    $attributes_warning['class'] = 'btn btn'.$is_outline.'-warning '.$attributes['class'];

                    $attributes_danger['class'] = 'btn btn'.$is_outline.'-danger '.$attributes['class'];

                    $attributes_link['class'] = 'btn btn'.$is_outline.'-link '.$attributes['class'];

                    $attributes['class'] = 'btn '.$attributes['class'];
                }else{

                    $attributes_secondary['class'] = 'btn btn'.$is_outline.'-secondary';

                    $attributes_primary['class'] = 'btn btn'.$is_outline.'-primary';

                    $attributes_success['class'] = 'btn btn'.$is_outline.'-success';

                    $attributes_info['class'] = 'btn btn'.$is_outline.'-info';

                    $attributes_warning['class'] = 'btn btn'.$is_outline.'-warning';

                    $attributes_danger['class'] = 'btn btn'.$is_outline.'-danger';

                    $attributes_link['class'] = 'btn btn'.$is_outline.'-link';

                    $attributes['class'] = 'btn';
                }
            }
            $is_inner = ($tag_name == 'input') ? false : true;
            if($value && $is_inner && $tag_name != 'a') {
                $attributes_secondary['value'] = $value;
                $attributes_primary['value'] = $value;
                $attributes_success['value'] = $value;
                $attributes_info['value'] = $value;
                $attributes_warning['value'] = $value;
                $attributes_danger['value'] = $value;
                $attributes_link['value'] = $value;
                $attributes['value'] = $value;
            }
            if($value && $tag_name == 'a') {
                $attributes_secondary['href'] = $value;
                $attributes_primary['href'] = $value;
                $attributes_success['href'] = $value;
                $attributes_info['href'] = $value;
                $attributes_warning['href'] = $value;
                $attributes_danger['href'] = $value;
                $attributes_link['href'] = $value;
                $attributes['href'] = $value;
            }
            if($tag_name == 'a'){
                $type = false;
            }
            if($type) {
                $attributes_secondary['type'] = $type;
                $attributes_primary['type'] = $type;
                $attributes_success['type'] = $type;
                $attributes_info['type'] = $type;
                $attributes_warning['type'] = $type;
                $attributes_danger['type'] = $type;
                $attributes_link['type'] = $type;
                $attributes['type'] = $type;
            }
            $return_object->secondary = html::custom($tag_name,$name,$attributes_secondary,$is_inner);
            $return_object->primary = html::custom($tag_name,$name,$attributes_primary,$is_inner);
            $return_object->success = html::custom($tag_name,$name,$attributes_success,$is_inner);
            $return_object->info = html::custom($tag_name,$name,$attributes_info,$is_inner);
            $return_object->warning = html::custom($tag_name,$name,$attributes_warning,$is_inner);
            $return_object->danger = html::custom($tag_name,$name,$attributes_danger,$is_inner);
            $return_object->link = html::custom($tag_name,$name,$attributes_link,$is_inner);
            $return_object->none = html::custom($tag_name,$name,$attributes,$is_inner);
            $return_object->__default = $return_object->primary;
            $cache::set($md5_option,serialize($return_object),100000000);
            return $return_object;
        }
    }
}