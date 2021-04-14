<?php

include 'AES.php';

$md5Key = 'ThisIsAMd5Key';                              // 对应服务端：$md5key = 'ThisIsAMd5Key';
$aesKey = AES::strToHex('1qa2ws4rf3edzxcv');      // 对应服务端：$aesKey = '3171613277733472663365647A786376';
$aesKey = AES::hex2bin($aesKey);
$aesIV  = AES::strToHex('dfg452ws');              // 对应服务端：$aesIV = '6466673435327773';
$aes = new AES($aesKey,$aesIV,array('PKCS7'=>true, 'mode'=>'cbc'));

// var_dump($aes);

$data['name'] = 'idoubi';
$data['sex']= 'male';
$data['age'] = 23;
$data['signature'] = '白天我是一个程序员，晚上我就是一个有梦想的演员。';

$content = base64_encode($aes->encrypt(json_encode($data)));
$content = urlencode($content);
$sign = md5($content.$md5Key);

$url = 'http://localhost/aesdemo/api.php';
$params = "version=1.0&sign=$sign&content=$content";

// 请求接口
post($url, $params);

/**
 * 接口请求函数
 */
function post($url, $params) {
    $curlPost= $params;
    $ch = curl_init();      //初始化curl
    curl_setopt($ch, CURLOPT_URL, $url);    //提交到指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);    //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);    //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $result = curl_exec($ch);//运行curl
    curl_close($ch);
    var_dump(json_decode($result, true));
}