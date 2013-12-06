<?php
// test class here

require_once('LIB_project1.php');
require_once('P2_Utils.class.php');



// define class here
class RSSFeed{
    // property declaration
    public $title = 'RSS FEED';
    public $link = 'people.rit.edu/smt9471/739/project2/project2.rss';
    public $description = 'Shrutikas project2 rss feed';
    public $lastBuildDate = '2';
    public $items = array();
    //need to declare null to check if pass anything
    public $subject = null;
    public $content = null;
    public $date = null;
    public $rssFeed = null;
    public $guid = null;
      
     
     
     public function __construct($rssFeed)
     {
	$this->lastBuildDate= date('r');
	//checking if project2.rss is null
	if(!$this->rssFeed)
	{
		$dom = new DOMDocument();
		$this->toXML();
		//echo "I am in not null";
	}
	/*else
	{
		//if project2.rss is created create dom object and load the file
		$dom = new DOMDocument();
		$this->rssFeed = $rssFeed;
		$this->dom->load($rssFeed);
		$this->toXML();
		echo "I am in null";
		
	}*/
     }
  
    
   /* public function toXML(){
    	// I am using string concation here, you MUST use DOM methods instead.
    	$dom="";
    	$dom .="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    	$dom .= "<rss>\n";
    	$dom .= "<channel>\n";
    	$dom .= "<title>$this->title</title>\n";
    	$dom .= "<link>$this->link</link>\n";
    	$dom .= "<description>$this->description</description>\n";
    	$dom .= "<lastBuildDate>$this->lastBuildDate</lastBuildDate>\n";
    	
    	foreach($this->items as $k=>$v){
    		$dom .= "<item>\n";
		$subject = htmlentities($subject);
		$content = htmlentities($content);
			//$time == don't forget to do this
    		$dom .= "<title>$subject</title>\n";
    		$dom .= "<description><![CDATA[$content]]></description>\n";
    		$dom .= "<pubDate>$time</pubDate>\n";
    		$dom .= "</item>\n";
    	}
    	
     $dom .= "</channel>";
    $dom .= "</rss>";
    	
    	return $dom;
    }*/
   
   public function toXML()
   {
	/*if($this->rssFeed)
	{
		$dom = new DomDocument('1.0', 'utf-8');
		$root= $dom->createElement('rss');
		
		$dom->appendChild($root);
		
		$channel= $dom->createElement('channel');
		$dom->documentElement->appendChild($channel);
		
		$title = $dom->createElement('title',$this->title);
		$dom->appendChild($title);
		
		$link = $dom->createElement('description',$this->description);
		$dom->appendChild($link);
		
		$lastBuildDate = $dom->createElement('lastBuildDate',$this->lastBuildDate);
		$dom->appendChild($lastBuildDate);
		
		$this->dom = $dom;
	}*/
   
   //$updatedDate = $channel->getElementsByTagName('lastBuildDate')->item(0);
   //$updateDate->nodeValue = $this->lastBuildDate;
		if(!$this->rssFeed)
		{
			$dom = new DOMDocument();
			
			$root = $dom->createElement('rss');
			$root->setAttribute('version','2.0');
			$dom->appendChild($root);
			
			$channel= $dom->createElement('channel');
			$dom->documentElement->appendChild($channel);
			
			foreach($this->items as $k=>$v)
			{
				     
				     $item = $dom->createElement('item');
				     
				     $firstItem = $channel->getElementsByTagName('item')->item(0);
				     
				     
				     //$item will be insserted before $firstItem
				     $channel->insertBefore($item, $firstItem);
				     
						     
				     $time = $k;
					     $subject = htmlentities($v['subject']);
					     $content = htmlentities($v['content']);
			     
				     $dom_title = $dom->createElement('title', $subject);
				     $item->appendChild($dom_title);
				     
				     $dom_link = $dom->createElement('link',$this->link);
				     $item->appendChild($dom_link);
				     
				     $dom_pubDate = $dom->createElement('pubDate', $time);
				     $item->appendChild($dom_pubDate);
				     
				     $dom_description = $dom->createElement('description');
					     $dom_cdata = $dom->createCDATASection($content);
					     $dom_description->appendChild($dom_cdata);
				     $item->appendChild($dom_description);
				     
				     
				     
				     //$dom_pubDate = $dom->createElement('pubDate', $time);
				     //$item->appendChild($dom_pubDate);
				     
				      
					 $string1 = rand(11, 49);
					 $string2 = rand(50, 99);
				     $guid = $string1.$string2;
				     $dom_guid = $dom->createElement('guid',$guid );
				     $dom_guid->setAttribute('isPermaLink', "true");
				     $item->appendChild($dom_guid);
				     $channel->appendChild($item);
				     
				     
			     }//end of foreach
			     
			     $this->dom = $dom;
			     //$dom->save('project2.rss');
			     return $dom;
		}//end of if statemnt
    }//end of function XML
}

?>
