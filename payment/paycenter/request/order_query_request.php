<?php

require_once 'Request.BaseData.php';

/**
 * 订单查询请求参数封装
 * @author Administrator
 *
 */
class OrderQueryRequest extends RequestBaseData{
	/**
	 * 交易类型
	 * 退款的交易类型代码，固定为：query
	 * @param unknown $value
	 */
	public function setTransType($value){
		$this->values["trans_type"] = $value;
	}
	/**
	 * 交易类型
	 * 退款的交易类型代码，固定为：query
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
	 * 签名类型
	 * 目前只支持SHA256算法
	 * @param unknown $value
	 */
	public function setSignType($value){
		$this->values["sign_type"] = $value;
	}
	/**
	 * 签名类型
	 * 目前只支持SHA256算法
	 * @param unknown $value
	 */
	public function getSignType(){
		return $this->values["sign_type"];
	}
	/**
	 * 商户系统订单号
	 * 支付网关通过商户编码和这个订单号，
	 * 保证网关系统的订单唯一性
	 * @param unknown $value
	 */
	public function setOutTradeNo($value){
		$this->values["out_trade_no"] = $value;
	}
	/**
	 * 商户系统订单号
	 * 支付网关通过商户编码和这个订单号，
	 * 保证网关系统的订单唯一性
	 * @param unknown $value
	 */
	public function getOutTradeNo(){
		return $this->values["out_trade_no"];
	}
}

?>