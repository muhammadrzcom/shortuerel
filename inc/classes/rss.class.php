<?php


			//error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );

			class myFeed
			{
			     // channel related
			     private $channelTitle;
			     private $channelDescription;
			     private $channelLink;
			     private $channelImage;
			     private $channelImageWidth = 88;
			     private $channelImageHeight = 31;
			     private $channelLanguage = 'en-us';
			     private $channelCopyright;
			     private $channelTtl;
			     private $channelCDATA = true;
			     private $channelGenerator;
			     private $items = array();

			     // items related
			     private $itemTitle;
			     private $itemDescription;
			     private $itemLink;
			     private $itemDate;

			     // others
			     private static $instance = 0;
			     private $version = '1.0';


			     // constructor
			     public function __construct()
			     {
			          $this->channelLink = self::is_url( $this->getChannelLink() ) ? $this->getChannelLink() : self::makeSelfUrl();
			     }

			     // set channel title
			     public function setChannelTitle( $var = null )
			     {
			          return $this->channelTitle = is_string( $var ) ? trim( $var ) : false;
			     }

			     // get channel title
			     private function getChannelTitle()
			     {
			          return $this->channelTitle;
			     }

			     // set channel description
			     public function setChannelDesc( $var = null )
			     {
			          return $this->channelDescription = is_string( $var ) ? trim( $var ) : false;
			     }

			     // get channel description
			     private function getChannelDesc()
			     {
			          return $this->channelDescription;
			     }

			     // set channel image
			     public function setChannelImage( $var = null )
			     {
			          return $this->channelImage = self::is_imageurl( $var ) ? $var : false;
			     }

			     // get channel image
			     private function getChannelImage()
			     {
			          return $this->channelImage;
			     }

			     // set channel image width
			     public function setImageWidth( $var = null )
			     {
			          $check = filter_var( $var, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'max_range' => 144 ) ) );
			          return $this->channelImageWidth = $check ? $var : $this->channelImageWidth;
			     }

			     // set channel image height
			     public function setImageHeight( $var = null )
			     {
			          $check = filter_var( $var, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'max_range' => 400 ) ) );
			          return $this->channelImageHeight = $check ? $var : $this->channelImageHeight;
			     }

			     // set channel link
			     public function setChannelLink( $var = null )
			     {
			          return $this->channelLink = self::is_url( $var ) ? $var : self::makeSelfUrl();
			     }

			     // get channel link
			     private function getChannelLink()
			     {
			          return $this->channelLink;
			     }

			     // set channel Language
			     public function setChannelLang( $var = null )
			     {
			          $langs = array( 'af', 'sq', 'eu', 'be', 'bg', 'ca', 'zh-cn', 'zh-tw', 'hr', 'cs', 'da', 'nl', 'nl-be', 'nl-nl', 'en', 'en-au', 'en-bz',
			               'en-ca', 'en-ie', 'en-jm', 'en-nz', 'en-ph', 'en-za', 'en-tt', 'en-gb', 'en-us', 'en-zw', 'et', 'fo', 'fi', 'fr', 'fr-be', 'fr-ca', 'fr-fr',
			               'fr-lu', 'fr-mc', 'fr-ch', 'gl', 'gd', 'de', 'de-at', 'de-de', 'de-li', 'de-lu', 'de-ch', 'ei', 'haw', 'hu', 'is', 'in', 'ga', 'it', 'it-it',
			               'it-ch', 'ko', 'mk', 'no', 'pl', 'pt', 'pt-br', 'pt-pt', 'to', 'ro-mo', 'ro-ro', 'ru', 'ru-mo', 'ru-ru', 'sr', 'sk', 'sl', 'es', 'es-ar',
			               'es-bo', 'es-cl', 'es-cr', 'es-do', 'es-ec', 'es-sv', 'es-gt', 'es-hn', 'es-mx', 'es-ni', 'es-pa', 'es-py', 'es-pe', 'es-pr', 'es-es',
			               'es-uy', 'es-ve', 'sv', 'sv-fi', 'sv-se', 'tr', 'uk' );
			          return $this->channelLanguage = in_array( strtolower( $var ), $langs ) ? trim( strtolower( $var ) ) : $this->channelLanguage;
			     }

			     // get channel Language
			     private function getChannelLang()
			     {
			          return $this->channelLanguage;
			     }

			     // set channel Copyright
			     public function setChannelCopyright( $var = null )
			     {
			          return $this->channelCopyright = is_string( $var ) ? trim( $var ) : false;
			     }

			     // get channel Copyright
			     private function getChannelCopyright()
			     {
			          return $this->channelCopyright;
			     }

			     // set channel ttl
			     public function setChannelTTL( $var = null )
			     {
			          return $this->channelTtl = is_int( $var ) ? $var : $this->channelTtl;
			     }

			     // get channel ttl
			     private function getChannelTTL()
			     {
			          return $this->channelTtl;
			     }

			     // set channel cdata
			     public function setChannelCdata( $var = null )
			     {
			          return $this->channelCDATA = filter_var( $var, FILTER_VALIDATE_BOOLEAN ) ? true : false;
			     }

			     // get channel cdata
			     private function getChannelCdata()
			     {
			          return $this->channelCDATA;
			     }

			     // set channel generator
			     public function setChannelGenerator( $var = null )
			     {
			          return $this->channelGenerator = is_string( $var ) ? trim( $var ) : $this->channelGenerator;
			     }

			     // get channel generator
			     private function getChannelGenerator()
			     {
			          return $this->channelGenerator;
			     }

			     // reset
			     private function reset()
			     {
			          $this->items = array();
			          $this->channelCDATA = false;
			          $this->channelCopyright = null;
			          $this->channelImage = null;
			          $this->channelLanguage = 'en-us';
			          return;
			     }

			     // make self url
			     private function makeSelfUrl()
			     {
			          return isset( $_SERVER['HTTPS'] ) && filter_var( $_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN ) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] .
			               $_SERVER['REQUEST_URI'];
			     }

			     // url validator
			     public static function is_url( $var = null )
			     {
			          return is_string( $var ) && preg_match( "#(http:\/\/(.*)&?.*?)#i", $var ) ? true : false;
			     }

			     // url image validator
			     public static function is_imageurl( $var = null )
			     {
			          return is_string( $var ) && preg_match( "#(http:\/\/(.*)\.(gif|png|jpg|jpeg)&?.*?)#i", $var ) ? true : false;
			     }

			     // email validator
			     private function is_email( $var = null )
			     {
			          return filter_var( trim( $var ), FILTER_VALIDATE_EMAIL ) ? true : false;
			     }


			     /* items related */


			     private function checkKey( $key )
			     {
			          return isset( $this->items[self::$instance][$key] ) ? self::$instance++ : false;
			     }

			     // set item title
			     public function setItemTitle( $var = null )
			     {
			          self::checkKey( 'title' );
			          return $this->items[self::$instance]['title'] = is_string( $var ) ? trim( $var ) : false;
			     }

			     // get item title
			     private function getItemTitle( $var = null )
			     {
			          return isset( $this->items[$var]['title'] ) ? $this->items[$var]['title'] : false;
			     }

			     // set item description
			     public function setItemDesc( $var = null )
			     {
			          self::checkKey( 'description' );
			          return $this->items[self::$instance]['description'] = is_string( $var ) ? trim( $var ) : false;
			     }

			     // get item title
			     private function getItemDesc( $var = null )
			     {
			          return isset( $this->items[$var]['description'] ) ? $this->getChannelCdata() ? '<![CDATA[' . trim( $this->items[$var]['description'] ) .
			               ']]>' : $this->items[$var]['description'] : false;
			     }

			     // set item link
			     public function setItemLink( $var = null )
			     {
			          self::checkKey( 'link' );
			          return $this->items[self::$instance]['link'] = self::is_url( $var ) ? $var : false;
			     }

			     // get item link
			     private function getItemLink( $var = null )
			     {
			          return isset( $this->items[$var]['link'] ) ? $this->items[$var]['link'] : false;
			     }

			     // set item date
			     public function setItemDate( $var = null )
			     {
			          self::checkKey( 'date' );
			          return $this->items[self::$instance]['date'] = is_string( $var ) ? trim( $var ) : false;
			     }

			     // get item date
			     private function getItemDate( $var = null )
			     {
			          return isset( $this->items[$var]['date'] ) ? self::changedate( $this->items[$var]['date'] ) : false;
			     }

			     // set headers to serve rss feed
			     private function setHeaders()
			     {
			          header( "Content-type: application/xml" );
			     }

			     // change timestamp to gmdate
			     private function changedate( $var = null )
			     {
			          return is_numeric( $var ) ? gmdate( "r", $var ) : false;
			     }

			     // cdata
			     private function cdata( $var = null )
			     {
			          return '<![CDATA[' . trim( $var ) . ']]>';
			     }


			     // open channel
			     private function openChannel()
			     {
			          $feed = '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
			          $feed .= '<rss version="2.0"  xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
			          $feed .= '<channel>' . "\n";
			          $feed .= $this->getChannelTitle() ? '<title>' . $this->getChannelTitle() . '</title>' . "\n" : die( 'Error: Channel title missing' );
			          $feed .= $this->getChannelLink() ? '<link>' . htmlentities( $this->getChannelLink() ) . '</link>' . "\n" . '<atom:link href="' . htmlentities( $this->
			               getChannelLink() ) . '" rel="self" type="application/rss+xml" />' . "\n" : die( 'Error: Channel link missing' );
			          $feed .= $this->getChannelDesc() ? '<description>' . $this->getChannelDesc() . '</description>' . "\n" : die( 'Error: Channel description missing' );
			          $feed .= '<language>' . $this->getChannelLang() . '</language>' . "\n";
			          $feed .= '<lastBuildDate>' . date( "r" ) . '</lastBuildDate>' . "\n";
			          $feed .= $this->getChannelImage() ? '<image><url>' . htmlentities( $this->getChannelImage() ) . '</url><title>' . $this->getChannelTitle() .
			               '</title><link>' . htmlentities( $this->getChannelLink() ) . '</link><width>' . $this->channelImageWidth . '</width><height>' . $this->
			               channelImageWidth . '</height></image>' . "\n" : '';
			          $feed .= $this->getChannelGenerator() ? '<generator>' . $this->getChannelGenerator() . '</generator>' . "\n" : '';
			          $feed .= $this->getChannelTTL() ? '<ttl>' . $this->getChannelTTL() . '</ttl>' . "\n" : '';
			          $feed .= $this->getChannelCopyright() ? '<copyright>' . $this->getChannelCopyright() . '</copyright>' . "\n" : '';
			          return $feed;
			     }

			     // close channel
			     private function closeChannel()
			     {
			          return '</channel>' . "\n" . '</rss>';
			     }

			     // make items
			     private function makeItem( $var = null )
			     {
			          $item = '<item>' . "\n";
			          $item .= $this->getItemTitle( $var ) ? '<title>' . $this->getItemTitle( $var ) . '</title>' . "\n" : die( 'Error: Item title missing' );
			          $item .= $this->getItemDesc( $var ) ? '<description>' . $this->getItemDesc( $var ) . '</description>' . "\n" : die( 'Error: Item description missing' );
			          $item .= $this->getItemLink( $var ) ? '<link>' . $this->getItemLink( $var ) . '</link>' . "\n" : die( 'Error: Item link missing' );
			          $item .= $this->getItemDate( $var ) ? '<pubDate>' . $this->getItemDate( $var ) . '</pubDate>' . "\n" : '';
			          $item .= '<guid isPermaLink="true">' . $this->getItemLink( $var ) . '</guid>' . "\n";
			          $item .= '</item>' . "\n";
			          return $item;
			     }

			     // show feed
			     public function showFeed()
			     {
			          $this->setHeaders();
			          $feed = $this->openChannel();
			          if ( count( $this->items ) > 0 ) {
			               foreach ( $this->items as $key => $item ) {
			                    $feed .= self::makeItem( $key );
			               }
			          }
			          $feed .= $this->closeChannel();
			          $this->reset();
			          return $feed;
			     }

			}
