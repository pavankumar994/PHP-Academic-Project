<?php
require_once 'LIB_project1.php';
$mainContent =<<<MAIN
    <article class='content'>
        <aside>
            Shrutika Thakur,<br/>
            63, West Squire Drive,<br/>
            Apt #1,<br/>
            Rochester, NY-14623.
            (585)-766-0398.
            smt9471@rit.edu
            shruts2907@gmail.com
        </aside>
        <section class ='newsEach'>

MAIN;

$string ='';
$string .= html_header($title = "Contact", $styles="css/index.css");
$string .= html_navigationBar();
$string .=$mainContent;
$string .= contactForm();
$string .="</section>";
$string .="</article>";
$string .=checkContactFormSubmit();
$string .= html_footer();

echo $string;



?>
