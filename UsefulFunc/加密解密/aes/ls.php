<?php

include 'AES.php';

$data = $_POST;  // 接口请求得到的数据
$content = $data['content'];
$sign = $data['sign'];

$aesKey = '3171613277733472663365647A786376';
$aesIV = '6466673435327773';
$md5key = 'ThisIsAMd5Key';

// 校验数据
if (0 == strcasecmp(md5(urlencode($content) . $md5key), $sign)) {
    // 数据校验成功
    $key = AES::hex2bin($aesKey);
    $aes = new AES($key, $aesIV, ['PKCS7' => true, 'mode' => 'cbc']);

    $decrypt = $aes->decrypt(base64_decode($content));
    if (!$decrypt) {      // 解密失败
        echo json_encode('can not decrypt the data');
    } else {
        echo json_encode($decrypt);     // 解密成功
    }
} else {
    echo json_encode('data is not integrity');       // 数据校验失败
}
