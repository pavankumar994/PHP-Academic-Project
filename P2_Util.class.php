<?php

require_once('LIB_project1.php');
date_default_timezone_set('America/New_York');

class P2_Utils
{
    static $m_pInstance;

/*****************************************************************************
DESCRIPTION: method to fill the content of news in news.txt after submit is
            pressed in admin.php news posting form and generate the project2.rss
            file through RSSFeed.class.php.
INPUT: 
*****************************************************************************/    
    public static function checkNewsFormSubmit()
    {
        if(isset($_POST['submit']))
        {
            if(isset($_POST['subject']) && isset($_POST['newsContent']) && isset($_POST['Password']))
            {
                $subject = sanitizeString($_POST['subject']);
                $content = sanitizeString($_POST['newsContent']);
                $password = sanitizeString($_POST['Password']);
                
                if($password == MY_PASSWORD && strlen($subject)>0 && strlen($content)>0)
                {
                    $date = date('r');
                    $line = implode("|", array($subject,$date,$content));
                    $lineF = $line."\n";
                    file_put_contents("news.txt",$lineF,FILE_APPEND);
                    
                    $feed = new RSSFeed('project2.rss');
                    $load = array_reverse(file('news.txt'));
                    
                    //$count = count($load);
                    for($i=0; $i<10; $i++)
                    //foreach($load as $line)
                    {
                        list($subjects, $dates, $contents)= explode("|",$load[$i]);
                        $article[$dates] = array('subject'=>$subjects,'content'=>$contents);
                    }                    
                    
                    $feed->items = $article;
                    
                    
                    //calls toXML function to create project2.rss
                    $dom = $feed->toXML();
                    $dom->save('project2.rss');//saving project2.rss to disk
                }else
                {
                    
                    echo "<strong>Bad Password or you left something out!</strong>";
                }
            }
            else
            {
                echo "<strong>you left something out!</strong>";
            }
        }
        
    }
    /***************end of checksubmit function*************/
    
/*******************************************************************************
 DESCRIPTION: CREATES THE INSTANCE OF THE CLASS
 
*******************************************************************************/
    
    
    public static function getInstance()
    {
        if (!self::$m_pInstance)
        {
            self::$m_pInstance = new P2_Utils();
        }
    
        return self::$m_pInstance;
    }
    /*************END OF GETINSTANCE FUNCTION****************************/
    
/******************************************************************************
 DESCRIPTION:
 *******************************************************************************/
    public static function getStudentsList()
    {
       $dom = new DOMDocument();
       $dom->load('rss_class.xml');
       $studentsList = $dom->getElementsByTagName('student');
       
       $string = "";
       $string .="<div class=\"formCss\">";
       $string .="<form action=\"admin.php\" method=\"POST\">";
       $selected = "";
       $string .= "<div id='colCount'>";
       $count = 0;
       foreach($studentsList as $list)
       {
            $firstName = $list->getElementsByTagName('first')->item(0)->nodeValue;
            $lastName = $list->getElementsByTagName('last')->item(0)->nodeValue;
            $selected = $list->getAttribute('selected');
            
            if($selected == 'yes')
            {
            $string .="<input type=\"checkbox\" name = 'box[]' value= \"$count\" checked/>".$firstName." ".$lastName."<br/>";
            }
            else
            {
               $string .="<input type=\"checkbox\" name = 'box[]' value= \"$count\" />".$firstName." ".$lastName."<br/>"; 
            }
            $count++;
            
          
       }
       
       $string .="</div>";
       $string .="<p>";
       $string .="Password: "."<input type='password' name ='password'/>";
       $string .="</p>";
       $string .="<p>";
       //$string .= "<input type='reset' name ='reset' value='RESET'/>";
       $string .= "<input type='submit' value='SUBMIT' name ='submitFeeds'/>";
       $string .="</p>";
       
       $string .="</form>";
       $string .="</div>";
       
       
       return $string;
       
    }
    
    
    public static function getWebServices()
    {
        $string ="";
        $dom = new DOMDocument();
        $dom->load('rss_class.xml');
        $web = $dom->getElementsByTagName('choice');
        $string .="<div class=\"formCss\">";
        $string .="<form action=\"admin.php\" method=\"POST\">";
        $count1 = 0;
        foreach($web as $list)
        {
            $name = $list->getElementsByTagName('name')->item(0)->nodeValue;
            $link = $list->getElementsByTagName('url')->item(0)->nodeValue;
            $selected = $list->getAttribute('selected');
            if($selected == 'yes')
            {
                $string .="<input type=\"checkbox\" name = 'box[]' value= \"$count1\" checked/>".$name."<br/>";
            }
            else
            {
                $string .="<input type=\"checkbox\" name = 'box[]' value= \"$count1\" />".$name."<br/>";
              
            }
            $count1++;
            
          
        }
		$string .="Password: "."<input type='password' name ='password'/>";
		$string .="<p>";
		//$string .= "<input type='reset' name ='reset' value='RESET'/>";
		$string .= "<input type='submit' value='SUBMIT' name ='submitFeeds'/>";
		$string .="</p>";

		$string .="</form>";
		$string .="</div>";

		return $string;

    }
    
/********************************************************************************
 DESCRIPTION: checks for studenst whose feeds is to be displayed
 
****************************************************************************/
    public static function feedServices()
    {
        $feeds ="";
        //$password= $_POST['password'];
       if((isset($_POST['submitFeeds'])) && (isset($_POST['box'])) && $_POST['password'] == MY_PASSWORD)
       {
            
            if(count($_POST['box'])>10)
            {
               $feeds = " Please select feeds less than or equal to 10";
               return $feeds;
            }
            else
            {
                $domFeeds = new DOMDocument();
                $domFeeds->load('rss_class.xml');
                $studentList = $domFeeds->documentElement->getElementsByTagName('news')->item(0)->getElementsByTagName('student');
                
                for($i = 0; $i<$studentList->length; $i++)
                {
                    if(in_array($i, $_POST['box']))
                    {
                        
                        $studentList->item($i)->setAttribute('selected','yes');
                    }
                    else
                    {
                        $studentList->item($i)->setAttribute('selected','no');
                    }
                }
                
                $domFeeds->save('rss_class.xml');
                return $feeds;
                //$this->displayFeeds();
            }
        
       }
    }
/******************end of feedservices***************************/

/******************************************************************************
 DESCRIPTION: DISPLAY FEEDS OF OTHER SUDENT
 
 *****************************************************************************/
    public static function displayFeeds()
    {
        $value = "";
        $name = "";
        $feeds = array();
        $domDisplay = new DomDocument();
		$file = 'rss_class.xml';
        $domDisplay->load($file);
        $selectedFeeds = $domDisplay->getElementsByTagName("student");
        foreach($selectedFeeds as $postings)
        {
            //$selectStudent = $postings->getAttribute('selected');
            
            if($postings->getAttribute('selected') == "yes")
            {
                $name = $postings->getElementsByTagName('first')->item(0)->nodeValue;
                $siteLink = $postings->getElementsByTagName('url')->item(0)->nodeValue;
                $rss = new DOMDocument();
                //$rss->load($siteLink);
                
				if(@$rss->load($siteLink))
				{
					$rssFeed = $rss->getElementsByTagName('item');

					$limit = 2;
					
					if($rssFeed->length != 0)
					{
					
						for($i = 0 ; $i<$limit; $i++)
						{
							$news = $rssFeed->item($i);
							$subject = $news->getElementsByTagName('title')->item(0)->nodeValue;
							/*$link = $news->getElementsByTagName('link')->item(0)->nodeValue;
							if(strlen($link)<0)
							{
								$link = $siteLink;
							
							*/
							$content = $news->getElementsByTagName('description')->item(0)->nodeValue;
							$date = $news->getElementsByTagName('pubDate')->item(0)->nodeValue;
							
							$value .="<h1>$name</h1>";
							$value .= "<h2 class='heading'>$subject</h2>";
							$value .="<span class ='font-style'>$date</span>";
							$value .="<p class='post'>$content</p>";
						}
						
						/*----for testing-----*/
						/* foreach($rssFeed as $news)
						{
							$item = array(
							'title' => $news->getElementsByTagName('title')->item(0)->nodeValue,
							'desc' => $news->getElementsByTagName('description')->item(0)->nodeValue,
							'link' => $news->getElementsByTagName('link')->item(0)->nodeValue,
							'date' => $news->getElementsByTagName('pubDate')->item(0)->nodeValue,
							); //end of array
							array_push($feeds, $item);
						}//end of for each*/
					}else{
							$value .="<h1>$name</h1>";
							$value .= "<h2 class='heading'>$subject</h2>";
							$value .="<span class ='font-style'>$date</span>";
							$value .="<p class='post'>Unfortunately the RSS feed for $name is unavailable at this time</h3></p>";
						
						}//end of if rssFeed
					
				}else{
						$value .="<h1>$name</h1>";
						$value .= "<h2 class='heading'>$subject</h2>";
						$value .="<span class ='font-style'>$date</span>";
						$value .="<p class='post'>Unfortunately the RSS feed for $name is unavailable at this time</h3></p>";
						
				}//end of if sitelink
					
					
					/*----for testing ---*/
					/*echo "<pre>";
					print_r($feeds);
					echo "</pre>";*/
					
				
			}//end of if selected
		}//end of for each
        
        return $value;
    }
/*********************END OF DISPLAY SERVICES**********************************/

/*******************************************************************************
 DESCRIPTION: CHECK IF WEBSERVICES CHECK SUBMIT BUTTON HAS BEEN PRESSED
 
 *******************************************************************************/
    public static function checkWebServicesSubmitButton()
    {
        $value = "";
        
        if(isset($_POST['submitFeeds']) && isset($_POST['box']) && isset($_POST['password']) == MY_PASSWORD)
        {
            if(count($_POST['box'])<10)
            {
                $dom = new DOMDocument();
                $dom->load('rss_class.xml');
                $root = $dom->getElementsByTagName('web')->item(0)->getElementsByTagName('choice');
                for($i = 0; $i<$root->length; $i++)
                {
                            //print_r($_POST['box']);
                            //echo "</pre>";
                            if(in_array($i, $_POST['box']))
                            {
                               $root->item($i)->setAttribute('selected','yes');
                            }
                            else
                            {
                                $root->item($i)->setAttribute('selected','no');
                            }
                }
                $dom->save('rss_class.xml');
            }
            else
            {
                $feeds = " Please select feeds less than or equal to 10";
               return $feeds;
            }
            
        }
    }
/*******************************************************************************
 DESCRIPTION: DISPLAYS THE WEBSERVICES ON INDEX.PHP
 *******************************************************************************/

public static function displayWebServices()
    {
       $value = "";
       ini_set('display_errors',1);
       $web = array();
       $dom = new DOMDocument();
       $dom->load('rss_class.xml');
       $root = $dom->getElementsByTagName('choice');
       
       
       foreach($root as $web)
       {
        
            //echo $web->getAttribute('selected');
            if($web->getAttribute('selected') == "yes")
            {
                //$length = $web->length;
           // for($i = 0; $i <1; $i++)
            {
        
                $name = $web->getElementsByTagName('name')->item(0)->nodeValue;
                $url = $web->getElementsByTagName('url')->item(0)->nodeValue;
                
                $domWeb = new DOMDocument();
                $domWeb->load($url);
                
                $title = $domWeb->getElementsByTagName('title')->item(0)->nodeValue;
                $item = $domWeb->getElementsByTagName('item')->item(0);
                $content = $item->getElementsByTagName('description')->item(0)->nodeValue;
                
                $value .="<span class = 'heading' style='font-size:15pt; padding:0.5em'>";
                $value .=$title;
                $value .="</span>";
                $value .= "<p class='font-style' style='font-size:15pt; padding:0.5em'><a href=\"$url\">$url<a></p>";
                $value .="<p class='post' style='font-size:12pt; padding:0.5em'>";
                $value .= $content;
                $value .= "</p>";
                
                
            }
            }
       }
       return $value;
    }

/******************************************************************************
 DESCRIPTION: generates permalink
 ******************************************************************************/
/*static public function generatePermalink($staticLink) {
		
		//$string = rand(11, 49);
		//$string.= rand(50, 99);
		$string = $staticLink ;
		//echo "<p>this is permId".$staticLink."</p>";
		//return $string;
		
		
		
		
	}
*/

}//END OF CLASS

?>
