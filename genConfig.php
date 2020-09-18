<?php
    $site_url="http://www.example.com";/*site url to be crawled*/

    $do_not_index_urls_arry= array (/**url to be not idexed */
        "http://www.example.com/senstive"
    );

    $change_frequency="always";/*The frequency of changes made to the website. It can be 
    always
    hourly
    daily
    weekly
    monthly
    yearly
    never
    For more info https://www.sitemaps.org/protocol.html#changefreqdefs*/

    $code_execution_timeout=420;/*Max time in seconds your code should take while execuring*/

    $hide_errors=true;/**Variable for hiding/showing all errors*/

    $block_urls_with_its_children=true;/*configuration to block url with its children from indexing*/

    $eliminate_nav_links =true; /*remove navigation links*/

    

    $priority=1; /*Priority of the page in the sitemap. More info https://www.sitemaps.org/protocol.html#prioritydef */

    $extensions_arry= array (/*Extensions to be crawled*/
        ".html", 
        ".php",
        "/"
    );

    $file_name="sitemap.xml";/*the file to be generated*/

    



    

?>