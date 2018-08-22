<?php
require_once 'Request.BaseData.php';

/**
 * 支付请求参数类
 * @author Administrator
 *
 */
class PayRequest extends RequestBaseData{
	
	/**
	 * 商户号
	 * 由易票联统一分配的商户号
	 */
	public function setPartner($value){
		$this->values["partner"] = $value;
	}
	/**
	 * 商户号
	 * 由易票联统一分配的商户号
	 */
	public function getPartner(){
		return $this->values["partner"];
	}
	/**
	 * 商户系统订单号
	 * 商户系统生成的唯一订单号。
	 * 仅可以使用大小写英文字符、数字、下划线、中划线组成
	 * （易票联根据商户编码和这个订单号，保证其在网关系统的订单唯一性）
	 * @param unknown $value
	 */
	public function setOutTradeNo($value){
		$this -> values["out_trade_no"] = $value;
	}
	/**
	 * 商户系统订单号
	 * 商户系统生成的唯一订单号。
	 * 仅可以使用大小写英文字符、数字、下划线、中划线组成
	 * （易票联根据商户编码和这个订单号，保证其在网关系统的订单唯一性）
	 * @param unknown $value
	 */
	public function getOutTradeNo(){
		return $this->values["out_trade_no"];
	}
	/**
	 * 订单金额
	 * 格式：元.角分 单位：元 ,最大8位整数，2位小数
	 */
	public function setTotalFee($value){
		$this->values["total_fee"]=$value;
	}
	/**
	 * 订单金额
	 * 格式：元.角分 单位：元 ,最大8位整数，2位小数
	 */
	public function getTotalFee(){
		return $this->values["total_fee"];
	}
	/**
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function setCurrencyType($value){
		$this->values["currency_type"] = $value;
	}
	/**
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function getCurrencyType(){
		return $this->values["currency_type"];
	}
	/**
	 * 即时通知URL
	 * 支付结果页面跳转到即时通知URL
	 * @param unknown $value
	 */
	public function setReturnUrl($value){
		$this->values["return_url"] = $value;
	}
	/**
	 * 即时通知URL
	 * 支付结果页面跳转到即时通知URL
	 * @param unknown $value
	 */
	public function getReturnUrl(){
		return $this->values["return_url"];
	}
	/**
	 * 异步通知
	 * 支付结果异步通知到接受者URL
	 * @param unknown $value
	 */
	public function setNotifyUrl($value) {
		$this->values["notify_url"] = $value;
	}
	/**
	 * 异步通知
	 * 支付结果异步通知到接受者URL
	 * @param unknown $value
	 */
	public function getNotifyUrl() {
		return $this->values["notify_url"];
	}
	/**
	 * 订单创建IP
	 * 订单生成的机器IP，指用户浏览器端IP，不是商户服务器IP
	 * @param unknown $value
	 */
	public function setOrderCreateIp($value){
		$this->values["order_create_ip"] = $value;
	}
	/**
	 * 订单创建IP
	 * 订单生成的机器IP，指用户浏览器端IP，不是商户服务器IP
	 * @param unknown $value
	 */
	public function getOrderCreateIp() {
		return $this->values["order_create_ip"];
	}
	/**
	 * 银行直连参数
	 * 设置后支付页面自动到银行付款页面
	 * @param unknown $value
	 */
	public function setPayId($value) {
		$this->values["pay_id"] = $value;
	}
	/**
	 * 银行直连参数
	 * 设置后支付页面自动到银行付款页面
	 * @param unknown $value
	 */
	public function getPayId(){
		return $this->values["pay_id"];
	}
	/**
	 * 商品名称
	 * （需要进行base64编码，以gbk方式进行base64编码）
	 * @param unknown $value
	 */
	public function setBase64Memo($value){
		$this->values["base64_memo"] = $value;
	}
	/**
	 * 商品名称
	 * （需要进行base64编码，以gbk方式进行base64编码）
	 * @param unknown $value
	 */
	public function getBase64Memo(){
		return $this->values["base64_memo"];
	}
	/**
	 * 签名类型
	 * 目前只支持SHA256算法，默认为SHA256
	 * @param unknown $value
	 */
	public function setSignType($value){
		$this->values["sign_type"] = $value;
	}
	/**
	 * 签名类型
	 * 目前只支持SHA256算法，默认为SHA256
	 * @param unknown $value
	 */
	public function getSignType(){
		return $this->values["sign_type"];
	}
	/**
	 * 网关类型
	 * 支付接口收单类型，分web网页版和手机wap版
	 * 0：网页版  1：手机版
	 * @param unknown $value
	 */
	public function setStoreOiType($value) {
		$this->values["store_oi_type"] = $value;
	}
	/**
	 * 网关类型
	 * 支付接口收单类型，分web网页版和手机wap版
	 * 0：网页版  1：手机版
	 * @param unknown $value
	 */
	public function getStoreOiType(){
		return $this->values["store_oi_type"];
	}

	/**
	 * 附加业务类型
	 * 00：普通支付网关业务
	 * 01：跨境电商业务
	 * 默认为00
	 * 备注：如果需要做跨境电商的上报支付凭证给海关的
	 * 该字段一定要填写为01
	 * @param unknown $value
	 */
	public function setSubmissionType($value){
		$this->values["submission_type"] = $value;
	}
	/**
	 * 附加业务类型
	 * 00：普通支付网关业务
	 * 01：跨境电商业务
	 * 默认为00
	 * 备注：如果需要做跨境电商的上报支付凭证给海关的
	 * 该字段一定要填写为01
	 * @param unknown $value
	 */
	public function getSubmissionType(){
		return $this->values["submission_type"];
	}
	/**
	 * 支付货款
	 * 格式：元.角分,单位：元
	 * @param unknown $value
	 */
	public function setGoodsAmount($value){
		$this->values["goods_amount"] = $value;
	}
	/**
	 * 支付货款
	 * 格式：元.角分,单位：元
	 * @param unknown $value
	 */
	public function getGoodsAmount(){
		return $this->values["goods_amount"];
	}
	/**
	 * 支付货款货币代码
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function setGoodsAmountCurr($value){
		$this->values["goods_amount_curr"] = $value;
	}
	/**
	 * 支付货款货币代码
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function getGoodsAmountCurr($value){
		return $this->values["goods_amount_curr"];
	}
	/**
	 * 支付税款
	 * 格式：元.角分,单位：元
	 * @param unknown $value
	 */
	public function setTaxAmount($value){
		$this->values["tax_amount"] = $value;
	}
	/**
	 * 支付税款
	 * 格式：元.角分,单位：元
	 * @param unknown $value
	 */
	public function getTaxAmount(){
		return $this->values["tax_amount"];
	}
	/**
	 * 支付税款货币代码
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function setTaxAmountCurr($value){
		$this->values["tax_amount_curr"] = $value;
	}
	/**
	 * 支付税款货币代码
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function getTaxAmountCurr(){
		return $this->values["tax_amount_curr"];
	}
	/**
	 * 支付运费
	 * 格式：元.角分,单位：元
	 * @param unknown $value
	 */
	public function setFreight($value){
		$this->values["freight"] = $value;
	}
	/**
	 * 支付运费
	 * 格式：元.角分,单位：元
	 * @param unknown $value
	 */
	public function getFreight(){
		return $this->values["freight"];
	}
	/**
	 * 支付运费货币代码
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function setFreightCurr($value){
		$this->values["freight_curr"] = $value;
	}
	/**
	 * 支付运费货币代码
	 * 货币代码
	 * 人民币：RMB
	 * 港币：HKD
	 * 美元：USD
	 * @param unknown $value
	 */
	public function getFreightCurr(){
		return $this->values["freight"];
	}
	
	public function setBase64UserInfo($value){
		$this->values["base64_user_info"] = $value;
	}
	
	public function getBase64UserInfo(){
		return $this->values["base64_user_info"];
	}
}

?>