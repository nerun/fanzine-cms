<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>A Familiar Magazine</title>
        <meta name="author" content="Daniel Dias Rodrigues">
        <meta name="copyright" content="© <?php echo date('Y');?> Daniel Dias Rodrigues" />
        <meta name="description" content="Basic blog frame created with PHP and HTML5." />
        <meta name="keywords" content="PHP, HTML5, Blog, Theme, Site" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
        <meta name="robots" content="index,follow">
        <meta name="rating" content="general" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/style.css">
        <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>
        <base target="_blank" rel="noreferrer noopener nofollow">
    </head>
    <body class="index">
        <header>
            <a href="/index.php" target="_top"><img src="/img/banner.webp" width="100%"></a>
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
            include('extensions/parsedown/Parsedown.php');
            include('extensions/parsedown-extra/ParsedownExtra.php');
            $Parsedown = new ParsedownExtra();

            // Extracts all parameters from a page
            function _getParams($page, $page_name) {
                $getVar = function($var, $page, $missing) {
                    return preg_match("/:$var:(.*)/", substr($page, 0, 250), $matches) ? trim($matches[1]) : $missing;
                };

                return [
                    $getVar('arti(?:cle|go)', $page, 'article title missing'),
                    $getVar('auth?or', $page, 'Nerun'),
                    $getVar('colu(?:mn|na)s?', $page, '2'),
                    $getVar('dat[ae]', $page, date(DATE_RFC2822, filemtime($page_name))),
                    $getVar('e?mail', $page, 'gurpzine@gurpzine.com.br'),
                    $getVar('imagem?', $page, 'none')
                ];
            }

            function tab($times){
                return str_repeat("\t",$times);
            }

            if ($_GET['id']) {
                $page_file = $_GET['id'];
                echo tab(2) . '<div id="content" class="content">' . "\n";
                include('article.php');
                echo tab(2) . "</div>\n";
            } else {
                $page_file = 'main.php';
                echo tab(2) . '<div class="main-container">' . "\n";
                echo tab(3) . '<div id="navcolumn" class="navcolumn">' . "\n";
                echo tab(4) . '<h3 style="margin-top:0; margin-bottom:0;">Tags</h3>' . "\n";
                echo tab(4) . '<p><a href="/articles/none.html" target="_top">\'Page not found\' sample</a></p>' . "\n";
                echo tab(3) . "</div>\n";
                echo tab(3) . '<div id="content" class="content">' . "\n";
                include($page_file);
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
        <script>
            document.getElementById('dropdown-menu').addEventListener('click', function() {
                this.classList.toggle('active');  // Toggles the 'active' class on the menu icon
                const menuContent = document.getElementById('dropdown-menu-content');
                menuContent.classList.toggle('active');  // Toggles the 'active' class on menu content
            });
        </script>
    </body>
</html>
