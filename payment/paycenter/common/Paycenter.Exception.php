<?php

/**
 * 支付业务异常类
 * @author Administrator
 *
 */
class PaycenterException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}