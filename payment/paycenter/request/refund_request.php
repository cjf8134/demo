<?php
require_once 'Request.BaseData.php';

/**
 * 退款请求参数类
 * @author Administrator
 *
 */
class RefundRequest extends RequestBaseData{
	/**
	 * 交易类型
	 * 退款的交易类型代码固定为refundQuery
	 * @param unknown $value
	 */
	public function setTransType($value){
		$this->values["trans_type"] = $value;
	}
	/**
	 * 交易类型
	 * 退款的交易类型代码固定为refundQuery
	 * @param unknown $value
	 */
	public function getTransType(){
		return $this->values["trans_type"];
	}
	/**
	 * 商户号
	 * 由易票联统一分配的商户号
	 * @param unknown $value
	 */
	public function setPartner($value){
		$this->values["partner"] = $value;
	}
	/**
	 * 商户号
	 * 由易票联统一分配的商户号
	 * @param unknown $value
	 */
	public function getPartner(){
		return $this->values["partner"];
	}
	/**
	 * 商户系统订单号
	 * 退款单对应的商家系统支付订单号
	 * @param unknown $value
	 */
	public function setOutTradeNo($value) {
		$this->values["out_trade_no"] = $value;
	}
	/**
	 * 商户系统订单号
	 * 退款单对应的商家系统支付订单号
	 * @param unknown $value
	 */
	public function getOutTradeNo(){
		return $this->values["out_trade_no"];
	}
	/**
	 * 商户系统退款单号
	 * 商户系统生成的退款单号。
	 * 仅可以使用大小写英文字符、数字、下划线、中划线组成。
	 * （易票联根据商户编码和这个退款单号，保证其在网关系统的退款单唯一性）
	 * @param unknown $value
	 */
	public function setOutRefundNo($value) {
		$this->values["out_refund_no"] = $value;
	}
	/**
	 * 商户系统退款单号
	 * 商户系统生成的退款单号。
	 * 仅可以使用大小写英文字符、数字、下划线、中划线组成。
	 * （易票联根据商户编码和这个退款单号，保证其在网关系统的退款单唯一性）
	 * @param unknown $value
	 */
	public function getOutRefundNo(){
		return $this->values["out_refund_no"];
	}
	/**
	 * 订单总额
	 * 格式：元.角分 单位：元
	 * @param unknown $value
	 */
	public function setTotalAmount($value){
		$this->values["total_amount"] = $value;
	}
	/**
	 * 订单总额
	 * 格式：元.角分 单位：元
	 * @param unknown $value
	 */
	public function getTotalAmount() {
		return $this->values["total_amount"];
	}
	/**
	 * 退款金额
	 * 格式：元.角分 单位：元
	 * 可以做部分退款，累计退款总金额不能超过订单总金额
	 * @param unknown $value
	 */
	public function setRefundAmount($value){
		$this->values["refund_amount"] = $value;
	}
	/**
	 * 退款金额
	 * 格式：元.角分 单位：元
	 * 可以做部分退款，累计退款总金额不能超过订单总金额
	 * @param unknown $value
	 */
	public function getRefundAmount(){
		return $this->values["refund_amount"];
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
}
?>