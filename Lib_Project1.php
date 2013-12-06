<?php
define('MY_PASSWORD','pass');
define('NEWS_FILE','news.xml');
global $filename;
global $no_of_post;
/********************************************************************
DESCRIPTION: creates html header tage and returns

INPUT: $title String that displays the title of the page.
       $string returns the html header tag.
    
*********************************************************************/

function html_header($title=" ", $styles=" ")
{
    $banner = file("banners.txt");
    $logo="";
    $image= array();
    $time = array();
    $weight = array();
    $combine = array();
    
    /*echo "<pre>From File";
        print_r($banner);
        echo "</pre>";*/
    
    foreach($banner as $banners)
    {
        list($images,$times, $weights) = explode("|", $banners);
        $image[] = $images;
        $time[] = $times;
        $weight[] = $weights;
        $combine[] = $images."|".trim($weights);
    }
        /*echo "<pre>Before Time";
        print_r($time);
        echo " Combine \n";
        print_r($combine);
        echo "</pre>";*/
        array_multisort( $time, $combine);
        /*echo "<pre>After Time";
        print_r($time);
        echo " Combine \n";
        print_r($combine);
        echo "</pre>"*/
       /* foreach($combine as $combo)
        {
        list($logo,$weightNo) = explode("|", $combo);
        //$logo = $time[0].$combine[0];
        }*/
                $time[0] = $time[0] + 1;

    //echo count($combine);
    file_put_contents("banners.txt","");
    $mypath = array();
    $picture = '';
    for($i = 0 ; $i < count($combine); $i++)
    {
        
        list($path,$weight1) = explode("|", $combine[$i]);
        /*echo "<pre> Combine Array";
        print_r($combine[$i]);
             echo "</pre> End combine";*/
        $picture .= $path."|".$time[$i]."|".$weight1."\n";
        $mypath[] = $path;
        
        //$images = $image[i];
        //$time = $time[i];
        //$feed = implode("|", array($image, $time));
        //$feed2 = implode("|",array($feed, $weight));
        //file_put_contents("banners.txt", "");
        //file_put_contents("banners.txt",$feed2,FILE_APPEND);
                file_put_contents("banners.txt",$picture);
/*echo "<pre> Pricture";
    print_r($picture);
    echo "</pre>Picture end";
*/
    
    }
        

    
    
$string =<<<END
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>$title</title>
        <meta name="description" content="RIT NEWS WEBSITE" />
        <meta name="keywords" content="RIT, RIT NEWS, ROCHESTER INSTITUTE OF TECHNOLOGY,SHRUTIKA,SHRUTIKA THAKUR,THAKUR, SHRUTIKA PROJECTS,PHP"/>
        <meta name ="author" content ="SHRUTIKA THAKUR"/>
        <meta charset ="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="$styles"/>
    </head>
    <body>
        <header>
            <div id="banner">
                <img src= "$mypath[0]" alt="RIT POST Banner" />
            </div>
        </header>
END;
    return $string;
    
}

/**************************************************************************
DESCRIPTION: DISPLAYS THE FOOTER OF THE PAGE

INPUT: $footerString to return the footer of the html page
        $userAgent to storet users browser information
**************************************************************************/

function html_footer($text="")
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($userAgent, 'Chrome')) {
        $browser='Chrome';
        }
    else if (strpos($userAgent, 'Firefox'))
    {
            $browser='Mozilla Firefox';
    }
    else if (strpos($userAgent, 'Safari')) {
            $browser='Safari';
    }
    else
    {
        $browser='Other';
    }
    $date = date('r');
    $ip = " YOUR IP ADDRESS IS " . $_SERVER['REMOTE_ADDR'];
    $footerString = <<<FOOTER
    <footer>
    <p>YOUR BROWSER INFOFORMATION: You are using $browser browser</p>
    <p>$ip</p>
    <p>
    ACCESSED DATE: $date
    </p>
    </footer>
    </body>
    </html>
FOOTER;
    return $footerString;   
    
}

/**********************************************************************
DESCRIPTION: Returns the navigation bar of the page
    
INPUT: $nav returns the navigation bar
***********************************************************************/
function html_navigationBar($menu="")
{
    $nav = <<<MENU
        <nav>
        <ul id="navigation">
            <li><a href="index.php">HOME</a></li>
            <li><a href="news.php">NEWS</a></li>
            <li><a href="admin.php">ADMIN</a></li>
            <li><a href="services.php">SERVICES</a></li>
            <li><a href="contact.php">CONTACT</a></li>
        </ul>
        </nav>
MENU;
    
        return $nav;
}



/***************************************************************************
DESCRIPTION: Method to generate news positing through a form maintained in
            admin.php

INPUT: $newsForm that maintains the news of the news paper.

*****************************************************************************/
function newsForm()
{
    $newsForm=<<<FORM
    <div class="formCss">
    <form action='admin.php' method='POST'>
    <table>
        <tr>
            <td>
                Subject : <input type='text' name='subject' size='80'/>
            </td>
        </tr>
        <tr>
            <td>
            Content:
            </td>
        </tr>
        <tr>
            <td>
                <textArea name ='newsContent' rows='15' cols='65'>
                </textArea>
            </td>
        </tr>
        <tr>
            <td>
            Password: 
            <input type='password' name ='Password'/>
            </td>
        </tr>
    </table>
        <input type = 'reset' name = 'reset' value = 'RESET'/>
	<input type = 'submit' name = 'submit' value = 'SUBMIT'/>

    </form>
    </div>
FORM;
    return $newsForm;    
            
}

/***************************************************************************
DESCRIPTION: Method to generate editorial posting through a form maintained
             in admin.php for index.php page

INPUT: $editForm that returns form to maintain letter from editor in the index.php
        page.
****************************************************************************/
function editorialForm()
{
     $edit= displayEditorial();

    $editForm =<<<EDIT
    <div class="formCss">
    <form action='admin.php' method='POST'>
    <table>
        <tr>
            <td>
            Content:
            </td>
        </tr>
        <tr>
            <td>
                <textArea name ='editorialContent' rows='15' cols='65'>
                echo $edit;
                </textArea>
            </td>
        </tr>
        <tr>
            <td>
            Password: 
            <input type='password' name ='password'/>
            </td>
        </tr>
    </table>
        <input type = 'reset' name = 'reset' value = 'RESET'/>
	<input type = 'submit' name = 'submitEdit' value = 'SUBMIT'/>

    </form>
    </div>
EDIT;
    return $editForm;
}

/****************************************************************************
DESCRIPTION: Form input validation method, to check wether the content/string
            enter is text only and to check wether all field are entered before
            submit button is pressed.
INPUT: $var to check the string of varibles entered in each form field
*****************************************************************************/
function sanitizeString($var)
{
    
    $var = stripslashes($var); //unquotes quoted string
    $var = htmlentities($var); //convert all applicable character to HTML entities
    $var = strip_tags($var); //html and php tags are striped from the string
	$var = trim($var); //trims whitespaces at the begining and end of the string
    return $var;

}
/*****************************************************************************
DESCRIPTION: method to fill the content of news in news.txt after submit is
            pressed in admin.php news posting form.
INPUT: 
*****************************************************************************/
//function checkNewsFormSubmit()
//{
//    if(isset($_POST['submit']))
//    {
//        if(isset($_POST['subject']) && isset($_POST['newsContent']) && isset($_POST['Password']))
//        {
//            $subject = sanitizeString($_POST['subject']);
//            $content = sanitizeString($_POST['newsContent']);
//            $password = sanitizeString($_POST['Password']);
//            
//            if($password = MY_PASSWORD && strlen($subject)>0 && strlen($content)>0)
//            {
//                $date = date('r');
//                $line = implode("|", array($subject,$date,$content));
//                $lineF = $line."\n";
//                file_put_contents("news.txt",$lineF,FILE_APPEND);
//            }else
//            {
//                
//                echo "<strong>Bad Password or you left something out!</strong>";
//            }
//        }
//        else
//        {
//            echo "<strong>you left something out!</strong>";
//        }
//    }
//    
//}

/*****************************************************************************
DESCRIPTION: method to fill the content of news in news.txt after submit is
            pressed in admin.php news posting form.
INPUT: 
*****************************************************************************/
function checkEditorialFormSubmit()
{
    if(isset($_POST['submitEdit']))
    {
        if( isset($_POST['editorialContent']) && isset($_POST['password']))
        {
            
            $editorialContent = sanitizeString($_POST['editorialContent']);
            $password = sanitizeString($_POST['password']);
            
            if($password = MY_PASSWORD  && strlen($editorialContent)>0)
            {
                $line = implode("|", array($editorialContent));
                $lineF = $line."\n";
                file_put_contents("editorial.txt",$lineF,FILE_APPEND);
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

/**************************************************************************
DESCRIPTION: to explode contets from editorial.txt
INPUT : $return return appropriate information for the letter of editorial section.        
*****************************************************************************/
function displayEditorial()
{
    $fileName = "editorial.txt";
    $data = file($fileName);
        $return = "";
    
    if(!file_exists($fileName))
    {
        $return = "File does not exist or unable to open";
        return $return;
    }
    else
        {
            foreach($data as $line)
            {
                list($info) = explode("|", $line);
                $return .="<p> $info </p>";
            }
            return $return;
        }
    
}
/****************************************************************************
DESCRIPTION: Method to explode contain from news.txt to right section of
            index.php
INPUT: $value that display the news posting;
*****************************************************************************/
function displayNews()
{
    $filename = "news.txt";
    $input = array_reverse(file($filename));
    $value ="";
    $newsData = array();
    
    if(!file_exists($filename))
    {
        $value = "File does not exists or unable to open";
        return $value;
    }
    else
        {
            
            
            
            
           for($index = 0; $index <=2; $index++)
           {
            
            {
                list($subject,$date,$content)=explode("|",$input[$index]);
				//$subjects = sanitizeString($subject);
				//$contents =  sanitizeString($content);
                $value .= "<h2 class='heading'>$subject</h2>";
                $value .="<span class ='font-style'>$date</span>";
                $value .="<p class='post'>$content</p>";
                
                          
            }
            
           }
            return $value;
            
        }
        
}

/***************************************************************************
DESCRIPTION: Method to generate CONTACT fORM 

INPUT: $contactForm that maintains the news of the news paper.

*****************************************************************************/
function contactForm()
{
    $contactForm=<<<FORM
    <div class="formCss">
    <form action='' method='POST'>
    <h2 class='title'>Or Drop a Mail to me @ smt9471@rit.edu </h2>
    <table>
        <tr>
            <td>
                Name : <input type='text' name='name' size='80'/>
            </td>
        </tr>
        <tr>
            <td>
                Email ID : <input type='text' name='email' size='80'/>
            </td>
        </tr>
        <tr>
            <td>
                Subject : <input type='text' name='subject' size='80'/>
            </td>
        </tr>
        <tr>
            <td>
            Content:
            </td>
        </tr>
        <tr>
            <td>
                <textArea name ='content' rows='15' cols='65'>
                </textArea>
            </td>
        </tr>
    </table>
        <input type = 'reset' name = 'reset' value = 'RESET'/>
	<input type = 'submit' name = 'submit' value = 'SUBMIT'/>

    </form>
    </div>
FORM;
    return $contactForm;    
            
}

/*****************************************************************************
DESCRIPTION: method to fill the contact in contact.txt and send a mail
             after submit is pressed
INPUT: 
*****************************************************************************/
function checkContactFormSubmit()
{
    if(isset($_POST['submit']))
    {
        if(isset($_POST['subject']) && isset($_POST['content']) && isset($_POST['name']) && isset($_POST['email']))
        {
            $subject = sanitizeString($_POST['subject']);
            $content = sanitizeString($_POST['content']);
            $name = sanitizeString($_POST['name']);
            $email = sanitizeString($_POST['email']);
           
            
            if(strlen($subject)>0 && strlen($name)>0 && strlen($content)>0 && strlen($email)>0)
            {
                $date = date('r');
                $to = "smt9471@rit.edu";
                 $headers = $email ."from". $name;
                mail($to,$subject,$content,$headers);
                $value = "Mail Sent";
            }else
            {
                
                echo "<stron>you left something out!</strong>";
            }
        }
        else
        {
            echo "<strong>you left something out!</strong>";
        }
        return $value;
    }
    
}


/***********end of project**************/
?>
