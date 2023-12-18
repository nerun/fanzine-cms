<?php
include('extensions/parsedown/Parsedown.php');
include('extensions/parsedown-extra/ParsedownExtra.php');
$Parsedown = new ParsedownExtra();

echo file_get_contents("header.html");
echo file_get_contents("sidebar.html");

$main = 'main.php';

if ($_GET) {
    $page_file = $_GET['id'];
} else {
    $page_file = $main;
}

if ( $page_file != $main ) {
    $body = file_get_contents($page_file);
    
    if ( !empty($body) ) {
        $parameters = _getParams($body, $page_file);
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
            echo '<img src="/img/'.$image.'" width="640" height="360"
                 style="margin: 1px auto 1px; display: block;">';
            echo '<hr width="75%">';
        }

        // Insert title, author and publication date in the page, using Unicode characters as icons.
        echo '<h1 style="margin-bottom:0; text-align:center;">'.$article.'</h1>';
        echo '<p style="margin-top:0; font-size:75%; text-align:center;">&#128100; '
             .$author.'&emsp;&#128197; '.$date.'</p>';
        echo '<br />';
        echo '<div id="columns" class="columns" style="column-count:'.$columns.';">';
        
        if ( mb_strtolower(substr($page_file, -2)) == 'md' ) {
            echo $Parsedown->text($body);
        } else {
            echo $body;
        }
    } else {
        include('404.php');
    }
} else {
    include($main);
}

$footer = file_get_contents("footer.html");
echo preg_replace('/YEAR/s', date("Y"), $footer);

/**
 * Returns all parameters extracted from a html page.
 */
function _getParams($page, $page_name) {
    // pattern, page file content, alternative if missing
    // Alternatively, you can change the default missing string to set a
    // default author, email etc.
    $art  = _getVar('arti(?:cle|go)', $page, 'article title missing');
    $aut  = _getVar('auth?or', $page, 'author name missing');
    $col  = _getVar('colu(?:mn|na)s?', $page, 'auto');
    // for date(), refer to https://www.php.net/manual/en/function.date.php
    $dat  = _getVar('dat[ae]', $page, date(DATE_RFC2822, filemtime($page_name)));
    $mail = _getVar('e?mail', $page, null);
    $img  = _getVar('imagem?', $page, 'none');
    
    return array( $art, $aut, $col, $dat, $mail, $img );
}

/**
 * Returns a variable extracted from a page (.html or any other
 * extension). One variable per line.
 * Variables format:
 *    <:variable_name:> + <variable value> + <line break>
 */
function _getVar($var, $page, $missing) {
    $top_content = substr($page, 0, 250);
    
    $result = preg_replace("/[.\S\s]*:$var:(.*)[\r\n][.\S\s]*/", '\1', $top_content);
    
    if ( $result == $top_content || trim($result) == null ) {
        $result = $missing;
    } else {
        $result = trim($result);
    }
    
    return $result;
}
?>
