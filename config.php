<?php
// Leave blank if your site is in the root of your server (public_html). Change
// it if it is in a folder, like a subsite: '/fanzine-cms'.
define('BASE_PATH', '');


/*
 * HTML AND HEAD SETTINGS
 ******************************************************************************/
// HTML Language: pt-br, es, de-DE etc.
define('LANG', 'en');

// Website title
define('TITLE', 'A Familiar Magazine');

// Name of the person who wrote the page code.
define('AUTHOR', 'Daniel Dias Rodrigues');

// Name of the person who holds the copyright to the page, i.e. the legal owner
// of the content.
define('COPYRIGHT_HOLDER', 'Daniel Dias Rodrigues');

// Description
define('DESCRIPTION', 'Basic blog frame created with PHP and HTML5.');

// Keywords
define('KEYWORDS', 'PHP, HTML5, Blog, Theme, Site');

// Browser control flag. When false, disables browser-side caching by sending
// HTTP headers like Cache-Control, Pragma, and Expires. Useful for testing
// before the site goes live, forcing reload and preventing cached content.
// Browser cache enabled = true
// Browser cache disabled = false
define('BROWSER_CACHE', false);


/*
 * ARTICLES SETTINGS
 ******************************************************************************/

// Better not to change it, it's a warning in case the author forgets to define
// a title for the article.
define('ARTICLE_TITLE', 'article title missing');

// Same remarks as for the title. Unless there is a single author on the blog
// (a personal blog), in which case it is useful to define his/her name here.
define('ARTICLE_AUTHOR', 'author name missing');

// The default column count is 2
define('ARTICLE_COLUMNS', '2');

// The same observations made to the author.
define('ARTICLE_EMAIL', 'missing e-mail');

// Default featured image if one is missing; 'none' means that tags and code
// that insert images will not be rendered if no featured image is provided.
define('ARTICLE_FEATURED_IMAGE', 'none');

// Number of articles displayed per page
define('ARTICLES_PER_PAGE', 5);


/*
 * TRANSLATION
 ******************************************************************************/
define('PREV', 'prev');
define('NEXT', 'next');
define('NOTE', 'Note');
define('TIP', 'Tip');
define('WARNING', 'Warning');

?>
