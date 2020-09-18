    <?php 
     /**
     * Links class holds all links processed in array
     *
     * @author  Alvin Mwendwa Muthui
     * @license MIT
     */
    class Links{
        
        /**
         * link_arry holds link objects in array
         *
         * @var array
         */
        private $link_arry=array();
        
        /**
         * addLink adds link object to Links
         *
         * @param  Link $link
         * @return void
         */
        function addLink($link){
            if(!$this->isURLExistingInLinkArry($link->getURL())){
                $this->crawlPage($link);
            }
            
        }
        
        /**
         * isURLExistingInLinkArry determines if Link object exists in Links
         *
         * @param  string $url
         * @return void
         */
        function isURLExistingInLinkArry($url){
            foreach($this->link_arry as $link){
                if($link->getURL()==$url){
                    return true;
                }
            }
            return false;
        }
        
        /**
         * crawlPage Crawls a page using link object to get more links
         *
         * @param  Link $link
         * @return void
         */
        function crawlPage($link){
            echo 'Discovered: '.$link->getURL().'<br>';
            $link->setCrawled(true);
            array_push($this->link_arry,$link);
            getPageLinks($link->getURL());
        }

                
        /**
         * getAllLinks returns all Link objects in Links object
         *
         * @return Links
         */
        function getAllLinks(){
            return $this->link_arry;
        }
        
    }
?>