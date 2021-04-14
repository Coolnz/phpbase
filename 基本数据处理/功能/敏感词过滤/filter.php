<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-13
 * Time: 14:37
 */

namespace JeffcottLu\ApiSensitiveFilter;

class SensitiveFilter
{
	function sensitiveWordFilter($str)
	{
		// $words = getSensitiveWords();
		$words = ['fuck', '傻逼', 'bitch啊'];   // 建议从文件或者缓存中读取敏感词列表，英文约定小写
		$flag = false;

		// 提取中文部分，防止其中夹杂英语等
		preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $str, $match);
		$chineseStr = implode('', $match[0]);
		$englishStr = strtolower(preg_replace("/[^A-Za-z0-9\.\-]/", " ", $str));

		$flag_arr = array('？', '！', '￥', '（', '）', '：' , '‘' , '’', '“', '”', '《' , '》', '，',
			'…', '。', '、', 'nbsp', '】', '【' ,'～', '#', '$', '^', '%', '@', '!', '*', '-'. '_', '+', '=');
		$contentFilter = preg_replace(
			'/\s/', '',
			preg_replace("/[[:punct:]]/", '',
				strip_tags(html_entity_decode(str_replace($flag_arr, '', $str), ENT_QUOTES, 'UTF-8'))));

		// 全匹配过滤,去除特殊字符后过滤中文及提取中文部分
		//todo 这东西没必要转成array_map()
		foreach ($words as $word) {
			// 判断是否包含敏感词,可以减少这里的判断来降低过滤级别，
			if (strpos($str, $word) !== false
				|| strpos($contentFilter, $word) !== false
				|| strpos($chineseStr, $word) !== false
				|| strpos($englishStr, $word) !== false) {
				return '敏感词:' . $word;
			}
		}

		return $flag ? 'yes' : 'no';
	}
}

$ss = new SensitiveFilter();
var_dump($ss->sensitiveWordFilter('傻逼啊'));
