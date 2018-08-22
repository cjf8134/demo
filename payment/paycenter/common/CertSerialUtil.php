<?php
class CertSerialUtil {

	private static function bytesToInteger($bytes) {
		$val = 0;
		for($i = 0; $i < count ( $bytes ); $i ++) {
			// 			$val += (($bytes [$i] & 0xff) << (8 * (count ( $bytes ) - 1 - $i)));
			$val += $bytes [$i] * pow(256, count ( $bytes ) - 1 - $i);
			// 			echo $val . "<br>\n";
		}
		return $val;
	}

	private static function bytesToBigInteger($bytes) {
		$val = 0;
		for($i = 0; $i < count ( $bytes ); $i ++) {
			$val = bcadd($val, bcmul($bytes [$i], bcpow(256, count ( $bytes ) - 1 - $i)));
			// 			echo $val . "<br>\n";
		}
		return $val;
	}

	private static function toStr($bytes) {
		$str = '';
		foreach($bytes as $ch) {
			$str .= chr($ch);
		}
		return $str;
	}

	public static function getSerial($fileData, &$errMsg) {

		// 		$fileData = str_replace('\n','',$fileData);
		// 		$fileData = str_replace('\r','',$fileData);

		$start = "-----BEGIN CERTIFICATE-----";
		$end = "-----END CERTIFICATE-----";
		$data = trim ( $fileData );
		if (substr ( $data, 0, strlen ( $start ) ) != $start ||
				substr ( $data, strlen ( $data ) - strlen ( $end ) ) != $end) {
					// echo $fileData;
					$errMsg = "error pem data";
					return false;
				}

				$data = substr ( $data, strlen ( $start ), strlen ( $data ) - strlen ( $end ) - strlen ( $start ) );
				$bindata = base64_decode ( $data );
				$bindata = unpack ( 'C*', $bindata );

				$byte = array_shift ( $bindata );
				if ($byte != 0x30) {
					$errMsg = "1st tag " . $byte . " is not 30";
					return false;
				}

				$length = CertSerialUtil::readLength ( $bindata );
				$byte = array_shift ( $bindata );
				if ($byte != 0x30) {
					$errMsg = "2nd tag " . $byte . " is not 30";
					return false;
				}

				$length = CertSerialUtil::readLength ( $bindata );
				$byte = array_shift ( $bindata );
				// 		echo $byte . "<br>\n";
				if ($byte == 0xa0) { //version tag.
					$length = CertSerialUtil::readLength ( $bindata );
					CertSerialUtil::readData ( $bindata, $length );
					$byte = array_shift ( $bindata );
				}

				// 		echo $byte . "<br>\n";
				if ($byte != 0x02) { //x509v1 has no version tag, x509v3 has.
					$errMsg = "4th/3rd tag " . $byte . " is not 02";
					return false;
				}
				$length = CertSerialUtil::readLength ( $bindata );
				$serial = CertSerialUtil::readData ( $bindata, $length );
				// 		echo bin2hex(CertSerialUtil::toStr( $serial ));
				return CertSerialUtil::bytesToBigInteger($serial);
	}

	private static function readLength(&$bindata) {
		$byte = array_shift ( $bindata );
		if ($byte < 0x80) {
			$length = $byte;
		} else {
			$lenOfLength = $byte - 0x80;
			for($i = 0; $i < $lenOfLength; $i ++) {
				$lenBytes [] = array_shift ( $bindata );
			}
			$length = CertSerialUtil::bytesToInteger ( $lenBytes );
		}
		return $length;
	}

	private static function readData(&$bindata, $length) {
		$data = array ();
		for($i = 0; $i < $length; $i ++) {
			$data [] = array_shift ( $bindata );
		}
		return $data;
	}
}


