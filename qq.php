<?php
header("Content-Type: text/html; charset=UTF-8");
libxml_use_internal_errors(true);
//建议php版本7 开启curl扩展
$typeid =$_GET["t"];
$page = $_GET["pg"];
$ids = $_GET["ids"];
$burl = $_GET["url"];
$wd = $_GET["wd"];

//===============================================基础配置开始===========================================
$web='https://v.qq.com';
//1=开启搜索  0=关闭搜索 默认关闭搜索
$searchable=1;
//1=开启首页推荐  0=关闭首页推荐
$indexable=1;

//====================以下内容可忽略不修改===================

//如不懂可以不填写
$cookie='';

//当影视详情没有影视图片或取图片失败时，返回该指定的图片链接(不设置的话，缺图时历史记录的主图会空白)
$historyimg='https://www.hjunkel.com/images/nopic2.gif';

//模拟ua 如非不要默认即可
$UserAgent='Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';

//1=开启直链分析  0=关闭直链分析 (直链也是通过本php页面解析) 测试极品关闭直链 大部分能通过webview解析
//该模板的直链代码是针对极品影视的，每个站的直链代码都不同。其他网站请设置为0关闭
$zhilian=0;
//====================以上内容可忽略不修改===================



//===============================================基础配置结束===========================================




//===============================================广告图片配置开始 可以不用修改 默认不开启=======================================
//$adable=1开启广告  $adable=0关闭广告图片  可插入指定图片到每次读取第一页影视列表的开头，默认关闭
$adable=0;
$adpicurl='https://alifei05.cfp.cn/creative/vcg/800/version23/VCG41184086603.jpg';
$adtitle1='我是片名';
$adtitle2='我是更新内容';
//===============================================广告图片配置结束 可以不用修改 默认不开启============================================





//===============================================影视分类相关配置开始===========================
$movietype = '{"class":[{"type_id":"1","type_name":"电 影","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"2","type_name":"连续 剧","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"3","type_name":"综艺","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=variety&exclusive=-1&listpage=2&offset={pageid}&pagesize=30&sort=4"},{"type_id":"4","type_name":"国漫","catname":"https://v.qq.com/x/bu/pagesheet/list?append={append}&channel=cartoon&iarea=1&listpage=2&offset={pageid}&pagesize=30&sort=23"},{"type_id":"5","type_name":"日漫","catname":"https://v.qq.com/x/bu/pagesheet/list?append={append}&channel=cartoon&iarea=2&listpage=2&offset={pageid}&pagesize=30&sort=23"},{"type_id":"6","type_name":"偶像爱情","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=1&iarea=-1&listpage=2&offset=={pageid}&pagesize=30&sort=19"},{"type_id":"7","type_name":"古装历史","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=2&iarea=-1&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"8","type_name":"玄幻史诗","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=3&iarea=-1&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"9","type_name":"都市生活","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=4&iarea=-1&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"10","type_name":"武侠江湖","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=9&iarea=-1&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"11","type_name":"青春校园","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=10&iarea=-1&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"12","type_name":"历险科幻","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=tv&feature=6&iarea=-1&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"13","type_name":"剧情片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100018&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"14","type_name":"喜剧片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100004&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"15","type_name":"动作片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100061&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"16","type_name":"爱情片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100005&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"17","type_name":"惊悚片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100010&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"18","type_name":"犯罪片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=4&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"19","type_name":"悬疑片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100009&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"20","type_name":"战争片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100006&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"21","type_name":"科幻片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100012&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"22","type_name":"动画片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100015&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"23","type_name":"恐怖片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100007&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"24","type_name":"冒险片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100003&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"25","type_name":"武侠片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100011&listpage=2&offset={pageid}&pagesize=30&sort=19"},{"type_id":"26","type_name":"奇幻片","catname":"https://v.qq.com/x/bu/pagesheet/list?_all=1&append={append}&channel=movie&itype=100016&listpage=2&offset={pageid}&pagesize=30&sort=19"}]}';
//===============================================影视分类相关配置结束===========================





//===============================================首页推荐相关配置开始===========================
//取出影片ID的文本左边 适配影视列表的$url1
//取出影片ID的文本右边 适配影视列表的$url2


//读取首页的链接
$indexweb='https://v.qq.com/channel/tv?listpage=1&_all=1&channel=tv&sort=19';

//首页最多读取多少个影片
$indexnum=30;

//xpath列表
$indexquery="//div[@class='list_item']/a[@class='figure']/img[@class='figure_pic']";

//取出影片的图片
$indexpic="//div[@class='list_item']/a[@class='figure']/img[@class='figure_pic']/@src";

//取出影片的标题
$indextitle="//div[@class='list_item']/a[@class='figure']/img[@class='figure_pic']/@alt";

//取出影片的链接
$indexlink="//div[@class='list_item']/a[@class='figure']/@href";

//影视更新情况 例如：更新至*集
$indexquery2 = "//li[contains(@class,'col-lg-6 col-md-6 col-sm-4 col-xs-3')]/div[@class='myui-vodlist__box']/a/span[contains(@class,'pic-text')]";
//===============================================首页推荐相关配置结束===========================








//===============================================影视列表相关配置开始===========================
//取出影片ID的文本左边
$url1='';

//取出影片ID的文本右边
$url2='';

//每页多少个影片
$num=30;

//xpath列表
$query="//div[@class='list_item']/a[@class='figure']/img[@class='figure_pic']";

//取出影片的图片
$picAttr="//div[@class='list_item']/a[@class='figure']/img[@class='figure_pic']/@src";

//取出影片的标题
$titleAttr="//div[@class='list_item']/a[@class='figure']/img[@class='figure_pic']/@alt";

//取出影片的链接
$linkAttr="//div[@class='list_item']/a[@class='figure']/@href";

//影视更新情况 例如：更新至*集
$query2 = "//div[@class='list_item']/a[@class='figure']";
//===============================================影视列表相关配置结束===========================







//===============================================影视详情相关配置开始===========================
//影片名称
$vodtitle="//h2[@class='player_title']/a";
//===============================================影视详情相关配置结束===========================







//===============================================影视搜索相关配置开始===========================
//=========下面把xpath规则的搜索屏蔽了，极品采用json的搜索结果========
$searchtype=1;


//影片搜索 {wd}=搜索文字
//$searchtype=1的网址
$search='https://v.qq.com/x/search/?q={wd}&stag=0&smartbox_ab=';

$searchurl1='';

$searchurl2='';

//xpath列表
$searchquery="//div[@class='_infos']/div/a[@class='figure result_figure']";

//xpath规则取出影片的标题
$searchtitleAttr="//div[@class='_infos']/div/a[@class='figure result_figure']/img[@class='figure_pic']/@alt";

//xpath规则取出影片的链接
$searchlinkAttr="//div[@class='_infos']/div/a[@class='figure result_figure']/@href";

//xpath规则取影视更新情况 例如：更新至*集
$searchquery2 ="1";


//-----------------------------如非必要，下面4项可以不用修改-------------------------------
//影片标题是否精确匹配  1=精确匹配（必须包含搜索文字）  0为关闭精确匹配，显示所有搜索结果
$titlematch=1;
//搜索访问类型 1=get  2=post 一般默认为1
$datatype=1;
//搜索访问提交数据 当$datatype为2时，需要在此处填写提交数据 关键词用{wd}代替
$searchdata='';
//{wd}提交的编码格式  1=utf-8编码  2=gb2312编码(大部分网站默认为utf-8即可)
$convert=1;
//-----------------------------如非必要，上面4项可以不用修改-------------------------------



//===============================================影视搜索相关配置结束===========================
//==============================================仅需修改以上代码↑=======================================


//==============================================以下内容的代码无需修改↓=======================================
$weburl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if ($typeid<> null && $page<>null){
//==============================================读取影视列表开始=======================================
$catname ='';
$arr=json_decode($movietype,true);
$arr_q1a=$arr['class'];
$m=count($arr_q1a);
 for($i=0;$i<$m;$i++){
 $type_id = $arr_q1a[$i]["type_id"];
 if($typeid==$type_id){
  $catname =  $arr_q1a[$i]["catname"];
  break;
 }
 }
$offset=($page-1)*30;
$catname=str_replace('{pageid}',$offset,$catname);
if($page==1){
$append='0';
}else{
$append='1';
}
$catname=str_replace('{append}',$append,$catname);
$html ='';
for ($i = 0; $i < 3; $i++) {
$html = curl_get($catname,$cookie,$UserAgent);
if($html<>null){
break;
}
}
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($query2);
$events = $xpath->query($query);
$picevents = $xpath->query($picAttr);
$titleevents= $xpath->query($titleAttr);
$linkevents= $xpath->query($linkAttr);
$length=$events->length;
$guolv='';
if ($adable==1 && $page==1){
$length=$length+1;
}
if ($length<$num)
{
$page2=$page;
}else{
$length=$length+1;
$page2=$page + 1;
}
$result='{"code":1,"page":'.$page.',"pagecount":'. $page2 .',"total":'. $length.',"list":[';
if ($adable==1 && $page==1){
    $result=$result.'{"vod_id":"888888888","vod_name":"'.$adtitle1.'","vod_pic":"'.$adpicurl.'","vod_remarks":"'.$adtitle2.'"},';
}
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $text = replacestr($text);
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $title = replacestr($title);
    $pic = $picevents->item($i)->nodeValue;
      if($url1<>null){
       $link2 =getSubstr($link,$url1,$url2);
    }else{
    $link2 =$link;
    }
    
    	if (substr($pic,0,2)=='//'){
	$pic = 'http:'.$pic;
	}else if (substr($pic,0,4)<>'http' && $pic<>null){
	$pic = $web.$pic;
	}

if($guolv==null){
	    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link2."}";
}else if(strpos($guolv, "{".$link2."}")===false){
	    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link2."}";
	}
 
}

$result=substr($result, 0, strlen($result)-1).']}';
echo $result;
//==============================================读取影视列表结束=======================================
}else if ($ids<> null && strpos($ids, ",")===false && strpos($ids, "%2C")===false){
if($ids=='888888888'){
$result='{"list":[{"vod_id":"888888888",';
$result=$result.'"vod_name":"'.$adtitle1.'",';
$result=$result.'"vod_pic":"'.$adpicurl.'",';
$actor='内详';
$result=$result.'"vod_actor":"'.$actor.'",';
$director='内详';
$result=$result.'"vod_director":"'.$director.'",';
$result=$result.'"vod_content":"'.$adtitle2.'",';
$result= $result.'"vod_play_from":"'."无播放源".'",';
$result= $result.'"vod_play_url":"'."1".'"}]}';
echo $result;
}else{
//==============================================读取影视信息开始=======================================
$html ='';
for ($i = 0; $i < 3; $i++) {
$html = curl_get($ids,$cookie,$UserAgent);
if($html<>null){
break;
}
}
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
if($vodtitle<>null){
$texts = $xpath->query($vodtitle);
$text = $texts->item(0)->nodeValue;
$text = replacestr($text);
}
if(strpos($html, '"type_name":"')>0){
$type = unicode_decode(getSubstr($html, '"type_name":"', '",'));
}
if(strpos($html, '"year":"')>0){
$year = getSubstr($html, '"year":"', '",');
}
if(strpos($html, '"new_pic_hz":"')>0){
$img= getSubstr($html, '"new_pic_hz":"', '",');
}
if($img==null){
$img= $historyimg;
}
if(strpos($html, '"description":"')>0){
$vodtext2 = getSubstr($html, '"description":"', '",');
$vodtext2=unicode_decode(replacestr(str_replace("\r\n","",$vodtext2)));
}

if(strpos($html, '"area_name":"')>0){
$area = unicode_decode(getSubstr($html, '"area_name":"', '",'));
}
if(strpos($html, '"director":["')>0){
$director=getSubstr($html, '"director":["', '"]');
$director=str_replace('"','',$director);
$director=str_replace(',','  ',$director);
$director=unicode_decode(replacestr($director));
}

if(strpos($html, '"leading_actor":["')>0){
$actor=getSubstr($html, '"leading_actor":["', '"]');
$actor=str_replace(',','  ',$actor);
$actor=str_replace('"','',$actor);
$actor=unicode_decode(replacestr($actor));
}

$coverid=getSubstr($html, '"cover_id":"', '",');
$result='{"list":[{"vod_id":"'.$ids.'",';
if($text==null){
$text='片名获取失败';
}
$result=$result.'"vod_name":"'.$text.'",';
if($img<>null){
$result=$result.'"vod_pic":"'.$img.'",';
}
if($type<>null){
$result=$result.'"type_name":"'.$type.'",';
}
if($year<>null){
$result=$result.'"vod_year":"'.$year.'",';
}
if($actor==null){
$actor='内详';
}
$result=$result.'"vod_actor":"'.$actor.'",';
if($director==null){
$director='内详';
}
$result=$result.'"vod_director":"'.$director.'",';
if($area<>null){
$result=$result.'"vod_area":"'.$area.'",';
}
if($vodtext2<>null){
$vodtext2=str_replace('"','\"',$vodtext2);
$result=$result.'"vod_content":"'.$vodtext2.'",';
}
$yuan = 'qq';
$html2 =getSubstr($html, 'var COVER_INFO =', 'var COLUMN_INFO');
$arr=json_decode($html2,true);
$arr_q1a=$arr['vip_ids'];
$m=count($arr_q1a);
if($m<=1){
$result= $result.'"vod_play_from":"'."qq".'",';
$result= $result.'"vod_play_url":"'.'高清$'.$ids.'"}]}';
}else{
$dizhi='';
 for($i=0;$i<$m;$i++) 
{ 
$i2=$i+1;
$dizhi2=$arr['vip_ids'][$i]['V'];
$F=$arr['vip_ids'][$i]['F'];
if($F==4 or $F==0){
$name='第'.$i2.'集(预)';
}else{
$name='第'.$i2.'集';
}
$dizhi=$dizhi.$name.'$https://v.qq.com/x/cover/'.$coverid.'/'.$dizhi2.'.html'.'#';
}
$dizhi=substr($dizhi, 0, strlen($dizhi)-1);
$result= $result.'"vod_play_from":"'.$yuan.'",';
$result= $result.'"vod_play_url":"'.$dizhi.'"}]}';
}
echo $result;
//==============================================读取影视信息结束=======================================
}

}else  if ($burl<> null){

//=============================以下是直链分析代码=======================================================
$html = curl_get($burl,$cookie,$UserAgent);
$content=getSubstr($html,'var player','</script>');
$content=getSubstr($content,'"url":"','",');
$content=urldecode(str_replace("\/","/",$content));
if(strpos($content,'.m3u8')>0 or strpos($content,'.mp4')>0){
echo  '<iframe src="'.$content.'" class="iframeStyle" id="myiframe" ></iframe>';
}else{
$from=getSubstr($html,'"from":"','",');
$from=urldecode(str_replace("\/","/",$from));
$playerconfig=$web.'/static/js/playerconfig.js';
$playerhtml = curl_get($playerconfig,$cookie,$UserAgent);
if(strpos($playerhtml,'player_list=')>0){
$content2=getSubstr($playerhtml,'player_list=',',Mac');
$arr=json_decode($content2,true);
$show=$arr[$from]['show'];
$parse=$arr[$from]['parse'];
if (substr($parse,0,4)<>'http'){
$parse=$web.$parse;
}
$parse=str_replace("\/","/",$parse);
echo  '<iframe src="'.$parse.$content.'" class="iframeStyle" id="myiframe" ></iframe>';
}else{
echo  '<iframe src="'.$burl.'" class="iframeStyle" id="myiframe" ></iframe>';
}
}
//==============================以上是直链分析代码=======================================================



}else  if ($wd<> null){
//=============================以下是搜索代码=======================================================
if($searchable==0){
echo 'php未开启搜索';
exit;
}
if($page==null){
$page=1;
}
if($convert==1){
$key=urlencode($wd);
}else{
$key=urlencode(mb_convert_encoding($wd, 'gb2312', 'utf-8'));
}
$geturl =str_replace("{wd}",$key,$search);
$geturl =str_replace("{page}",$page,$geturl);
if ($datatype==1){
$html = curl_get($geturl,$cookie,$UserAgent);
}else{
$getdata=str_replace("{wd}",$key,$searchdata);
$getdata=str_replace("{page}",$page,$getdata);
$html = curl_post($geturl,$getdata,$cookie,$UserAgent);
}

if($searchtype==1){
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
if($searchquery2<>null){
$texts = $xpath->query($searchquery2);
}
$events = $xpath->query($searchquery);
$titleevents= $xpath->query($searchtitleAttr);
$linkevents= $xpath->query($searchlinkAttr);
$length=$events->length;
$result='{"code":1,"page":'.$page.',"pagecount":'. $page.',"total":'. $length.',"list":[';
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    if($searchquery2<>null){
$text = $texts->item($i)->nodeValue;
    }
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $title=replacestr($title);
    if($searchurl1<>null){
        $link2 =getSubstr($link,$searchurl1,$searchurl2);
    }else{
    $link2 =$link;
    }
 
    if($titlematch==0){
    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_remarks":"'.$text.'"},';
    }else if($titlematch==1 and strpos($title,$wd)===false){
    }else{
    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_remarks":"'.$text.'"},';
    }
    
}
$result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}else{
$arr=json_decode($html,true);
$arr_q1a=$arr[$searchquery];
$m=count($arr_q1a);
$result='{"code":1,"page":'.$page.',"pagecount":'. $page.',"total":'. $m.',"list":[';
 for($i=0;$i<$m;$i++){
 $title = $arr_q1a[$i][$searchtitleAttr];
$link =  $arr_q1a[$i][$searchlinkAttr];
if($url1==null && is_numeric($link)==true && $searchurl1<>null){
$link =$searchurl1.$link.$searchurl2;
}
if($searchquery2<>null){
$text = $arr_q1a[$i][$searchquery2];

if($titlematch==0){
$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_remarks":"'.$text.'"},';
}elseif($titlematch==1 and strpos($title,$wd)===false){
}else{
$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'","vod_remarks":"'.$text.'"},';
}

}else{
if($titlematch==0){
$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'"},';
}else if($titlematch==1 and strpos($title,$wd)===false){
}else{
$result=$result.'{"vod_id":"'.$link.'","vod_name":"'.$title.'"},';
}

}
 }
 $result=substr($result, 0, strlen($result)-1).']}';
echo $result;
}
//==============================以上是搜索代码=======================================================
}else{
if($indexable==0){
echo $movietype;
}else{
$html = curl_get($indexweb,$cookie,$UserAgent);
$dom = new DOMDocument();
$html= mb_convert_encoding($html ,'HTML-ENTITIES',"UTF-8");
$dom->loadHTML($html);
$dom->normalize();
$xpath = new DOMXPath($dom);
$texts = $xpath->query($indexquery2);
$events = $xpath->query($indexquery);
$picevents = $xpath->query($indexpic);
$titleevents= $xpath->query($indextitle);
$linkevents= $xpath->query($indexlink);
$length=$events->length;
$guolv='';
$m2=0;
$result=',"list": [';
for ($i = 0; $i < $events->length; $i++) {
    $event = $events->item($i);
    $text = $texts->item($i)->nodeValue;
    $text = replacestr($text);
    $link = $linkevents->item($i)->nodeValue;
    $title = $titleevents->item($i)->nodeValue;
    $title = replacestr($title);
    $pic = $picevents->item($i)->nodeValue;
      if($url1<>null){
       $link2 =getSubstr($link,$url1,$url2);
    }else{
    $link2 =$link;
    } 
    	if (substr($pic,0,2)=='//'){
	$pic = 'http:'.$pic;
	}else if (substr($pic,0,4)<>'http' && $pic<>null){
	$pic = $web.$pic;
	}
	if($title<>null && $link<>null){
if($guolv==null){
	    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link2."}";
    	$m2=$m2+1;
}else if(strpos($guolv, "{".$link2."}")===false){
	    $result=$result.'{"vod_id":"'.$link2.'","vod_name":"'.$title.'","vod_pic":"'.$pic.'","vod_remarks":"'.$text.'"},';
    	$guolv=$guolv."{".$link2."}";
    	$m2=$m2+1;
	}
	}
	if($m2>=$indexnum){
	break;
	}
}

if($m2==0){
echo $movietype;
}else{
$result=substr($result, 0, strlen($result)-1).']}';
echo substr($movietype, 0, strlen($movietype)-1).$result;
}
}
}

function unicode_decode($unistr, $encoding = 'utf-8', $prefix = '&#', $postfix = ';') {
 $arruni = explode($prefix, $unistr);
 $unistr = '';
 for ($i = 1, $len = count($arruni); $i < $len; $i++) {
 if (strlen($postfix) > 0) {
  $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
 }
 $temp = intval($arruni[$i]);
 $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
 }
 return iconv('UCS-2', $encoding, $unistr);
}


function curl_get($url,$cookie2,$UserAgent2){
  $header = array(
       'Accept: */*',
       'Accept-Language: zh-cn',
       'Referer: '.$url,
       'User-Agent: '.$UserAgent2,
       'Content-Type: application/x-www-form-urlencoded'
    );
        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt ($curl, CURLOPT_HTTPHEADER , $header);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent2);
    if($cookie2<>null){
    curl_setopt($curl, CURLOPT_COOKIE, $cookie2);
    }
    $data = curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: ".curl_error($curl);
    } else {
	curl_close($curl);
		return $data;
	}
	}
    
function curl_post($url,$postdata,$cookie2,$UserAgent2){
  $header = array(
       'Accept: */*',
       'Accept-Language: zh-cn',
       'Referer: '.$url,
       'User-Agent: '.$UserAgent2,
       'Content-Type: application/x-www-form-urlencoded'
    );
        $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt ($curl, CURLOPT_HTTPHEADER , $header);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent2);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    if($cookie2<>null){
    curl_setopt($curl, CURLOPT_COOKIE, $cookie2);
    }
    $data = curl_exec($curl);
    if (curl_error($curl)) {
        return "Error: ".curl_error($curl);
    } else {
	curl_close($curl);
		return $data;
	}
	}


function getSubstr($str, $leftStr, $rightStr) 
{
if($leftStr<>null && $rightStr<>null){
$left = strpos($str, $leftStr);
$right = strpos($str, $rightStr,$left+strlen($leftStr));
if($left < 0 or $right < $left){
return '';
}
return substr($str, $left + strlen($leftStr),$right-$left-strlen($leftStr));
}else{
$str2=$str;
if($leftStr<>null){
$str2=str_replace($leftStr,'',$str2);
}
if($rightStr<>null){
$str2=str_replace($rightStr,'',$str2);
}
return $str2;
}
}

function replacestr($str2){
$test2=$str2;
$test2=str_replace("	","",$test2);
$test2=str_replace(" ","",$test2);
$test2 = preg_replace('/\s*/', '', $test2);
return $test2;
}
?>