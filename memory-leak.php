<?php

// includes Simple HTML DOM Parser
//include "simple_html_dom.php";
include "Sunra\PhpSimple\HtmlDomParser.php";
use Sunra\PhpSimple\HtmlDomParser;


echo 'memory =',round(memory_get_usage()/1000),' KB<br>';  /***************************/

$url = 'http://www.marketwatch.com/';
$html = HtmlDomParser::file_get_html( $url );
//$html = file_get_html($url);
//echo $html;

foreach($html->find('div#mostpopular img') as $images){
    if($images->src !='')echo $images-> outertext ;
}

echo '<br>';

echo 'memory before clear =',round(memory_get_usage()/1000),' KB<br>';   /***************************/
echo 'true memory before clear =',round(memory_get_usage(true)/1000),' KB<br>';

$html->clear();
//$images->clear();
$html = null;
unset($html);
//unset($images);

echo 'memory after clear =',round(memory_get_usage()/1000),' KB<br>';   /***************************/
echo 'true memory after clear =',round(memory_get_usage(true)/1000),' KB<br>';

echo 'memory before clean_all =',round(memory_get_usage()/1000),' KB<br>';  /***************************/
echo 'true memory before clean_all =',round(memory_get_usage(true)/1000),' KB<br>';
clean_all($GLOBALS);

echo 'memory after clean_all =',round(memory_get_usage()/1000),' KB<br>';   /***************************/
echo 'true memory after clean_all =',round(memory_get_usage(true)/1000),' KB<br>';


function clean_all(&$items,$leave = ''){
    foreach($items as $id => $item){
        if($leave && ((!is_array($leave) && $id == $leave) || (is_array($leave) && in_array($id,$leave)))) continue;
        if($id != 'GLOBALS'){
            if(is_object($item) && ((get_class($item) == 'simple_html_dom') || (get_class($item) == 'simple_html_dom_node'))){
                $items[$id]->clear();
                unset($items[$id]);
            }else if(is_array($item)){
                $first = array_shift($item);
                if(is_object($first) && ((get_class($first) == 'simple_html_dom') || (get_class($first) == 'simple_html_dom_node'))){
                    unset($items[$id]);
                }
                unset($first);
            }
        }
    }
}

//$html->clear();
unset($html);
$html = null;
echo '1 memory after clean_all =',round(memory_get_usage()/1000),' KB<br>'; 

echo "change update";

?>