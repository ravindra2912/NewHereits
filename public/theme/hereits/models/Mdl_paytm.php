<?php
class Mdl_paytm extends CI_Model{	function __construct()	{		parent::__construct();     	}
	
//function Paytm Data Start
	
	function PAYTM_ENVIRONMENT()
	{
		

		
		//get payment info
		$this->db->select('*');
		$this->db->where('payment_method','paytm');
		$this->db->from('payment_methods');
		$paytm_info =  $this->db->get()->row(); 
		if($paytm_info->live == 1){ //for live
			define('PAYTM_ENVIRONMENT', 'PROD'); // PROD TEST
			define('PAYTM_MERCHANT_KEY', $paytm_info->payment_key); //Change this constant's value with Merchant key received from Paytm.
			define('PAYTM_MERCHANT_MID', $paytm_info->payment_id); //Change this constant's value with MID (Merchant ID) received from Paytm.
			define('PAYTM_MERCHANT_WEBSITE', 'xxxxxxx'); //Change this constant's value with Website name received from Paytm.
		}else{ //for test
			define('PAYTM_ENVIRONMENT', 'TEST'); // PROD TEST
			define('PAYTM_MERCHANT_KEY', $paytm_info->test_payment_key); //Change this constant's value with Merchant key received from Paytm.
			define('PAYTM_MERCHANT_MID', $paytm_info->test_payment_id); //Change this constant's value with MID (Merchant ID) received from Paytm.
			define('PAYTM_MERCHANT_WEBSITE', 'xxxxxxx'); //Change this constant's value with Website name received from Paytm.
		}
		
		
		

		$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
		$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
		if (PAYTM_ENVIRONMENT == 'PROD') {
			$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
			$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
		}

		define('PAYTM_REFUND_URL', '');
		define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
	}
	
	function encrypt_e($input, $ky) {
		$key   = html_entity_decode($ky);
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
		return $data;
	}

	function decrypt_e($crypt, $ky) {
		$key   = html_entity_decode($ky);
		$iv = "@@@@&&&&####$$$$";
		$data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
		return $data;
	}

	function generateSalt_e($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
		$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
		$data .= "0FGH45OP89";

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	function checkString_e($value) {
		if ($value == 'null')
			$value = '';
		return $value;
	}

	function getChecksumFromArray($arrayList, $key, $sort=1) {
		if ($sort != 0) {
			ksort($arrayList);
		}
		$str = $this->getArray2Str($arrayList);
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}
	function getChecksumFromString($str, $key) {
		
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}

	function verifychecksum_e($arrayList, $key, $checksumvalue) {
		$arrayList = $this->removeCheckSumParam($arrayList);
		ksort($arrayList);
		$str = $this->getArray2StrForVerify($arrayList);
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	function verifychecksum_eFromStr($str, $key, $checksumvalue) {
		$paytm_hash = $this->decrypt_e($checksumvalue, $key);
		$salt = substr($paytm_hash, -4);

		$finalString = $str . "|" . $salt;

		$website_hash = hash("sha256", $finalString);
		$website_hash .= $salt;

		$validFlag = "FALSE";
		if ($website_hash == $paytm_hash) {
			$validFlag = "TRUE";
		} else {
			$validFlag = "FALSE";
		}
		return $validFlag;
	}

	function getArray2Str($arrayList) {
		$findme   = 'REFUND';
		$findmepipe = '|';
		$paramStr = "";
		$flag = 1;	
		foreach ($arrayList as $key => $value) {
			$pos = strpos($value, $findme);
			$pospipe = strpos($value, $findmepipe);
			if ($pos !== false || $pospipe !== false) 
			{
				continue;
			}
			
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	function getArray2StrForVerify($arrayList) {
		$paramStr = "";
		$flag = 1;
		foreach ($arrayList as $key => $value) {
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}

	function redirect2PG($paramList, $key) {
		$hashString = $this->getchecksumFromArray($paramList);
		$checksum = $this->encrypt_e($hashString, $key);
	}

	function removeCheckSumParam($arrayList) {
		if (isset($arrayList["CHECKSUMHASH"])) {
			unset($arrayList["CHECKSUMHASH"]);
		}
		return $arrayList;
	}

	function getTxnStatus($requestParamList) {
		return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
	}

	function getTxnStatusNew($requestParamList) {
		return $this->callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
	}

	function initiateTxnRefund($requestParamList) {
		$CHECKSUM = $this->getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
		$requestParamList["CHECKSUM"] = $CHECKSUM;
		return $this->callAPI(PAYTM_REFUND_URL, $requestParamList);
	}

	function callAPI($apiURL, $requestParamList) {
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
		'Content-Type: application/json', 
		'Content-Length: ' . strlen($postData))                                                                       
		);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}

	function callNewAPI($apiURL, $requestParamList) {
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                         
		'Content-Type: application/json', 
		'Content-Length: ' . strlen($postData))                                                                       
		);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}
	function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
		if ($sort != 0) {
			ksort($arrayList);
		}
		$str = $this->getRefundArray2Str($arrayList);
		$salt = $this->generateSalt_e(4);
		$finalString = $str . "|" . $salt;
		$hash = hash("sha256", $finalString);
		$hashString = $hash . $salt;
		$checksum = $this->encrypt_e($hashString, $key);
		return $checksum;
	}
	function getRefundArray2Str($arrayList) {	
		$findmepipe = '|';
		$paramStr = "";
		$flag = 1;	
		foreach ($arrayList as $key => $value) {		
			$pospipe = strpos($value, $findmepipe);
			if ($pospipe !== false) 
			{
				continue;
			}
			
			if ($flag) {
				$paramStr .= $this->checkString_e($value);
				$flag = 0;
			} else {
				$paramStr .= "|" . $this->checkString_e($value);
			}
		}
		return $paramStr;
	}
	function callRefundAPI($refundApiURL, $requestParamList) {
		$jsonResponse = "";
		$responseParamList = array();
		$JsonData =json_encode($requestParamList);
		$postData = 'JsonData='.urlencode($JsonData);
		$ch = curl_init($apiURL);	
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_URL, $refundApiURL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
		$jsonResponse = curl_exec($ch);   
		$responseParamList = json_decode($jsonResponse,true);
		return $responseParamList;
	}
	
	//function Paytm Data Enad
	
	
}
?>