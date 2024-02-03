<?php
/* By default, the sort order is alphabetical and descending, so the
 * oldest article appears at the bottom of the main page. Sorting is
 * done using file names, not titles. If you want to sort by date, add
 * numbers to the beginning of the file names. Logically, the highest
 * number will be the most recently published file, and will always
 * appear at the top.
 *     1_manifest.md
 *     2_lorem_ipsum.html
 */
$dirs = scandir('articles', SCANDIR_SORT_DESCENDING);
$ignored = array('.', '..');
$dirs = array_diff( $dirs, $ignored );
$dirs = array_values( $dirs );

echo '<div class="abstract">';

foreach ( $dirs as $key => $value ) {
    // Open file as array
    $abstract = file("articles/$value");
    
    // Extract the first lines from each file.
    $abstract = implode(array_slice($abstract, 0, 14));
    
    // If Markdown, convert to HTML
    if ( mb_strtolower(substr($value, -2)) == 'md' ) {
        $abstract = $Parsedown->text($abstract);
    }
    
    // No images beyond featured ones, and no headings in the abstract.
    $patterns = array('/<img src=\"[^"]*\".*\/>/',
                      '/<fig[caption|ure]+>.*<\/fig[caption|ure]+>/',
                      '/<h[1-6].*>.*<\/h[1-6]>/');
    $abstract = preg_replace($patterns, '', $abstract);
    
    /**
    * Getting the parameters is only possible if the parameters section
    * is at the top of the file. So make sure you always position it at
    * the top.
    */    
    $parameters = _getParams($abstract, "articles/$value");
    $article = $parameters[0];
    $author  = $parameters[1];
    $columns = $parameters[2];
    $date    = $parameters[3];
    $email   = $parameters[4];
    $image   = $parameters[5];
    
    echo '<h1 style="margin-top:0; margin-bottom:0; text-align:left;">
         <a href="articles/'.$value.'" target="_top">'.$article.'</a></h1>';

    echo '<p style="margin-top:0; font-size:80%;">&#128100; '.$author.
         '&emsp;&#128197; '.$date.'</p>';

    if ( !empty($image) && mb_strtolower($image) != "none" ){
        echo '<a href="articles/'.$value.'" target="_top"><img src="/img/'.$image.'"
             width="340" height="170" style="float:right; margin-left:15px;
             margin-bottom:15px"></a>';
    }
    
    $readmore = '<a href="articles/'.$value.'" target="_top">
            <img src="/img/readmore.png" height="24" style="vertical-align:top;" />
            </a>';
    
    echo $abstract;
    
    echo $readmore;
    
    if ( $dirs[$key] != end($dirs) ) {
        echo '<hr>';
    }
}

echo '</div>';
?>
