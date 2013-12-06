<?php
require_once 'LIB_project1.php';
function __autoload($className)
    {
    	require_once $className . '.class.php';
    }
     $p2 = P2_Utils::getInstance();
     
$string ="";
$string .= html_header($title = "SERVICES", $styles = "css/index.css");
$string .= html_navigationBar();
$string .= "<article class='content'>";
$string .="<a href='project2.rss'>Project2Rss</a>";
$string .= "<section class ='newsEach'>";
$string .= $p2->displayFeeds();
$string .="</section>";
$string .="</article>";
$string .= html_footer();

echo $string;
?>
