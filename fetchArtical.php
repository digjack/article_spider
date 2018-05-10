<?php
require 'vendor/autoload.php';
use PHPHtmlParser\Dom;

$url = "http://www.wenxuecity.com/";

$urls = fetchUrlsFromPage($url);
//print_r($urls);die;

foreach($urls as $url){
    saveFileFromUrl($url);
}

function fetchUrlsFromPage($url){
    $page = 	get_web_page($url);
$page = $page['content'];
    $html = new \HtmlParser\ParserDom($page);

//print_r($html);die;
$sections = $html->find('a');
    $urls = [];
    foreach($sections as $section){
        $url = $section->getAttr('href');
        if(isArticleUrl($url)){
            $url = str_replace('.html', '_print.html', $url);
            // todo:join host
	    if(strpos($url, 'http:') === false){
		$url = 'http://www.wenxuecity.com'.$url;
}
            $urls []= $url;
        }
    }
    return $urls;
}

//判断是不是文章的链接
function isArticleUrl($url){
    if(strpos($url, 'news/2018') !== false){
        return true;
    }

    return false;

}
//文章保存成文件
function saveFileFromUrl($url)
{
    $dom = new Dom;
    $dom->loadFromUrl($url);
//print_r($dom->outerHtml);die;
    //$dom->loadFromFile('article.html');
    $title = $dom->getElementsbyTag('h1')[0]->text;
    $title = str_replace('(组图)','', $title);
    $body = '';
 
    $content = get_string_between($dom->outerHtml, '<hr />', '<hr />');
    $content = str_replace('<br />', "\n", $content);
$body .= $content;
   
    $sections = $dom->find('p');
    foreach($sections as $section){
         
        $content = $section->innerHtml;
        
        $imgs = $section->find('img');
        foreach($imgs as $img){
            $imgStr = transferImg($img->outerHtml);
            $body .= $imgStr;
        }
        
        if(strpos($content, '文学城') !== false) continue;
        if(strpos($content, '文章来源') !== false) continue;
        $content = str_replace('<br />', "\n", $content);
        if(strpos($content, '发表评论于') !== false){
            break;
        }
        $content .= "\n";
        $body .= $content;
        
    }
    file_put_contents('article/'.$title, $body);
         echo "$url \n";
    echo "文章《{$title} 》保存成功\n";
}
//转存图片
//<img border="0" src="./article_files/33cec28b2f8724436bd8667bc7cd5aae.jpg" />
function transferImg($img){
    return $img;
}


function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
?>
