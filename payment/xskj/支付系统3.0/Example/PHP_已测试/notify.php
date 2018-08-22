<?PHP
/* *
 * 功能：支付回调文件
 * 版本：1.0
 * 日期：2015-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
 
	require_once("pay.Config.php");
	require_once("lib/doPay.class.php");
	//接收参数
	$data="";
	$data['apiName']=$_POST['apiName'];
	$data['notifyTime']=$_POST['notifyTime'];
	$data['merchNo']=$_POST['merchNo'];
	$data['merchParam']=$_POST['merchParam'];
	$data['orderNo']=$_POST['orderNo'];
	$data['tradeDate']=$_POST['tradeDate'];
	$data['tradeAmt']=$_POST['tradeAmt'];
	$data['accNo']=$_POST['accNo'];
	$data['orderStatus']=$_POST['orderStatus'];
	$sign=$_POST['signMsg'];
	
	//
	$string="apiName=".$data['apiName']
		."&tradeAmt=".$data['tradeAmt']		
		."&merchNo=".$data['merchNo']
		."&orderNo=".$data['orderNo']
		."&tradeDate=".$data['tradeDate']
		."&accNo=".$data['accNo']
		."&orderStatus=".$data['orderStatus']
		.$key;
	//			                               ///共8个数据参加签名
	$signstr=md5($string);
	
	if($signstr == $sign && $data['orderStatus']==1){
		//处理业务逻辑
		
		
		echo 'success';
		
	}else{
		
		echo "签名错误或支付失败";
	}

?>