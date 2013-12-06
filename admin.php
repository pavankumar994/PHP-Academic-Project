<?php
require_once 'LIB_project1.php';


    function __autoload($className)
        {
            require_once $className . '.class.php';
    	}
 $p2 = P2_Utils::getInstance();               
$utils = P2_Utils::checkNewsFormSubmit();
$checkBoxList = $p2->getStudentsList();

$mainContent =<<<MAIN
    <article class='content'>
        <section class ='newsEach'>
                    <p>
                    <span class='title'>Edit news posting here: </span>
                    </p>
                    <br/>
                    

MAIN;

$string ='';
$string .= html_header($title = "Admin", $styles="css/index.css");
$string .= html_navigationBar();
$string .=$mainContent;
$string .= newsForm();
$string .="<hr/>";
$string .="<br/>";
$string .="<p>";
$string .="<span class='title'>Edit Letter from Editor: </span>";
$string .="</p>";
$string .="<br/>";
$string .=editorialForm();
$string .="<br/>";
$string .="<br/>";
$string .="<p>";
$string .= "<span class='title'>RSS FEEDS OF 539 & 739 students</span> ";
$string .="</p>";
$string .="<br/>";
$string .= $checkBoxList;
$string .="<br/>";
$string .="<p>";
$string .= "<span class=\"title\">Select the Web Services</span>";
$string .="</p>";
$string .="<br/>";
$string .= $p2->getWebServices();
$string .="</section>";
$string .="</article>";
$string .= $utils;
$string .= checkEditorialFormSubmit();
$string .= $p2->feedServices();
$string .= $p2->checkWebServicesSubmitButton();
$string .= html_footer();

echo $string;



?>
