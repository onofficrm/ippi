= Amalie =

* by Anariel Design, http://www.anarieldesign.com

- this theme is based on Twenty Fifteen: https://wordpress.org/themes/twentyfifteen
License: Distributed under the terms of the GNU GPL
Copyright: Automattic, automattic.com

Amalie is distributed under the terms of the GNU GPL

1.2.2 - May 11, 2020 

- improved styles for the new editor

1.2.1 - November 4, 2019

- prevented page scroll when clicking on the "more" link - blog page

1.2.0 - October 22, 2019

- support for the new WooCommerce gallery

1.1.9 - November 19, 2018

- fix in the functions.php file for the WooCommerce create_function that is deprecated from PHP 7.2 

1.1.8 - November 14, 2018

- improved support for the new WordPress editor

1.1.7 - July 26, 2018

- added basic support for the new WordPress editor

1.1.6 May 23, 2018

- support for the new 4.9.6 WordPress changes regarding GDPR

1.1.5 - January 26, 2018

- one-click demo files added to the theme

1.1.4 - January 17, 2018

- accessibility improvements - link hover improved 

1.1.3 - January 9, 2018

- added basic Gutenberg support

1.1.2 - November 29, 2017

- added one-click demo import

1.1.1 - July 27, 2017
- custom Logo option deprecated and added to core Site Identity section inside the Customizer

1.1 - April 17, 2017
- added new blank-page.php template - support for the Beaver Builder and Elementor

Version 1.0.4 - June 15 2016.
- new tags inside the style.css file 

Version 1.0.3 - December 7 2015.
- new soliloquy slider version, few code clearings

Version 1.0.2 - July 19 2015.
1. <?php $image_url = wp_get_attachment_image_src($image_id,’small);?> changed with <?php $image_url = wp_get_attachment_image_src($image_id,’full’);   ?> inside content-quote.php and content-front-page.php files

May 7, 2015
- removed example.html file from “genericons” folder because of (XSS) vulnerability caused by Genericons example.html