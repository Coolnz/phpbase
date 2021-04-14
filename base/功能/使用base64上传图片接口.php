<?php

/**
 * todo 这个是yii框架的一个上传图片接口；.
 *
 * @return mixed
 */
function actionUploadBase64Img()
{
    $type = self::IMAGES_CONFIG;
    $result = $this->setResult();

    $base64Data = $_POST['img'];
    $img = base64_decode($base64Data);
    $file_exc = '.jpg'; // 图片后缀
    if (!($file_path = $this->getPath($type))) {
        $result->message = '文件夹创建失败，请确认是否开启attachment文件夹写入权限';

        return $this->getResult();
    }

    $file_new_name = Yii::$app->params[$type]['prefix'] . StringHelper::random(10) . $file_exc; // 保存的图片名
    $filePath = Yii::getAlias('@attachment/') . $file_path . $file_new_name;
    // 移动文件
    if (!(file_put_contents($filePath, $img) && file_exists($filePath))) { // 移动失败
        $result->code = 404;
        $result->message = '上传失败';
    } else { // 移动成功
        $result->code = 200;
        $result->message = '上传成功';
        $result->data = [
            'path' => $file_path . $file_new_name,
            'urlPath' => ImageHelper::getdomain($file_path . $file_new_name),
        ];
    }

    return $this->getResult();
}

function uploadBase64Img()
{
    header('Content-type:text/html;charset=utf-8');
    $base64_image_content = $_POST['imgBase64'];

    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
        $type = $result[2];
        $new_file = 'upload/active/img/' . date('Ymd', time()) . '/';

        //检查是否有该文件夹，如果没有就创建，并给予最高权限
        if (!file_exists($new_file)) {
            mkdir($new_file, 0700);
        }
        $new_file = $new_file . time() . ".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
            echo '新文件保存成功：', $new_file;
        } else {
            echo '新文件保存失败';
        }
    }
}
