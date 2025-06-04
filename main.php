<?php
$articlesPerPage = 5;
$dirs = scandir('articles', SCANDIR_SORT_DESCENDING);
$ignored = array('.', '..');
$dirs = array_values(array_diff($dirs, $ignored));

$dirs = array_filter($dirs, function($item) {
    return !is_dir('articles/' . $item);
});
$dirs = array_values($dirs); // Reindex array

$totalArticles = count($dirs);
$totalPages = ceil($totalArticles / $articlesPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));
$start = ($page - 1) * $articlesPerPage;
$dirs = array_slice($dirs, $start, $articlesPerPage);

// ==== Browsing ====
function _browsing($page, $totalPages, $position){ // top or bottom
    if ($totalPages > 1) {
        echo tab(4) . '<div style="text-align: center; margin-' . $position . ': 20px;" class="abstract">' . "\n";

        $next = '<a href="?page=' . ($page + 1) . '" target="_top">' . NEXT . ' ►</a>';
        $prev = '<a href="?page=' . ($page - 1) . '" target="_top">◄ ' . PREV . '</a>';
        $pagination = "<font style=\"color:#2467ab\">[$page/$totalPages]</font>";

        if ($page > 1 && $page == $totalPages) {
            echo tab(5) . "$prev $pagination\n";
        } else if ($page == 1 && $page < $totalPages) {
            echo tab(5) . "$pagination $next\n";
        } else { // ($page > 1 && $page < $totalPages)
            echo tab(5) . $prev . '&nbsp;&nbsp;' . $pagination . '&nbsp;&nbsp;' . $next . "\n";
        }

        echo tab(4) . "</div>";
    }
}

_browsing($page, $totalPages, 'bottom');

echo tab(4) . '<div class="abstract">' . "\n";

foreach ($dirs as $key => $value) {
    $path = "articles/$value";
    $abstract = file_get_contents($path);

    // Extract metadata before removing the comment block
    preg_match('/<!--(.*?)-->/s', $abstract, $matches);
    $metadata = isset($matches[1]) ? trim($matches[1]) : '';

    // Remove the comment block
    $abstract = preg_replace_callback('/<!--(.*?)-->/s', function($matches) {
        // Checks if the comment contains "more" (ignores case and spaces)
        if (preg_match('/<!--\s*more\s*-->/is', $matches[0])) {
            return $matches[0]; // Do not remove the comment
        }
        return ''; // Remove comment
    }, $abstract);

    // Check if the file is Markdown by extension
    if (mb_strtolower(substr($value, -3)) == '.md') {
        $abstract = $Parsedown->text($abstract);
    }

    // Remove images, figure tags, and headers
    $abstract = preg_replace([
        '/<img src=\"[^"]*\".*\/>/',
        '/<fig(?:caption|ure)>.*<\/fig(?:caption|ure)>/',
        '/<h[1-6].*>.*<\/h[1-6]>/'
    ], '', $abstract);

    if (preg_match('/<!--\s*more\s*-->/', $abstract)) {
        // If <!-- more --> is found, truncate content up to that point, excluding the comment itself
        $abstract = preg_replace('/<!--\s*more\s*-->.*$/s', '', $abstract);
    } else {
        // If <!-- more --> is not found, limit the content to the first 9 lines
        $abstract = implode("\n", array_slice(explode("\n", $abstract), 0, 9));
    }
    
    // Process extracted metadata
    [$article, $author, $columns, $date, $email, $image] = _getParams($metadata, $path);

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
    
    echo $abstract . "\n";
    
    echo tab(5) . "<p>\n";
    echo tab(6) . '<a href="articles/' . $value . '" target="_top">' . "\n";
    echo tab(7) . '<img src="/img/readmore.webp" height="24" style="vertical-align:top;" />' . "\n";
    echo tab(6) . "</a>\n";
    echo tab(5) . "</p>\n";
    
    if ($dirs[$key] != end($dirs)) {
        echo "\n" . tab(5) . "<hr>\n\n";
    }
}

echo tab(4) . "</div>\n";

_browsing($page, $totalPages, 'top');

echo "\n";
echo tab(4) . '<div style="text-align: center; margin-top: 10px;" class="abstract">' . "\n";
echo tab(5) . '<a href="#top" target="_top"><span style="font-size: 40px;">🔝</span></a>' . "\n";
echo tab(4) . "</div>\n";
?>

