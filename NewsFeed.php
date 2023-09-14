<?php
class foo{
    public $title;
    public $link;
    public $image_url;
   
}
  error_reporting(0);
    $business_rss = "http://www.thestar.com/feeds.articles.business.rss";
    $feed = "http://www.cbc.ca/cmlink/rss-business";
    $news_feed = "http://www.huffingtonpost.ca/feeds/verticals/canada-business/index.xml";
   
    $array=array();
    
    
    $xml=simplexml_load_file($feed,"SimpleXMLElement",LIBXML_NOCDATA );
    $news = $xml->channel->item;
    foreach ($news as $value) 
    {
        $foo = new foo();
       $foo->title= $value->title;
       $foo->link=$value->link;
       
       
        $doc = new DOMDocument();
        $doc->loadHTML($value->description);
        $xml = simplexml_import_dom($doc);
        $images = $xml->xpath('//img');
        foreach ($images as $img)
        {
            $foo->image_url= $img['src'];
        }
        $array[] = $foo;
        //array_mearge($array,$foo);
    }
    
    
    
     $news_feed=simplexml_load_file($news_feed,"SimpleXMLElement",LIBXML_NOCDATA );
     $newsFeed = $news_feed->channel->item;
    foreach ($newsFeed as $value) 
    {
       $foo = new foo();
       $foo->title= $value->title;
       $foo->link=$value->link;
       $foo->image_url=$value->enclosure["url"];
       
       //$array[] = $foo;
     }
     
     
     
     
       $businessrss_XML=simplexml_load_file($business_rss,"SimpleXMLElement",LIBXML_NOCDATA );
       
      $businessrssXML = $businessrss_XML->channel->item;
   

    foreach ($businessrssXML as $value) 
    {
       $foo = new foo();
       $ns=$value->getNamespaces(true);
       $foo->title= $value->title;
       $foo->link=$value->link;
       
       $child = $value->children($ns['media']);
       
       foreach ($child->content as $out_ns)
      {
          $foo->image_url=$out_ns->attributes()->url;
      }
           $array[] = $foo;
     }
     	header('Cache-Control: no-cache, must-revalidate');
			
			header('Content-type: application/json');
           echo json_encode($array,FALSE); 
  //  var_dump($array);

?>