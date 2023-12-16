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

foreach ( $dirs as $key => $value ) {
    // Extract the first 600 characters from each file.
    $briefing = file_get_contents("articles/$value", false, null, 0, 600);

     /**
     * Getting the parameters is only possible if the parameters section
     * is at the top of the file. So make sure you always position it at
     * the top.
     */    
    $parameters = _getParams($briefing, "articles/$value");
    $article = $parameters[0];
    $author  = $parameters[1];
    $columns = $parameters[2];
    $date    = $parameters[3];
    $email   = $parameters[4];
    $image   = $parameters[5];
    
    if ( !empty($image) && mb_strtolower($image) != "none" ){
        echo '<img src="/img/'.$image.'" width="432" height="216" style="float: right; padding-left: 15px">';
    }
    
    echo '<h1 style="line-height:5px; text-align:left;">'.$article.'</h1>';
    echo '<p style="font-size:75%; text-align:left;">&#128100; '.$author.'&emsp;&#128197; '.$date.'</p>';
    
    if ( mb_strtolower(substr($value, -2)) == 'md' ) {
        echo $Parsedown->text($briefing . '... <a href="articles/' . $value . '">[read more]</a>');
    } else {
        echo $briefing . '... <a href="articles/' . $value . '">[read more]</a>';
    }
    
    if ( $dirs[$key] != end($dirs) ) {
        echo '<hr>';
    }
}
?>
