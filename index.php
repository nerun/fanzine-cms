<?php
// === Load settings ===
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    define('LANG', 'en');
    define('TITLE', 'A Familiar Magazine');
    define('AUTHOR', 'Daniel Dias Rodrigues');
    define('COPYRIGHT_HOLDER', 'Daniel Dias Rodrigues');
    define('DESCRIPTION', 'Basic blog frame created with PHP and HTML5.');
    define('KEYWORDS', 'PHP, HTML5, Blog, Theme, Site');
    define('BROWSER_CACHE', false);
    define('ARTICLE_TITLE', 'article title missing');
    define('ARTICLE_AUTHOR', 'author name missing');
    define('ARTICLE_COLUMNS', '2');
    define('ARTICLE_EMAIL', 'missing e-mail');
    define('ARTICLE_FEATURED_IMAGE', 'none');
    define('ARTICLES_PER_PAGE', 5);
    define('PREV', 'prev');
    define('NEXT', 'next');
}

// === Security headers ===
header("Content-Security-Policy: default-src 'self'; img-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: accelerometer=(), camera=(), geolocation=(), microphone=()");
header("Strict-Transport-Security: max-age=63072000; includeSubDomains; preload");
header("X-Permitted-Cross-Domain-Policies: none");
header("Cross-Origin-Opener-Policy: same-origin");
header("Cross-Origin-Embedder-Policy: require-corp");
header("Cross-Origin-Resource-Policy: same-origin");

// === Cache-Control headers ===
if (!BROWSER_CACHE) {
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
}

// === Includes Parsedown with SafeMode ===
require_once('extensions/parsedown/Parsedown.php');
require_once('extensions/parsedown-extra/ParsedownExtra.php');

$Parsedown = new ParsedownExtra();
//$Parsedown->setSafeMode(true); // Protects against embedded XSS in Markdown

// === Auxiliary functions ===

// Extracts metadata from the article
function _getParams($page, $page_name) {
    $getVar = function($var, $page, $missing) {
        return preg_match("/:$var:(.*)/", substr($page, 0, 250), $matches) ? trim($matches[1]) : $missing;
    };

    return [
        $getVar('arti(?:cle|go)', $page, ARTICLE_TITLE),
        $getVar('auth?or', $page, ARTICLE_AUTHOR),
        $getVar('colu(?:mn|na)s?', $page, ARTICLE_COLUMNS),
        $getVar('dat[ae]', $page, date(DATE_RFC2822, filemtime($page_name))),
        $getVar('e?mail', $page, ARTICLE_EMAIL),
        $getVar('imagem?', $page, ARTICLE_FEATURED_IMAGE)
    ];
}

// Generates tabulation
function tab($times){
    return str_repeat("\t", $times);
}

// Sanitizes the 'id' parameter
function sanitizePageFile($input) {
    $basename = basename($input); // Protects against path traversal

    if (preg_match('/^[a-zA-Z0-9_\-]+\.(php|md|htm|html)$/', $basename)) {
        // Check if it is in /articles/
        $pathInArticles = "articles/" . $basename;
        if (file_exists($pathInArticles)) {
            return $pathInArticles;
        }

        // Check if is in root
        if (file_exists($basename)) {
            return $basename;
        }
    }

    return false;
}

?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
    <head>
        <title><?php echo TITLE;?></title>
        <meta name="author" content="© <?php echo date('Y'); echo ' '.AUTHOR;?>">
        <meta name="copyright" content="© <?php echo date('Y'); echo ' '.COPYRIGHT_HOLDER;?>" />
        <meta name="description" content="<?php echo DESCRIPTION;?>" />
        <meta name="keywords" content="<?php echo KEYWORDS;?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php
if (!BROWSER_CACHE) {
    echo "\t\t" . '<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">' . "\n";
}
?>
        <meta name="robots" content="index,follow">
        <meta name="rating" content="general" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/style.css">
        <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>
        <base target="_blank" rel="noreferrer noopener nofollow">
    </head>
    <body class="index">
        <header id="top">
            <a href="/index.php" target="_top"><img src="/img/banner.webp" width="100%" alt="Banner"></a>
            <nav id="header">
                <div class="navbar-header">
                    <a href="/index.php" target="_top">HOME</a>&emsp;
                    <a href="/legal.html" target="_top">LICENSE</a>&emsp;
                    <a href="/README.md" target="_top">README</a>&emsp;
                    <a href="https://github.com/nerun/fanzine-cms" target="_blank">SOURCE</a>&emsp;
                    <!-- Dropdown for smaller screens -->
                    <div id="dropdown-menu">&#9776;</div>
                    <div id="dropdown-menu-content">
                        <a href="/articles/none.html" target="_top">'Page not found' sample</a>
                        <!-- Add other menu items as needed -->
                    </div>
                </div>
            </nav>
        </header>

<?php
// === Page body ===

$page_file = null;

if (isset($_GET['id'])) {
    $page_file = sanitizePageFile($_GET['id']);
    echo tab(2) . '<div id="content" class="content">' . "\n";
    if ($page_file && file_exists($page_file)) {
        include('article.php');
    } else {
        include('404.php');
    }
    echo tab(2) . "</div>\n";
} else {
    $page_file = 'main.php';

    echo tab(2) . '<div class="main-container">' . "\n";
    echo tab(3) . '<div id="navcolumn" class="navcolumn">' . "\n";
    echo tab(4) . '<h3 style="margin-top:0; margin-bottom:0;">Tags</h3>' . "\n";
    echo tab(4) . '<p><a href="/articles/none.html" target="_top">\'Page not found\' sample</a></p>' . "\n";
    echo tab(3) . "</div>\n";
    echo tab(3) . '<div id="content" class="content">' . "\n";

    if (file_exists($page_file)) {
        include($page_file);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo tab(4) . '<div class="error-message">' . "\n";
        echo tab(5) . '<h1>HTTP 500 - Internal Server Error</h1>' . "\n";
        echo tab(5) . '<p><strong>Critical error: missing system file main.php</strong></p>' . "\n";
        echo tab(5) . '<p>Please check server integrity.</p>' . "\n";
        echo tab(4) . '</div>' . "\n";
    }

    echo tab(3) . "</div>\n";
    echo tab(2) . "</div>\n";
}
?>
        <footer>
            <div class="navbar-footer">
                Fanzine CMS © 2023-<?php echo date('Y');?> <a href="mailto:gurpzine@gurpzine.com.br">Daniel "Nerun" Rodrigues</a>.
                Some rights reserved.<br />
                <a href="https://github.com/nerun/fanzine-cms">Fanzine CMS</a> powered by <a href="https://www.php.net">PHP</a>
                and <a href="https://html.spec.whatwg.org/multipage">HTML5</a>.
            </div>
        </footer>
        <script src="/js/menu.js"></script>
    </body>
</html>

