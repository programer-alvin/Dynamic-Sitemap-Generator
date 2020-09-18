# Dynamic-Sitemap-Generator
This is a quick PHP code to dynamically generate a sitemap of a particular given URL provided by the user. The site map can be then submitted to site engines such as Google, Bing, and others.

**Version 1.0.0**
## Contributors
- [Alvin Muthui](www.alvinmuthui.ga "Alvin Muthui website")
## Features
- Generates a sitemap of a single URL provided by the user.
- Blocks multiple URLs provided by the user.
- Set the max execution time of the script.
- Ability to either display errors or suppress them.
- Set Multiple extensions to be crawled such as .HTML, .PHP, / and others.
- Set the desired output file name for the sitemap.
- Separated configuration file
## Files
### genConfig.php
This file contains configuration variables that determine how the URL is going to be crawled.
### dynamic-sitemap-generator.php
This file contains the execution main code. It should be called to generate a sitemap. You can access it using a browser, send get/post request to it, or any other means necessary.
### Link.php
Contains the class "Link” that holds link properties such as URL value, depth, and whether the URL is crawled or not.
### Links.php
Contains class “Links” that holds Link objects in an array. 
### xmlWriter.php
Contains the class "WriteFile” that will write the sitemap file from object Links.
## Usage
- Copy the four files (genConfig.php, dynamic-sitemap-generator.php, Link.php, Links.php, and xmlWriter.php) to the path you want to create a sitemap. The most preferred location is your root folder.
- Set up your configurations in genConfig.php file. 
- Finally, request dynamic-sitemap-generator.php. For example www.example.com/dynamic-sitemap-generator.php

## Caution
This is the first version of the code and one can experience issues with it so use carefully. Always check the generated sitemap file for any errors. Let me know any issue you experience so that I can make improvements to the later versions. Suggestions are also welcome. The best part is you can modify the code to fit your needs.
## More info
- For more info about the author visit www.alvinmuthui.ga.
- For more info about the sitemap protocol visit https://www.sitemaps.org/protocol.html.
