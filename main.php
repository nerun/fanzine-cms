<?php
$articlesPerPage = 5;
$dirs = scandir('articles', SCANDIR_SORT_DESCENDING);
$ignored = array('.', '..');
$dirs = array_values(array_diff($dirs, $ignored));

$totalArticles = count($dirs);
$totalPages = ceil($totalArticles / $articlesPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));
$start = ($page - 1) * $articlesPerPage;
$dirs = array_slice($dirs, $start, $articlesPerPage);

echo tab(4) . '<div class="abstract">' . "\n";

foreach ($dirs as $key => $value) {
    $abstract = file("articles/$value", FILE_SKIP_EMPTY_LINES);
    if (mb_strtolower(substr($value, -2)) == 'md') {
        foreach ($abstract as $k => &$v) {
            if ($k > 7) {
                $v = $Parsedown->text($v);
            }
        }
    }

    $patterns = array('/<img src=\"[^"]*\".*\/>/',
                      '/<fig[caption|ure]+>.*<\/fig[caption|ure]+>/',
                      '/<h[1-6].*>.*<\/h[1-6]>/');
    $abstract = preg_replace($patterns, '', $abstract);
    $abstract = implode(array_slice($abstract, 0, 14));

    $parameters = _getParams($abstract, "articles/$value");
    $article = $parameters[0];
    $author  = $parameters[1];
    $columns = $parameters[2];
    $date    = $parameters[3];
    $email   = $parameters[4];
    $image   = $parameters[5];

    $abstract = preg_replace('/<!--.*?-->/s', '', $abstract);

    echo tab(5) . '<h1 style="margin-top:0; margin-bottom:0; text-align:left;">' . "\n";
    echo tab(6) . '<a href="articles/' . $value . '" target="_top">' . $article . '</a>' . "\n";
    echo tab(5) . "</h1>\n";

    echo tab(5) . '<p style="margin-top:0; font-size:80%;">' . "\n";
    echo tab(6) . '&#128197; ' . $date . '&emsp;&#128100; ' . $author . "\n";
    echo tab(5) . "</p>\n";

    if (!empty($image) && mb_strtolower($image) != "none") {
        echo tab(5) . '<a href="/articles/' . $value . '" target="_top">' . "\n";
        echo tab(6) . '<img src="/img/' . $image .
            '" width="340" height="170" style="float:right; margin-left:15px; margin-bottom:15px"' .
            ' class="responsive-img">' . "\n";
        echo tab(5) . "</a>\n";
    }
    
    $abstract = preg_replace('/^/m', str_repeat("\t", 5), $abstract);
    $abstract = preg_replace('/^\s*[\r\n]+/m', '', $abstract);
    
    echo $abstract;
    
    echo tab(5) . '<a href="articles/' . $value . '" target="_top">' . "\n";
    echo tab(6) . '<img src="/img/readmore.webp" height="24" style="vertical-align:top;" />' . "\n";
    echo tab(5) . "</a>\n";
    
    if ($dirs[$key] != end($dirs)) {
        echo "\n" . tab(5) . "<hr>\n\n";
    }
}

echo tab(4) . "</div>\n";

// Browsing
echo tab(4) . '<div style="text-align: center; margin-top: 20px;" class="abstract">' . "\n";

if ($page > 1) {
    echo tab(5) . '<a href="?page=' . ($page - 1) . '" target="_top">⏪ Recent Articles</a> ' . "\n";
}

if ($page < $totalPages) {
    echo tab(5) . '<a href="?page=' . ($page + 1) . '" target="_top">Previous Articles ⏩</a>' . "\n";
}

echo tab(4) . "</div>";
?>

