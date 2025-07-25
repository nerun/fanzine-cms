<?php
$files = scandir('content', SCANDIR_SORT_DESCENDING);
$ignored = array('.', '..');
$files = array_values(array_diff($files, $ignored));

$files = array_filter($files, function($item) {
    $fullpath = 'content/' . $item;
    return is_file($fullpath) && preg_match('/\.(md|html?|php)$/i', $item);
});

$files = array_values($files); // Reindex array

$totalArticles = count($files);
$totalPages = ceil($totalArticles / ARTICLES_PER_PAGE);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages));
$start = ($page - 1) * ARTICLES_PER_PAGE;
$files = array_slice($files, $start, ARTICLES_PER_PAGE);

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

foreach ($files as $key => $value) {
    $path = "content/$value";
    $abstract = file_get_contents($path);

    // Extract metadata from yaml
    $yaml = preg_replace('/\.[^.]+$/', '', $path) . '.yaml';
    $metadata = file_get_contents($yaml);

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
    echo tab(6) . '<a href="' . BASE_PATH . '/content/' . $value . '" target="_top">' . $article . '</a>' . "\n";
    echo tab(5) . "</h1>\n";

    echo tab(5) . '<p style="margin-top:0; font-size:80%;">' . "\n";
    echo tab(6) . '&#128197; ' . $date . '&emsp;&#128100; ' . $author . "\n";
    echo tab(5) . "</p>\n";

    if (!empty($image) && mb_strtolower($image) != "none") {
        echo tab(5) . '<a href="' . BASE_PATH . '/content/' . $value . '" target="_top">' . "\n";
        $parts = explode('_', $value);
        echo tab(6) . '<img src="' . BASE_PATH . '/content/' . $parts[0] . '/' . $image .
            '" width="340" height="170" style="float:right; margin-left:15px; margin-bottom:15px"' .
            ' class="responsive-img">' . "\n";
        echo tab(5) . "</a>\n";
    }
    
    $abstract = preg_replace('/^/m', str_repeat("\t", 5), $abstract);
    $abstract = preg_replace('/^\s*[\r\n]+/m', '', $abstract);
    
    echo $abstract . "\n";
    
    echo tab(5) . "<p>\n";
    echo tab(6) . '<a href="' . BASE_PATH . '/content/' . $value . '" target="_top">' . "\n";
    echo tab(7) . '<img src="' . BASE_PATH . '/assets/img/readmore.webp" height="24" style="vertical-align:top;" />' . "\n";
    echo tab(6) . "</a>\n";
    echo tab(5) . "</p>\n";
    
    if ($files[$key] != end($files)) {
        echo "\n" . tab(5) . "<hr>\n\n";
    }
}

echo tab(4) . "</div>\n";

_browsing($page, $totalPages, 'top');

echo "\n";
echo tab(4) . '<div style="text-align: center; margin-top: 10px;">' . "\n";
echo tab(5) . '<a href="#top" target="_top" style="color:none; text-decoration:none"><span style="font-size: 40px;">🔝</span></a>' . "\n";
echo tab(4) . "</div>\n";
?>
