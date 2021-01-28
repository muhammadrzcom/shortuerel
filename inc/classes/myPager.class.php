<?php

			
            //error_reporting( E_ALL );
			//ini_set( 'display_errors', '1' );
			

			class myPager
			{

			     // declare some variables and default values
			     private $totalItems;
			     private $itemsPerPage = 10;
			     private $totalPages;
			     private $currentPage;

			     // navigation related
			     private $navigation = 9;
			     private $showNavigation_ = true;
			     private $navigatonButtonsPosition = 'inside';

			     // url related
			     private $get = 'page';
			     private $url = '';
			     private $seo = false;
			     private $seoUrl = 'page-##';

			     // info button related
			     private $showInfo = true;
			     private $infoText = '##page##/##pages##';
			     private $infoPosition = 'left';

			     // first / last buttons related
			     private $showFirstButton_ = true;
			     private $showLastButton_ = true;
			     private $firstSeparator = '...';
			     private $lastSeparator = '...';
			     private $firstButtonText = 'First';
			     private $lastButtonText = 'Last';

			     // blocks buttons related
			     private $blocksOffset = 1;
			     private $showFirstBlock_ = true;
			     private $showLastBlock_ = true;
			     private $min_;
			     private $max_;

			     // next / prev buttons related
			     private $showPrevButton_ = true;
			     private $showNextButton_ = true;
			     private $prevButton = '&lsaquo;&nbsp;Previous';
			     private $nextButton = 'Next&nbsp;&rsaquo;';

			     // id and class related
			     private $holder = 'pager';
			     private $class = 'default';
			     private $id = '';

			     // render extra info related
			     private $renderInfo_ = 'page: ##page##/##pages##';
			     private static $instance = 0;


			     /****************************************************************************/
			     /*  DO NOT EDIT AFTER THIS, UNLESS YOU KNOW EXACTLY WHAT ARE YOU DOING  ¬¬  */
			     /****************************************************************************/

			     // set total of items
			     public function setTotalItems( $var = null )
			     {
			          return $this->totalItems = is_numeric( $var ) ? $var : 0;
			     }

			     // get total of items
			     private function getItems()
			     {
			          return $this->totalItems;
			     }

			     // set items per page
			     public function setItemsPerPage( $items = null )
			     {
			          return $this->itemsPerPage = is_numeric( $items ) ? $items : $this->ItemsPerPage;
			     }

			     // get items per page
			     private function getItemsPerPage()
			     {
			          return $this->itemsPerPage;
			     }

			     // get total of pages
			     private function getTotalPages()
			     {
			          return $this->totalPages = ceil( $this->getItems() / $this->getItemsPerPage() );
			     }

			     // set the query variable to work
			     public function setQueryVar( $var = null )
			     {
			          return $this->get = is_string( $var ) ? trim( $var ) : $this->get;
			     }

			     // get and sanitize query string to allow only numbers and set max value of page.
			     private function getPage()
			     {
			          $var = filter_input( INPUT_GET, $this->get, FILTER_SANITIZE_NUMBER_INT );
			          $var = $var > $this->getTotalPages() ? $this->getTotalPages() : $var;
			          return $this->currentPage = ( !isset( $var ) || $var == null ) ? 1 : $var;
			     }

			     // set true or false navigation
			     public function showNavigation( $var = null )
			     {
			          return $this->showNavigation_ = is_bool( $var ) ? $var : $this->showNavigation_;
			     }

			     // set number of items to navigation
			     public function setNavigation( $var = null )
			     {
			          return $this->navigation = ( is_numeric( $var ) && $var > 2 ) ? $var : $this->navigation;
			     }

			     public function getNavigation( $var = null )
			     {
			          return $this->navigation;
			     }

			     // set enabled or disabled seo
			     public function enableSEO( $var = null )
			     {
			          return $this->seo = is_bool( $var ) ? $var : $this->seo;
			     }

			     // set the seo url variable
			     public function setSeoUrl( $var = null )
			     {
			          return $this->seoUrl = is_string( $var ) ? trim( $var ) : $this->seoUrl;
			     }

			     // set custom seo url
			     public function setURL( $var = null )
			     {
			          return $this->url = is_string( $var ) ? trim( $var ) : $this->url;
			     }

			     // show prev button
			     public function showPrevButton( $var = null )
			     {
			          return $this->showPrevButton_ = is_bool( $var ) ? $var : $this->showPrevButton_;
			     }

			     // show next button
			     public function showNextButton( $var = null )
			     {
			          return $this->showNextButton_ = is_bool( $var ) ? $var : $this->showNextButton_;
			     }

			     // set previous button
			     public function setPrevButton( $var = null )
			     {
			          return $this->prevButton = is_string( $var ) ? trim( $var ) : $this->prevButton;
			     }

			     // set next button
			     public function setNextButton( $var = null )
			     {
			          return $this->nextButton = is_string( $var ) ? trim( $var ) : $this->nextButton;
			     }

			     // choose where put the info
			     public function setNavButtonsPosition( $var = null )
			     {
			          $var = is_string( $var ) ? trim( strtolower( $var ) ) : '';
			          $options = array( 'inside', 'outside' );
			          return $this->navigatonButtonsPosition = self::choose( $options, $var ) ? $var : $this->navigatonButtonsPosition;
			     }

			     // show first button
			     public function showFirstButton( $var = null )
			     {
			          return $this->showFirstButton_ = is_bool( $var ) ? $var : $this->showFirstButton_;
			     }

			     // show last button
			     public function showLastButton( $var = null )
			     {
			          return $this->showLastButton_ = is_bool( $var ) ? $var : $this->showLastButton_;
			     }

			     // set first button
			     public function setFirstButton( $var = null )
			     {
			          return $this->firstButtonText = is_string( $var ) ? trim( $var ) : $this->firstButtonText;
			     }

			     // set last button
			     public function setLastButton( $var = null )
			     {
			          return $this->lastButtonText = is_string( $var ) ? trim( $var ) : $this->lastButtonText;
			     }

			     // enable or disable first blocks
			     public function showFirstBlock( $var = null )
			     {
			          return $this->showFirstBlock_ = is_bool( $var ) ? $var : $this->showFirstBlock_;
			     }

			     // enable or disable last blocks
			     public function showLastBlock( $var = null )
			     {
			          return $this->showLastBlock_ = is_bool( $var ) ? $var : $this->showLastBlock_;
			     }

			     // show first separator
			     private function showFirstSeparator( $var = null )
			     {
			          return $this->showFirstSeparator = is_bool( $var ) ? $var : false;
			     }

			     // set first separator text
			     public function setFirstSeparator( $var = null )
			     {
			          return $this->firstSeparator = is_string( $var ) ? trim( $var ) : $this->firstSeparator;
			     }

			     // set last separator text
			     public function setLastSeparator( $var = null )
			     {
			          return $this->lastSeparator = is_string( $var ) ? trim( $var ) : $this->lastSeparator;
			     }

			     // set holder for css style
			     public function setID( $var = null )
			     {
			          return $this->id = is_string( $var ) ? trim( $var ) : $this->id;
			     }

			     // set class for css style
			     public function setClass( $var = null )
			     {
			          return $this->class = is_string( $var ) ? trim( $var ) : $this->class;
			     }

			     // set id for css style
			     public function setHolder( $var = null )
			     {
			          return $this->holder = is_string( $var ) ? trim( $var ) : $this->holder;
			     }

			     // show or hide info
			     public function showInfo( $var = null )
			     {
			          return $this->showInfo = is_bool( $var ) ? $var : $this->showInfo;
			     }

			     // replace the info with your own text
			     public function setInfo( $var = null )
			     {
			          return $this->infoText = is_string( $var ) ? trim( $var ) : $this->infoText;
			     }

			     // choose where put the info
			     public function setInfoPosition( $var = null )
			     {
			          $var = is_string( $var ) ? trim( strtolower( $var ) ) : $var;
			          $options = array( 'left', 'right' );
			          return $this->infoPosition = self::choose( $options, $var ) ? $var : $this->infoPosition;
			     }

			     // set blocks offset
			     public function setBlocksOffset( $var = null )
			     {
			          $check = filter_var( $var, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'max_range' => 3 ) ) );
			          return $this->blocksOffset = $check ? $check : $this->blocksOffset;
			     }

			     // get blocks offset
			     private function getBlocksOffset()
			     {
			          return $this->blocksOffset;
			     }

			     // different text for buttons
			     private function replaceText( $var = null )
			     {
			          $ahead = $this->getTotalPages() - $this->max_;
			          $behind = $this->min_ - 1;
			          $nextPage = self::quickCheck( $this->getPage() + 1 ) ? $this->getPage() + 1 : $this->getPage();
			          $prevPage = self::quickCheck( $this->getPage() - 1 ) ? $this->getPage() - 1 : $this->getPage();
			          $search = array( '##page##', '##pages##', '##items##', '##pages-behind##', '##pages-ahead##', '##page+1##', '##page-1##' );
			          $replace = array( $this->getPage(), $this->getTotalPages(), $this->getItems(), $behind, $ahead, $nextPage, $prevPage );
			          return is_string( $var ) ? str_replace( $search, $replace, trim( $var ) ) : '';
			     }

			     // look into array and search a value
			     private function choose( $array = null, $var = null )
			     {
			          $array = !is_array( $array ) ? array() : $array;
			          return in_array( $var, $array ) ? true : false;
			     }
                 
                 // make base url   
			     private function makeBaseUrl()
			     {
			          $self = end( explode( '/', $_SERVER['REQUEST_URI'] ) );
			          $self = explode( $this->get, $self );
			          $self = ( substr( $self[0], -1 ) == '?' || substr( $self[0], -1 ) == '&' ) ? substr( $self[0], 0, -1 ) : $self[0];
			          $char = strpos( $self, '?' ) !== false ? '&' : '?';
			          $base = $this->url != '' ? $this->url : $self;
			          $return = $base . $char . $this->get . '=';
			          return $return;
			     }                 

			     // construct url
			     private function makeUrl( $page = null, $showComplete = true )
			     {
			          // check for full url
			          if ( $showComplete ) {
			               // set min / max page value
			               $page = $page < 1 ? 1 : ( int )$page;
		        	       $page = $page > $this->getTotalPages() ? $this->getTotalPages() : ( int )$page;
			          }

			          // if user set SEO on
			          if ( $this->seo ) {
			               $replace = $showComplete ? $page : '';
			               $return = str_replace( '##', $replace, $this->seoUrl );
			               // default working mode
			          } else {
			               $request = explode( '/', $_SERVER['REQUEST_URI'] );
                           $self = end( $request );
			               $self = explode( $this->get, $self );
			               $self = ( substr( $self[0], -1 ) == '?' || substr( $self[0], -1 ) == '&' ) ? substr( $self[0], 0, -1 ) : $self[0];
			               $char = strpos( $self, '?' ) !== false ? '&' : '?';
			               $baseUrl = $this->url != '' ? $this->url : $self;
			               $fullUrl = $baseUrl . $char . $this->get . '=';
			               $return = $showComplete ? $fullUrl . $page : $fullUrl;
			          }
			          //return
			          return $return;
			     }
                 
			     // first button
			     private function firstButton()
			     {
			          $check = ( $this->currentPage == 1 ) ? true : false;
			          $text = $this->replaceText( $this->firstButtonText );
			          $link = $check ? $text : '<a href="' . $this->makeUrl( 1 ) . '">' . $text . '</a>';
			          return $this->showFirstButton_ ? '<li class="' . ( $check ? 'disabled' : 'first' ) . '">' . $link . '</li>' : '';
			     }

			     // last button
			     private function lastButton()
			     {
			          $check = $this->currentPage == $this->getTotalPages() ? true : false;
			          $text = $this->replaceText( $this->lastButtonText );
			          $link = $check ? $text : '<a href="' . $this->makeUrl( $this->getTotalPages() ) . '">' . $text . '</a>';
			          return $this->showLastButton_ ? '<li class="' . ( $check ? 'disabled' : 'last' ) . '">' . $link . '</li>' : '';

			     }

			     // first separator
			     private function firstSeparator()
			     {
			          return '<li class="separator">' . $this->replaceText( $this->firstSeparator ) . '</li>';
			     }

			     // last separator
			     private function lastSeparator()
			     {
			          return '<li class="separator">' . $this->replaceText( $this->lastSeparator ) . '</li>';
			     }

			     // first two blocks
			     private function firstBlocks()
			     {
			          $blocks = '';
			          if ( $this->showFirstBlock_ && $this->getBlocksOffset() > 0 ) {
			               $offset = $this->getBlocksOffset();
			               for ( $i = 1; $i <= $offset; $i++ ) {
			                    $blocks .= '<li class="blocks"><a href="' . $this->makeUrl( $i ) . '">' . $i . '</a></li>';
			               }
			               $blocks .= $this->firstSeparator();
			          }
			          return $blocks;
			     }

			     // last two blocks
			     private function lastBlocks()
			     {
			          $blocks = '';
			          if ( $this->showLastBlock_ && $this->getBlocksOffset() > 0 ) {
			               $blocks .= $this->lastSeparator();
			               $offset = $this->getBlocksOffset() - 1;
			               for ( $i = $this->getTotalPages() - $offset; $i <= $this->getTotalPages(); $i++ ) {
			                    $blocks .= '<li class="blocks"><a href="' . $this->makeUrl( $i ) . '">' . $i . '</a></li>';
			               }
			          }
			          return $blocks;
			     }

			     // previous button
			     private function prevButton()
			     {
			          $check = $this->currentPage == 1 ? true : false;
			          $text = $this->replaceText( $this->prevButton );
			          $link = $check ? $text : '<a href="' . $this->makeUrl( $this->getPage() - 1 ) . '">' . $text . '</a>';
			          return $this->showPrevButton_ ? '<li class="' . ( $check ? 'disabled' : 'prev' ) . '">' . $link . '</li>' : '';

			     }

			     // next button
			     private function nextButton()
			     {
			          $check = $this->currentPage == $this->getTotalPages() ? true : false;
			          $text = $this->replaceText( $this->nextButton );
			          $link = $check ? $text : '<a href="' . $this->makeUrl( $this->getPage() + 1 ) . '">' . $text . '</a>';
			          return $this->showNextButton_ ? '<li class="' . ( $check ? 'disabled' : 'next' ) . '">' . $link . '</li>' : '';
			     }

			     // info button
			     private function infoButton()
			     {
			          return $this->showInfo ? '<li class="infobox">' . $this->replaceText( $this->infoText ) . '</li>' : '';
			     }

			     // check if current page is valid
			     private function quickCheck( $var = null )
			     {
			          $check = filter_var( $var, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'max_range' => $this->getTotalPages() ) ) );
			          return $check ? true : false;
			     }


			     // build the pager
			     private function build()
			     {
			          // start the navigation
			          $navigation = '';

			          // show / hide navigation
			          if ( $this->showNavigation_ ) {

			               // prepare navigation
			               if ( $this->getPage() < 3 + ( $this->getNavigation() - 1 ) / 2 ) {
			                    $min = 1;
			                    $max = $this->getNavigation();


			                    $this->showFirstBlock_ = false;

			                    if ( $this->showFirstBlock_ || $this->showLastBlock_ ) {
			                         $max = ( $this->showFirstBlock_ && !$this->showLastBlock_ ) ? $max + $this->getBlocksOffset() : $max;
			                         $max = ( !$this->showFirstBlock_ && $this->showLastBlock_ ) ? $max - $this->getBlocksOffset() : $max;
			                    }

			                    $stage = 'one';

			               } elseif ( $this->getPage() > $this->getTotalPages() - ( $this->getNavigation() - 1 ) / 2 - 2 ) {
			                    $min = $this->getTotalPages() - $this->getNavigation() + 1;
			                    $max = $this->getTotalPages();

			                    $this->showLastBlock_ = false;

			                    if ( $this->showFirstBlock_ || $this->showLastBlock_ ) {
			                         $min = ( $this->showFirstBlock_ && !$this->showLastBlock_ ) ? $min + $this->getBlocksOffset() : $min;
			                    }

			                    $stage = 'two';

			               } else {
			                    $min = $this->getPage() - ceil( ( $this->navigation - 2 ) / 2 );
			                    $max = $min + $this->getNavigation() - 1;
			                    $diff = $this->getTotalPages() - ( $this->getBlocksOffset() * 2 ) - 1;

			                    if ( $this->showFirstBlock_ || $this->showLastBlock_ ) {
			                         $min = ( $this->showFirstBlock_ && $this->showLastBlock_ ) ? $min + $this->getBlocksOffset() : $min;
			                         $max = ( $this->showFirstBlock_ && $this->showLastBlock_ ) ? $max - $this->getBlocksOffset() : $max;
			                         $min = ( $this->showFirstBlock_ && !$this->showLastBlock_ ) ? $min + $this->getBlocksOffset() : $min;
			                         $max = ( !$this->showFirstBlock_ && $this->showLastBlock_ ) ? $max - $this->getBlocksOffset() : $max;
			                    }

			                    $stage = 'three';

			               }

			               // set min value
			               $min = $min < 1 ? 1 : $min;

			               // set max value
			               $max = $max > $this->getTotalPages() ? $this->getTotalPages() : $max;

			               // set the variables
			               $this->min_ = $min;
			               $this->max_ = $max;

			               // the loop for each number
			               for ( $i = $min; $i <= $max; $i++ ) {
			                    $navigation .= $this->showFirstBlock_ && $i == $min ? $this->firstBlocks() : '';
			                    $content = ( $i == $this->getPage() ) ? $i : '<a href="' . $this->makeUrl( $i ) . '">' . $i . '</a>';
			                    $navigation .= ( $i == $this->getPage() ) ? '<li class="selected">' . $content . '</li>' : '<li class="link">' . $content . '</li>';
			                    $navigation .= $this->showLastBlock_ && $i == $max ? $this->lastBlocks() : '';
			               }
			          }

			          // inside / outside navigation buttons
			          $inside = $this->firstButton() . $this->prevButton() . $navigation . $this->nextButton() . $this->lastButton();
			          $outside = $this->prevButton() . $this->firstButton() . $navigation . $this->lastButton() . $this->nextButton();

			          // position of the navigation buttons
			          $display = $this->navigatonButtonsPosition == 'inside' ? $inside : $outside;

			          // position of the info button
			          $return = $this->infoPosition == 'left' ? $this->infoButton() . $display : $display . $this->infoButton();

			          // return
			          return $return;
			     }

			     /* output public functions */

			     // render the pager
			     public function render()
			     {
			          $return = '';
			          if ( $this->getTotalPages() > 1 ) {
			               $return .= '<ul class="' . $this->holder . ' ' . $this->class . '">' . "\r\n";
			               $return .= $this->build() . "\r\n";
			               $return .= '</ul>' . "\r\n";
			          }
			          return $return;
			     }

			     // render next page link
			     public function renderNextLink( $data = null )
			     {
			          $link = self::quickCheck( $this->getPage() + 1 ) ? $this->makeUrl( $this->getPage() + 1 ) : $this->makeUrl( $this->getPage() );
			          $text = is_string( $data ) ? $this->replaceText( $data ) : false;
			          return $text ? '<a href="' . $link . '">' . $text . '</a>' : $link;
			     }

			     // render prev page link
			     public function renderPrevLink( $data = null )
			     {
			          $link = self::quickCheck( $this->getPage() - 1 ) ? $this->makeUrl( $this->getPage() - 1 ) : $this->makeUrl( $this->getPage() );
			          $text = is_string( $data ) ? $this->replaceText( $data ) : false;
			          return $text ? '<a href="' . $link . '">' . $text . '</a>' : $link;
			     }

			     // render first pagelink
			     public function renderFirstLink( $data = null )
			     {
			          $link = $this->makeUrl( 1 );
			          $text = is_string( $data ) ? $this->replaceText( $data ) : false;
			          return $text ? '<a href="' . $link . '">' . $text . '</a>' : $link;
			     }

			     // render first pagelink
			     public function renderLastLink( $data = null )
			     {
			          $link = $this->makeUrl( $this->getTotalPages() );
			          $text = is_string( $data ) ? $this->replaceText( $data ) : false;
			          return $text ? '<a href="' . $link . '">' . $text . '</a>' : $link;
			     }

			     // render a X page link
			     public function renderPageLink( $page = null, $data = null )
			     {
			          $link = is_numeric( $page ) ? $this->makeUrl( $page ) : $this->makeUrl( $this->getPage() );
			          $text = is_string( $data ) ? trim( $data ) : false;
			          return $text ? '<a href="' . $link . '">' . $text . '</a>' : $link;
			     }

			     // render extra info span
			     public function renderExtraInfo( $data = null )
			     {
			          $instance = self::$instance == 0 ? '' : ' ins-' . self::$instance;
			          $text = is_string( $data ) ? $this->replaceText( $data ) : $this->replaceText( $this->renderInfo_ );
			          self::$instance++;
			          return '<span class="pagerExtraInfo' . $instance . '">' . $text . '</span>';
			     }

			     // render jumping menu
			     public function renderJumpMenu( $data = null )
			     {
			          $text = is_string( $data ) ? trim( $data ) : 'Go!';
			          $return = '<select id="pagerJumpMenu" class="jumpMenu">' . "\r\n";
			          for ( $i = 1; $i <= $this->getTotalPages(); $i++ ) {
			               $selected = $i == $this->getPage() ? ' selected' : '';
			               $return .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
			          }
			          $return .= '</select>' . "\r\n";
			          $return .= '<input type="button" value="' . $text . '" class="jumpMenuButton" onClick="window.location=(\'' . $this->makeUrl( null, false ) .
			               '\'+getElementById(\'pagerJumpMenu\').options[getElementById(\'pagerJumpMenu\').selectedIndex].value);">' . "\r\n";
			          return $return;
			     }

			     // get the current page to use in mysql
			     public function getQuery()
			     {
			          return $this->getPage();
			     }

			     // get the limit to use in mysql
			     public function getQueryLimit()
			     {
			          return ( $this->getPage() - 1 ) * $this->getItemsPerPage();
			     }

			     // get the offset to use in mysql
			     public function getQueryOffset()
			     {
			          return $this->getItemsPerPage();
			     }

			}