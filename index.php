<?php
require_once 'LIB_project1.php';
function __autoload($className)
        {
            require_once $className . '.class.php';
    	}
 $p2 = P2_Utils::getInstance();
$string ='';
$string .= html_header($title = "Index", $styles = "css/index.css");
$string .= html_navigationBar();
$string .=  "<article class='content'>";
$string .= "<aside>";
$string .= "<img src='media/me.jpg' alt='my profile pic' width='175' height='207'/>";
$string .= displayEditorial();
$string .= "</aside>";
$string .= "<section class = 'newsEach'>";
$string .= displayNews();
//$string .=$p2->comic();
//$string .=$p2->geek();
$string .= "<h2 style='font-size:25pt; padding:0.5em; color: #FE2E2E; border: 1px solid #D9E3E2; border-radius: 4px;'>Web Services<h2>";
//$string .= $p2->displayFeeds();
//$string .= "<h2class='heading'>Web SerVices<h2>";
$string .=$p2->displayWebServices();
$string .= "</section>";
$string .= "</article>";
$string .= html_footer();
echo $string;

?>
