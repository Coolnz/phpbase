<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-14
 * Time: 14:16.
 */
class Count
{
    public function kk()
    {
        $a = range(0, 9);
        for ($i = 0; $i < 16; ++$i) {
            $b[] = array_rand($a);
        }

        return join('', $b);
    }

    /**
     * 循环50次kk方法，获得50条数字字符串.
     */
    public function xhkk()
    {
        $num = $this->kk();
        //循环存储Redis中
        for ($i = 0; $i < 50; ++$i) {
            $numArr[] = $num[$i];
        }

        return $numArr;
    }
}

$obj = new Count();
echo $obj->kk();
echo $obj->xhkk();

class Company
{
    public function getCompanyInfo($company)
    {
        $cat_arr = explode(',', $company['category_list']);
        $i = 0;
        foreach ($cat_arr as $key => $val) {
            $category_name = APP::$DB->getOne('SELECT name_en FROM ' . TABLE_PREFIX . "pcat WHERE cat_id = $val");
            $product = APP::$DB->getOne('SELECT * FROM ' . TABLE_PREFIX . "product WHERE cat_id = $val ORDER BY pro_id DESC LIMIT 1");
            if (!empty($product)) {
                $prd_info[$i]['id'] = $i + 1; //id
                $prd_info[$i]['en_name'] = $product['title_en']; //$product['title_en'];//商品英文名
                $prd_info[$i]['cn_name'] = $product['title']; //$product['title'];//商品中文名
                $prd_info[$i]['en_desc'] = !empty($product['content_en']) ? $product['content_en'] : $product['title_en']; //$product['content_en'];//商品英文描述
                $prd_info[$i]['cn_desc'] = !empty($product['content']) ? $product['content'] : $product['title']; //$product['content'];//商品中文描述
                $prd_info[$i]['prod_url'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/uploads/' . $product['path'] . '/' . $product['filename'] . '_m.jpg'; //'https://test.dev.dscmall.cn/uploads/'.$product['path'].'/'. $product['filename'];//商品图片路径
                $prd_info[$i]['prod_cat'] = $category_name['name_en']; //商品分类中文
                ++$i;
            }
        }

        //发送的数据
        $post = [
            'access_token' => 'f8zd6198xu8129l3',
            'exhibitor_id' => "$company[company_id]",
            'company_name' => "$company[companyname]",
            'company_desc' => "$company[company_desc]",
            'prd_info' => $prd_info,
        ];
        $post = json_encode($post, JSON_UNESCAPED_UNICODE);
        $url = 'http://127.0.0.1:8080/create';
        $res = json_decode($this->curl_postjson($post, $url), 1);

        return $res;
    }
}
