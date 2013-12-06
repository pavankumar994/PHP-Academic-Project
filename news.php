<?php
require_once 'LIB_project1.php';
require_once 'P2_Utils.class.php';

ini_set('display_errors', 1);

$filename = "news.txt";
$input = array_reverse(file($filename));
$value =" ";
$post_count = count($input);
$post_per_page = 4;
$permalink="";
$generate ="";
$dom = new DOMDocument();
//$dom->load("project2.rss");
//$item = $dom->getElementsByTagName('item');

/*foreach($item as $node)
{
  $permalink = $node->getElementsByTagName('guid')->item(0)->nodeValue;
 // $generate = P2_Utils::generatePermalink($permalink);
}
//echo "<p>from news.php" .$permalink."</p>";
*/
$no_of_pages = ceil($post_count/$post_per_page);
$page_no = 1;
if(isset($_GET['page']) && strlen($_GET['page']>0))
   {
    if($_GET['page']<= $no_of_pages)
    {
        $page_no = $_GET['page'];
    }
   }

$start =( $page_no - 1)* $post_per_page;
$end = min($post_count - 1, $start +$post_per_page);

for($index = $start; $index <= $end; $index++)
{
 
 list($subject, $date, $content)= explode("|", $input[$index]);
  $value .= "<h2 class='heading'>$subject</h2>";
  $value .="<span class='font-style'>$date</span>";
 // $value .="<span class='font-style'><a href=$generate>Permalink</a></span>";
  $value .="<p class='post'>$content</p>"; 
}

     $prev_link=" ";
     $next_link =" ";


if($page_no > 1)
{
    $prev_link = '<a class="page_numbering" href="news.php?page='.($page_no-1).'"> previous </a>';
}
if($page_no < $no_of_pages)
{
    $next_link = '<a class="page_numbering" href="news.php?page='.($page_no+1).'"> next </a>';
}
$navigator = "    Displaying Page from " . $page_no." to ". $no_of_pages;
    $string ='';
$string .= html_header($title = "NEWS", $styles = "css/index.css");
$string .= html_navigationBar();
$string .= "<article class='content'>";
$string .= "<section class ='newsEach'>";
$string .= $value;
$string .="</section>";
$string .= $prev_link."\t";
$string .= " ";
for($i= 1; $i<=$no_of_pages;$i++){
$string .='<a class="page_numbering" href="news.php?page='.$i.'">'. $i .'</a>';
}
$string .= $next_link;
$string .= $navigator;
$string .="</article>";
$string .= html_footer();

echo $string;
?>
