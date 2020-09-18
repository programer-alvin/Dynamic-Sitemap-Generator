<?php
    class WriteFile{
        private $lastmod="";/*Time last modifield*/
        function writeContent($file_name,$site_url,$priority,$change_frequency, $links){
            $this->lastmod=date("c");/*Set the current date*/
            $res = fopen ($file_name, "w");/*Write open file in write mode*/
            if (!$res) {/*if no resouse then exit*/
                echo "Unable to create file $file_name!" . '<br>';
                return;
            }
            /*Write the file*/
            fwrite ($res, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
                         "<!-- Generated by PHP script done by Alvin Muthui -> www.alvinmuthui.ga -->\n" .
                         "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n" .
                         "  <url>\n" .
                         "    <loc>" . htmlentities ($site_url) ."</loc>\n" .
                         "    <lastmod>$this->lastmod</lastmod>\n".
                         "    <changefreq>$change_frequency</changefreq>\n" .
                         "    <priority>$priority</priority>\n" .
                         "  </url>\n");
        
            $this->writeOtherLinks($res,$priority,$change_frequency,$links);

            fwrite ($res, "</urlset>\n");
            fclose ($res);
            echo "File $file_name created successfully". '<br>';
        }
        function writeOtherLinks($res,$priority,$change_frequency,$links){
            array_shift($links);/*shift to remove the first url because already it is writen*/
            foreach ($links as $link) {
                //$verified_link->getURL()
                $priority = number_format(round($priority /$link->getDepth()+ 0.5, 3 ), 1 );/*Determine priority of page using depth*/
                fwrite ($res, "  <url>\n" .
                                "    <loc>" . htmlentities ($link->getURL()) ."</loc>\n" .
                                "    <lastmod>$this->lastmod</lastmod>\n".
                                "    <changefreq>$change_frequency</changefreq>\n" .
                                "    <priority>$priority</priority>\n" .
                                "  </url>\n");
            }
                    
              
        }

    }
?>