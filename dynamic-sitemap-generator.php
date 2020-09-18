<?php 
/**
 * 
 * @author Alvin Muthui ()
 * @link www.alvinmuthui.ga
 * @version 1.0.0
 * @license MIT
 * 
 */
    require_once("genConfig.php");
    require_once("links.php");
    require_once("link.php");
    require_once("xmlWriter.php");

    /**Hide or show errors */
    if($hide_errors){/*hide*/
        error_reporting(0);
        ini_set('display_errors', 0);
    }else {/*show*/
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    set_time_limit($code_execution_timeout);/*Set time limit for code to be executed*/
    
    $tmp_urls_array=array();/*array to hold sanitized urls in the reject list*/
    foreach($do_not_index_urls_arry as $url){
        $url=getSanitizedURL($url);
        
        if(!hasDesiredPHPURLScheme($url)){
            echo 'do_not_index_urls_arry should have scheme such as http or https. For example https://www.example.com';
            return; /*end execution*/
        }
        array_push($tmp_urls_array,$url);/*Push the sanitized URL to the temporaly array*/
    }
    $do_not_index_urls_arry=$tmp_urls_array;/*Overwrite the array with santized values*/
    //print_r($do_not_index_urls_arry);
    $site_url=getSanitizedURL($site_url);
    $page_url=getSanitizedURL($site_url);//holds the url for page to be crawled;
    $page_url=removeFowardslash($page_url);
    if(!hasDesiredPHPURLScheme($page_url)){
        echo 'site_url should have scheme such as http or https. For example https://www.example.com';
        return; /*end execution*/
    }
    $file_name=filter_var($file_name, FILTER_SANITIZE_STRING);/*Sanitize filename*/
    $change_frequency=filter_var($change_frequency, FILTER_SANITIZE_STRING);/*Sanitize change frequency*/

    //$extensions_arry/*Sanitize extensions*/
    echo 'Crawling...'.$site_url.'<br>';
    $link_obj=new Link();
    $link_obj->setURL($page_url);
    $link_obj->setDepth(getPageDepth($page_url));
    $links_obj=new Links();
    $links_obj->addLink($link_obj);

    /*Write the file*/
    $write=new WriteFile();
    $write->writeContent($file_name, $site_url, $priority,$change_frequency,$links_obj->getAllLinks());
   
    

    
    










/*Sanitinize before executin code below */



   
    
        
    /**
     * getPageLinks Reads web document and obtains links
     *
     * @param  string $url
     * @return void
     */
    function getPageLinks($url){
        /* try to get the file from the site*/
        try {
            $html = file_get_contents($url);/* get file from URL*/
            $dom = new DOMDocument;/*Create new DOM Documents*/
            @$dom->loadHTML($html);/*load the HTML file as DOM and @is used to suppress errors for invalid XHTML */
            $links = $dom->getElementsByTagName('a');/*Get all links by using a tag*/
            
            
            
            
            foreach ($links as $link){/*Loop through to get specific URL*/
                $processed_url=removeFowardslash(getRealUrl(getSanitizedURL($link->getAttribute('href'))));/*Use attribute href to get URL*/
                if(isURLAcceptable($processed_url)){/*Determine if the processed url meets the set requirements*/
                    /*Create link object then add it to links object*/
                    $link_obj=new Link();
                    $link_obj->setURL($processed_url);
                    $link_obj->setDepth(getPageDepth($processed_url));
                    global $links_obj;
                    $links_obj->addLink($link_obj);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
    /**
     * getRealUrl gets converted external accessible URL from part of url
     *
     * @param  string $url
     * @return string
     */
    function getRealUrl($url){/*convert part of url to external accessible URL */
        global $page_url;/*access global var in the function*/
        if($url=="#"){/*self refrencing page return with page link*/
            return $page_url;
        }else if($url=="/"){/*self refrencing page return with page link*/
            return $page_url;
        }else if(preg_match("#^/#",$url)){/*convert /somepage to pageurl/somepage*/
            return $page_url.$url;
        }else if(preg_match("/^#+./",$url)){/*convert #refrence to pageurl#refrence*/
            return $page_url.$url;
        }else if(preg_match("/.*:/",$url)){/*return special URL such as mailto: , tel: as they are*/
            return $url;
        }
        else{/*convert somepage pageurl/somepage*/
           return $page_url."/".$url;
        }
    }

        
    /**
     * isURLAcceptable Determines if url is acceptable based on user specifield conditions
     *
     * @param  string $url
     * @return bool
     */
    function isURLAcceptable($url){
        global $block_urls_with_its_children,$eliminate_nav_links;
        if($eliminate_nav_links && preg_match("/#/",$url)){/*eliminate inter page refrence*/
            return false;
        }else if(!isSameRootSite($url)){
            return false;
        }else if(isURLBlocked($url)||($block_urls_with_its_children&&isParentBlocked($url))){/*check if URL is the list of blocking*/
            return false;
        }else if(!hasDesiredPHPURLScheme($url)){/*eliminate special URL such as mailto: , tel:*/
            return false;
        /**/}else if(hasDesiredExtention($url)){/*Accept link*/
            return true;
        }else{/*reject other links*/
            return false;
        }
        
    }
    
    /**
     * hasDesiredExtention Determines if link has any extention defined by user
     *
     * @param  string $url
     * @return bool
     */
    function hasDesiredExtention($url){
        global $extensions_arry;/*Access global variable */
        $result=false;
        $ext=pathinfo($url, PATHINFO_EXTENSION);/*Obtain file extention */
        if($ext=="" && in_array(strtolower("/"), array_map('strtolower', $extensions_arry)) ){/*is base extesion does exist but base URL is acceptable */
            return true;
        }else if(in_array(strtolower($ext), array_map('strtolower', $extensions_arry))){
            return true;
        }
        return false;
    }

        
    /**
     * hasDesiredPHPURLScheme Determines if link has either http or https
     *
     * @param  string $url
     * @return bool
     */
    function hasDesiredPHPURLScheme($url){
        return (parse_url($url, PHP_URL_SCHEME)=="http" || parse_url($url, PHP_URL_SCHEME)=="https");
    }

        
    /**
     * isSameRootSite Checks if user isued site belongs to same root site
     *
     * @param  string $url
     * @return bool
     */
    function isSameRootSite($url){
        global $site_url;
        return linkStartsWith(strtolower($url),strtolower($site_url));/*avoids navigating backwards and mapping external sites*/
    }
    
    /**
     * isURLBlocked Determines if URL is blocked 
     *
     * @param  string $url
     * @return bool
     */
    function isURLBlocked($url){
        global $do_not_index_urls_arry;
        return in_array(strtolower($url), array_map('strtolower', $do_not_index_urls_arry));
    }
    
    /**
     * getSanitizedURL Gets sanitized url
     *
     * @param  string $url
     * @return string
     */
    function getSanitizedURL($url){
        return utf8_encode($url);
        //return filter_var ($url, FILTER_SANITIZE_URL);
    }

        
    /**
     * getPageDepth Counts the depth of site from the site url provided by user
     *
     * @param  string $url
     * @return int
     */
    function getPageDepth($url){
        global $site_url;
        $str=parse_url($url, PHP_URL_HOST).parse_url($url, PHP_URL_PATH);
        $str2=parse_url($site_url, PHP_URL_HOST).parse_url($site_url, PHP_URL_PATH);
        return substr_count($str,"/")+1-substr_count($str2,"/");
    }
    
    /**
     * removeFowardslash Removes the ending forwardslash(/) in URL
     *
     * @param  string $url
     * @return string
     */
    function removeFowardslash($url){
        if(linkEndsWith($url, "/") ){/*remove the ending forwardslash(/)*/
            return substr($url, 0, -1);
        }
        return $url;
    }
    
    /**
     * linkStartsWith Deterines if link starts with particular string 
     *
     * @param  string $url
     * @param  string $str
     * @return bool
     */
    function linkStartsWith ($url, $str){ 
        $len = strlen($str); 
        return (substr($url, 0, $len) === $str); 
    } 
    
    /**
     * linkEndsWith Deterines if link ends with particular string 
     *
     * @param  string $url
     * @param  string $str
     * @return bool
     */
    function linkEndsWith($url, $str) { 
        $len = strlen($str); 
        if ($len == 0) { 
            return true; 
        } 
        return (substr($url, -$len) === $str); 
    } 
    
    /**
     * isParentBlocked returns true if the parent of the child is blocked
     *
     * @param  string $url
     * @return bool
     */
    function isParentBlocked($url){
        global $do_not_index_urls_arry;
        foreach ($do_not_index_urls_arry as $do_not_index_url) {
            if(linkStartsWith($url,$do_not_index_url)){
                return true;
            }
        }
        return false;

    }
?>