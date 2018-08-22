<?php

//验签方法
function publicSing($comid,$comkey,$data,$sign){
    $params_str=createLinkString($data,true,false);
    $newsign = md5($comid.$comkey.$params_str);
    if($newsign == $sign){
        return 'SUCCESS';
    }else{
        return 'FAIL';
    }
    
}

/**
 * 讲数组转换为string
 *
 * @param $para 数组
 * @param $sort 是否需要排序
 * @param $encode 是否需要URL编码
 * @return string
 */
function createLinkString($para, $sort, $encode) {
    if($para == NULL || !is_array($para))
        return "";

    $linkString = "";
    if ($sort) {
        ksort( $para );
    }

    while ( list ( $key, $value ) = each ( $para ) ) {
        if ($encode) {
            $value = urlencode ( $value );
        }
        $linkString .= $key . "=" . $value . "&";
    }
    // 去掉最后一个&字符
    $linkString = substr ( $linkString, 0, count ( $linkString ) - 2 );

    return $linkString;
}

//拼接字符串
function linkString($para,$sort=true,$encode=true){
    if($para == NULL || !is_array($para))
        return "";

    $linkString = "";
    if ($sort) {
        ksort ( $para );
    }
    while ( list ( $key, $value ) = each ( $para ) ) {
        if($value!=''){
            if ($encode) {
                $value = urlencode ( $value );
            }
            $linkString .= $key . "=" . $value . "&";
        }
    }
    // 去掉最后一个&字符
    $linkString = substr ( $linkString, 0, count ( $linkString ) - 2 );

    return $linkString;

}

function httpClient($data, $url) 
{
		$postdata = http_build_query($data);
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			$res = curl_exec($ch);
			curl_close($ch);
			return $res;
		} catch (Exception $e) {
			$errorMsg = $e->getMessage();
			return false;
		}
}

function request_form($data=array(),$url='') {
	
	if (count($data) > 0) {
		$string = "<form style='display:none;' id='form1' name='form1' method='post' action='" . $url . "'>";
		foreach ($data as $key => $value) {
			if (!isset($value) || is_null($value) || empty($value)) {
				unset($data[$key]);
				continue;
			} else {
				$string .= "<input name='" . $key . "' type='text' value='" . $value . "' />";
			}
		}
		$string .= "</form>";
		$string .= "<script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";
		echo $string;
	}
}

function logResult($word='') {
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

?>