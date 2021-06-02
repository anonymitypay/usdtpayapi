<?php
	//获得回调内容
	$content = file_get_contents('php://input');
	//转为json
	$json_param = json_decode($content);
	//把sign取出来
	$oldsign = $json_param->sign;
	//组装内容 sign不参与签名
    $param=array(
		'amount'=>$json_param->amount,
		'merchantId'=>$json_param->merchantId,
		'blockNumber'=>$json_param->blockNumber,
		'from'=>$json_param->from,
		'notifyId'=>$json_param->notifyId,
		'chainType'=>$json_param->chainType,
		'to'=>$json_param->to,
		'type'=>$json_param->type,
		'nonce'=>$json_param->nonce,
		'transactionId'=>$json_param->transactionId,
		'timestamp'=>$json_param->timestamp,
	);
	//排序 
	$p = ksort($param);
	//组合成签名内容格式
	if ($p) {
		$str = '';
		foreach ($param as $k => $val) {
			$str .= $k . '=' . $val . '&';
		}
		$strs = rtrim($str, '&');
	}
	//最后加&key
	//完整的签名示例
	// amount=&blockNumber=30353922&chainType=TRX&from=TTWvC73pGXHa2rqEcMvB6VpxpZir6p3stF&merchantId=1379681731801534464&nonce=lLqsk7zMPijfHQry&notifyId=1395356165638725632&timestamp=1621513808991&to=TKupfvz3j5YTZkaTioidW3Yyn8zzjaKuxa&transactionId=0abb4ee8fbcc6c1a2f6ffdd2ced135787225343afe587fafce5ee7e2e1a7fa6f&type=monitor&key=P9MBo4O91rYQ2VvT
	$strs .='&key=P9MBo4O91rYQ2VvT';
	//对内容进行MD5 
	$sign=md5($strs);
	//把回调的sign 与MD5 签名数据对比
	if($oldsign == $sign){ 
		//对比成功返回success
		echo "success";
	}else{ 
		//失败返回fail
		echo "fail";
	} 

?>
