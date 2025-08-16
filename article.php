<?php
function addTabsOutsidePre($body, $tabs) {
    $preBlocks = [];
    
    // Temporarily remove content inside <pre> tags by replacing it with a placeholder
    $body = preg_replace_callback('/<pre\b([^>]*)>(.*?)<\/pre>/is', function ($matches) use (&$preBlocks) {
        $placeholder = "__PRE_BLOCK_" . count($preBlocks) . "__";
        // Saves the entire tag to restore later
        $preBlocks[$placeholder] = "<pre" . $matches[1] . ">" . $matches[2] . "</pre>";
        return $placeholder;
    }, $body);

    // Add tabs to the content outside <pre> tags
    $body = preg_replace('/^/m', str_repeat("\t", $tabs), $body);

    // Restores <pre> blocks
    foreach ($preBlocks as $placeholder => $original) {
        $body = str_replace($placeholder, $original, $body);
    }

    return $body;
}

$body = file_get_contents($page_file);

// Extract metadata from yaml
$yaml = preg_replace('/\.[^.]+$/', '', $page_file) . '.yaml';
$metadata = file_get_contents($yaml);

if ( !empty($body) ) {
    $parameters = _getParams($metadata, $yaml);
    $article = $parameters[0];
    $author  = $parameters[1];
    $columns = $parameters[2];
    $date    = $parameters[3];
    $email   = $parameters[4];
    $image   = $parameters[5];

    // If email is not missing, link it to the author
    if ( !empty($email) ){
        $author = '<a href="mailto:'.$email.'">'.$author.'</a>';
    }

    // If featured image is not missing and it is not set to 'none', insert it
    if ( !empty($image) && mb_strtolower($image) != "none" ){
        $parts = explode('_', $page_file);
        if (ctype_digit(substr($parts[0], -1))) {
            $postFolder = '/' . $parts[0] . '/';
        }
        else {
            $postFolder = '/';
        }
        echo tab(3) . '<img src="' . BASE_PATH . $postFolder . $image . '" alt="Article Thumbnail"' .
            ' width="640" height="360" style="margin: 1px auto 1px; display: block;"' .
            ' class="responsive-img">' . "\n";
        echo tab(3) . '<hr width="75%">' . "\n";
    }

    // Insert title, author and publication date in the page, using Unicode characters as icons.
    echo tab(3) . '<h1 style="margin-bottom:0; text-align:center;">' . $article . "</h1>\n";
    echo tab(3) . '<p style="margin-top:0; font-size:80%; text-align:center;">' . '&#128197; ' .
        $date . '&emsp;&#128100; ' . $author . "</p>\n";
    echo tab(3) . "<br>\n";
    echo tab(3) . '<div id="columns" class="columns" style="column-count:' . $columns . ';">' . "\n";
    
    if ( mb_strtolower(substr($page_file, -2)) == 'md' ) {
        $body = $Parsedown->text($body);
        // Add class="responsive-img" to <img> tags
        $body = preg_replace_callback(
            '/<img\s+([^>]*?)\/?>/i',
            function ($matches) {
                $attrs = $matches[1];

                if (preg_match('/class=["\'].*\bresponsive-img\b.*["\']/', $attrs)) {
                    return "<img $attrs>";
                }

                if (preg_match('/class=(["\'])(.*?)\1/', $attrs, $classMatch)) {
                    $quote = $classMatch[1];
                    $classes = $classMatch[2];
                    $newClass = 'class=' . $quote . 'responsive-img ' . $classes . $quote;
                    $attrs = str_replace($classMatch[0], $newClass, $attrs);
                } else {
                    $attrs .= ' class="responsive-img"';
                }

                return "<img $attrs>";
            },
            $body
        );
        $body .= "\n";
    }
    
    $body = addTabsOutsidePre($body, 4);
    
    echo $body;
    echo tab(3) . "</div>\n";

    backButton(3,4);
} else {
    include('404.php');
}
?>
