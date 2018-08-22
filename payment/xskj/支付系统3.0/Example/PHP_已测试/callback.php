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
	$data['apiName']=$_GET['apiName'];
	$data['notifyTime']=$_GET['notifyTime'];
	$data['merchNo']=$_GET['merchNo'];
	$data['merchParam']=$_GET['merchParam'];
	$data['orderNo']=$_GET['orderNo'];
	$data['tradeDate']=$_GET['tradeDate'];
	$data['tradeAmt']=$_GET['tradeAmt'];
	$data['accNo']=$_GET['accNo'];
	$data['orderStatus']=$_GET['orderStatus'];
	$sign=$_GET['signMsg'];
	
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
		
		
		echo '支付成功';
		
	}else{
		
		echo "签名错误或支付失败";
	}

?>