<?php/*speedme framework*Author : Davit G.*contact-email: dxjan@ya.ru*/
namespace speedme\helper{
    class og extends helper {
        private static $meta = [];

        /**
         * @param array $meta
         */
        private static function setMeta($meta)
        {
            self::$meta[] = $meta;
        }
        /*
         * The canonical URL for your page.
         *  This should be the undecorated URL, without session variables, user identifying parameters, or counters.
         *  Likes and Shares for this URL will aggregate at this URL.
         *  For example, mobile domain URLs should point to the desktop version of the URL
         *  as the canonical URL to aggregate Likes and Shares across different versions of the page.
         */
        public function url($url = false){
            if($url){
               self::setMeta(['og:url',$url]);
            }
        }
        /*
         * The title of your article without any branding such as your site name.
         */
        public function title($title = false){
            if($title){
                self::setMeta(['og:title',$title]);
            }
        }
        /*
         * A brief description of the content,
         * usually between 2 and 4 sentences. This will displayed below the title of the post on Facebook.
         */
        public function description($description = false){
            if($description){
                self::setMeta(['og:description',$description]);
            }
        }
        /*
         * Image Sizes
         * Use images that are at least 1200 x 630 pixels for the best display on high resolution devices.
         * At the minimum, you should use images that are 600 x 315 pixels to display link page posts with larger images.
         * Images can be up to 8MB in size.
         * The URL of the image that appears when someone shares the content to Facebook.
         * Images are cached based on the URL and won't be updated unless the URL changes.
         * https://developers.facebook.com/docs/sharing/best-practices#images
         * url : same as image url
         * secure_url : https:// URL for the image
         * type : MIME type of the image. One of image/jpeg, image/gif or image/png
         * @param bool|string $image
         * @param bool|string $url
         * @param bool|string $secure_url
         * @param bool|string $type
         * @param bool|string $width
         * @param bool|string $height
         */
        public function image($image = false, $url = false, $secure_url = false, $type = false, $width = false, $height = false){
            if($image){
                self::setMeta(['og:image',$image]);
                if($url){
                    self::setMeta(['og:image:url',$image]);
                }
                if($secure_url){
                    self::setMeta(['og:image:secure_url',$secure_url]);
                }
                if($type){
                    self::setMeta(['og:image:type',$type]);
                }
                if($width){
                    self::setMeta(['og:image:width',$width]);
                }
                if($height){
                    self::setMeta(['og:image:height',$height]);
                }
            }
        }

        /**
         * In order to use Facebook Domain Insights you must add the app ID to your page.
         * Domain Insights lets you view analytics for traffic to your site from Facebook.
         * Find the app ID in your App Dashboard.
         * this is fb:app_id param
         * @param bool $app_id
         */
        public function app_id($app_id = false){
            if($app_id){
                self::setMeta(['fb:app_id',$app_id]);
            }
        }
        /*
         * The type of media of your content.
         * This tag impacts how your content shows up in News Feed. If you don't specify a type,the default is website.
         * Each URL should be a single object,
         * so multiple og:type values are not possible.
         * Find the full list of object types in our Object Types Reference
         * https://developers.facebook.com/docs/reference/opengraph#object-type
         */
        public function type($type = false){
            if($type){
                self::setMeta(['og:type',$type]);
            }
        }
        /*
         * The locale of the resource.
         * Defaults to en_US.
         * You can also use og:locale:alternate if you have other available language translations available.
         * Learn about the locales we support in our documentation on localization.
         * https://developers.facebook.com/docs/internationalization#locales
         */
        public function locale($locale = false){
            if($locale){
                self::setMeta(['og:locale',$locale]);
            }
        }
        /*
         * og:video : The URL for the video.
         * If you want the video to play in-line in News Feed, you should use the https:// URL if possible.
         * og:video:url : Equivalent to og:video
         * og:video:secure_url : Secure URL for the video. Include this even if you set the secure URL in og:video.
         * og:video:type : MIME type of the video. Either application/x-shockwave-flash or video/mp4.
         * og:video:width : Width of video in pixels. This property is required for videos.
         * og:video:height : Height of video in pixels. This property is required for videos.
         * use og->image to specify video poster
         * @param bool|string $video
         * @param bool|string $url
         * @param bool|string $secure_url
         * @param bool|string $type
         * @param bool|string $width
         * @param bool|string $height
         */
        public function video($video,$url = false, $secure_url = false, $type = false, $width = false, $height = false){
            if($video){
                self::setMeta(['og:video',$video]);
                if($url){
                    self::setMeta(['og:video:url',$video]);
                }
                if($secure_url){
                    self::setMeta(['og:video:secure_url',$secure_url]);
                }
                if($type){
                    self::setMeta(['og:video:type',$type]);
                }
                if($width){
                    self::setMeta(['og:video:width',$width]);
                }
                if($height){
                    self::setMeta(['og:video:height',$height]);
                }
            }
        }
        public static function set(){
            return new self;
        }
        public static function get(){
            $html = '';
            if(is_array(self::$meta) && count(self::$meta) > 0){
                foreach (self::$meta as $value){
                    $html .= '		<meta property="'.$value[0].'" content="'.$value[1].'"/>'."\n";
                }
            }
            return $html;
        }
        public static function reset(){
            self::$meta = [];
            return new self;
        }
    }
}