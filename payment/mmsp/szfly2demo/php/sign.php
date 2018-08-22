<?php
error_reporting(E_ERROR);

if($_POST)
{
    $md = $_POST['md'];
    $key = $_POST['key'];
    $val = $_POST['val'];
    
    $body_key = $_POST['body_key'];
    $body_val = $_POST['body_val'];
    
	if(empty($key) || empty($val)|| empty($body_key) || empty($body_val))
	{
		echo json_encode(array('status'=>'0','msg'=>'提交数据错误'));
		die;
	}
	
    $arr = array();
    foreach ($key as $k=>$v)
    {
        if(!empty($v) && !empty($val[$k]))
        {
            $arr[strtoupper($v)] = $val[$k];
        }
    }
    
    foreach ($body_key as $bk=>$bv)
    {
        if(!empty($bv) && !empty($body_val[$bk]))
        {
            $arr['Body'][strtoupper($bv)] = $body_val[$bk];
        }
    }
    
    //需要签名的数据Body
    $body = $arr['Body'];
    //Body排序后的数据
    ksort($body);
    $ksort_Body = $body;
    //Body转成json后的数据
    $json_Body = json_encode($ksort_Body, JSON_UNESCAPED_UNICODE);
    //json数据拼接key后的字符串
    $key_Body = $json_Body.'&key='.$md;
    //md5后的数据
    $md5_Body = md5($key_Body);
    //转成大写的数据
    $supper_md5 = strtoupper($md5_Body);
    
    $arr['Sign'] = $supper_md5;
    
    
    echo json_encode(array('status'=>'1','body'=>var_export($body, true),'ksort_Body'=>var_export($ksort_Body, true),'json_Body'=>$json_Body,'key_Body'=>$key_Body,'supper_md5'=>var_export($supper_md5, true),'data'=>json_encode($arr)),320);
    die;
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0" />
    <title>在线签名工具</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css" />
   
</head>

<body>

<div class="ox">
    <!--支付状态-->
    <div class="state" style="padding:10px 1px 1px 1px;">
    	<span class="fail">在线签名工具</span>
    </div>
    <hr/>
    <div style="padding-left:30px; color:red; font-size:18px;"><?php echo $msg;?><br/><?php echo $img;?></div>
    <form method="post" action="sign.php" id="signform">
    <div class="state" style="margin-top:20px; padding:0px;float:left;width:50%">
    	<table width="60%" style=" border-collapse:   separate;   border-spacing:   10px;"  border="1">
    		 
    		 <tr>
            	<td align="right" width="25%" style="padding-left:10px;">密钥：</td>
                <td  align="left"><input type="text" name="md" value=""/></td>
             </tr>
             	
    		 <tr>
                <td align="left" width="25%" style="padding-left:10px;">报文头-键(大写)</td>
                <td  align="left">报文头-值</td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key[0]" value="CommandID"/></td>
                <td  align="left"><input type="text" name="val[0]" value="2309"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key[1]" value="SeqID"/></td>
                <td  align="left"><input type="text" name="val[1]" value="1"/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key[2]" value="NodeType"/></td>
                <td  align="left"><input type="text" name="val[2]" value="1"/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key[3]" value="NodeID"/></td>
                <td  align="left"><input type="text" name="val[3]" value="openplat"/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key[4]" value="Version"/></td>
                <td  align="left"><input type="text" name="val[4]" value="1.0.0"/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key[5]" value=""/></td>
                <td  align="left"><input type="text" name="val[5]" value=""/></td>
             </tr>
             
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;"><a href="javascript:addline('headeradd','h');" id="headeradd">+新加一行....</a></td>
                <td  align="left"></td>
             </tr>
             
             <tr>
                <td align="left" width="25%" style="padding-left:10px;">Body-键(大写)</td>
                <td  align="left">Body-值</td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key[0]" value="AMT"/></td>
                <td  align="left"><input type="text" name="body_val[0]" value="10"/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key[1]" value="RANDSTR"/></td>
                <td  align="left"><input type="text" name="body_val[1]" value="22334"/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key[2]" value=""/></td>
                <td  align="left"><input type="text" name="body_val[2]" value=""/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key[3]" value=""/></td>
                <td  align="left"><input type="text" name="body_val[3]" value=""/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key[4]" value=""/></td>
                <td  align="left"><input type="text" name="body_val[4]" value=""/></td>
             </tr><tr>
            	<td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key[5]" value=""/></td>
                <td  align="left"><input type="text" name="body_val[5]" value=""/></td>
             </tr>
             <tr>
            	<td align="left" width="25%" style="padding-left:10px;"><a href="javascript:addline('bodyadd','b');" id="bodyadd">+新加一行....</a></td>
                <td  align="left"></td>
             </tr>
             
             <tr>
            	<td></td>
                <td align="left" ><input type="submit" style="cursor:pointer;"  value=" 提 交 "/></td>
             </tr>
         </table>
    </div>
    </form>
    
    <div class="state" style="margin-top:20px;margin-left:20px; width:40%;text-align:left; padding:0px; float:left;">
    	<div style="width:100%; text-align:left; margin-bottom:10px;">
        	需要签名的Body数组：
        </div>
        <div style="width:100%; background:#E6E6E6; min-height:30px;word-break: break-all; word-wrap:break-word;" id="body">
        	
        </div>
        <div style="width:100%; text-align:left; margin-bottom:10px; margin-top:10px;" >
        	排序后的Body数组：
        </div>
        <div style="width:100%; background:#E6E6E6; min-height:30px;word-break: break-all; word-wrap:break-word;" id="ksort_Body">
        	
        </div>
        <div style="width:100%; text-align:left; margin-bottom:10px;margin-top:10px;">
        	Body转成json后的数据：
        </div>
        <div style="width:100%; background:#E6E6E6; min-height:30px;word-break: break-all; word-wrap:break-word;" id="json_Body">
        	
        </div>
        <div style="width:100%; text-align:left; margin-bottom:10px;margin-top:10px;">
        	json数据拼接key后的字符串：
        </div>
        <div style="width:100%; background:#E6E6E6; min-height:30px;word-break: break-all; word-wrap:break-word;" id="key_Body">
        	
        </div>
        <div style="width:100%; text-align:left; margin-bottom:10px;margin-top:10px;">
        	md5后转大写后的数据：
        </div>
        <div style="width:100%; background:#E6E6E6; min-height:30px;word-break: break-all; word-wrap:break-word;" id="supper_md5">
        	
        </div>
        <div style="width:100%; text-align:left; margin-bottom:10px;margin-top:10px;">
        	最后组成上送的报文(json格式)：
        </div>
        <div style="width:100%; background:#E6E6E6; min-height:30px;word-break: break-all; word-wrap:break-word;" id="data">
        	
        </div>
    </div>
    
</div>
</body>
<script src="./css/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="./css/jquery.form.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(e) {
	var option = { 
        beforeSubmit:  showRequest,  
        success:       showResponse,
		dataType:		'json',
	};
	$('#signform').ajaxForm(option);
});
function showRequest()
{
	
}
function showResponse(res)
{
	if(res.status == 0)
	{
		alert(res.msg);
	}else
	{
		$("#body").html(res.body);
		$("#ksort_Body").html(res.ksort_Body);
		$("#json_Body").html(res.json_Body);
		$("#key_Body").html(res.key_Body);
		$("#supper_md5").html(res.supper_md5);
		$("#data").html(res.data);
		
	}
	return false;
}
var header_cnt = 5;
var body_cnt = 5;

function addline(id, type)
{
	if(type == 'h')
	{
		header_cnt = header_cnt + 1;
		$("#"+id).parent().parent().before('<tr><td align="left" width="25%" style="padding-left:10px;"><input type="text" name="key['+header_cnt+']" value=""/></td><td  align="left"><input type="text" name="val['+header_cnt+']" value=""/></td></tr>');
		
	}else
	{
		body_cnt = body_cnt + 1;
		$("#"+id).parent().parent().before('<tr><td align="left" width="25%" style="padding-left:10px;"><input type="text" name="body_key['+body_cnt+']" value=""/></td><td  align="left"><input type="text" name="body_val['+body_cnt+']" value=""/></td></tr>');
		
	}
	
}



</script>

</html>