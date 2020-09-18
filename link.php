<?php 
    /**
     * Link class holds link details such as URL, depth and isCrawled
     *
     * @author  Alvin Mwendwa Muthui
     * @license MIT
     */
    class Link{
        /**
         * Holds URLs
         *
         * @var string
         */
        private $url="";

        /**
         * Holds the depeth of the link from site URL provided by user
         *
         * @var int
         */
        private $depth=1;

        /**
         * Whether page is crawled or not.
         *
         * @var boolean
         */
        private $isCrawled=false;


        /**
         * Assigns value to Link URL
         *
         * @param  string $url The Link URL
         */
        function setURL($url){
            $this->url=$url;
        }

        /**
         * Assigns value to Link depth
         *
         * @param  string $depth The Link depth
         */
        function setDepth($depth){
            $this->depth=$depth;
        }

        /**
         * Assigns value to Link isCrawled
         *
         * @param  bool $isCrawled The Link URL
         */
        function setCrawled($isCrawled){
            $this->isCrawled=$isCrawled;
        }

        /**
         * Assigns value to Link URL
         *
         * @param  string $url The Link URL
         */
        function getURL(){
            return $this->url;
        }

                
        /**
         * getDepth returns depth of url from provided site url
         *
         * @return int
         */
        function getDepth(){
            return $this->depth;
        }
        
        /**
         * getCrawled returns when page is crawled or not
         *
         * @return bool
         */
        function getCrawled(){
            return $this->isCrawled;
        }
    }
?>