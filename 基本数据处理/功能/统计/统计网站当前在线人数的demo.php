<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-14
 * Time: 07:26
 */
/**
 * 写在最前；
 * 这里给出了4个统计网站当前在线人数的demo，从易到难；
 * 分别是，使用IP，使用cookie，使用redis的有序集合，使用redis的bitmap四种方法；仅供参考；
 */



/**
 * 通过访问者的IP，统计该页面的在线人数；（不是该网站的）
 * 用getenv()抓ip来统计，保存数据用的文件；
 * 保存数据的driver当然也可以换成mysql；
 *
 * 必须要刷新页面，也就是说用户每登录一个网页，都必须访问一次这个方法；这样的效率是很低的；比较好的做法，是
 */
function statisticByIpAndLog($timeout = '1800')
{
	$filename = createLogFile();
	$temp = [];
	// 以数组的形式将用户ip和time取出来array([0]=>'192.168.xx.xx,1516242630', [1]=>...)
	$onlines = file($filename);

	//
	for ($i=0; $i<count($onlines); $i++) {
		//将用户IP和时间分隔开
		$online = explode(',', trim($onlines[$i]));
		// 过滤文件中其他的浏览者：前面!=是其他的浏览者，和当前的ip（自己）不一样，过滤掉超时的其他ip
		if ($online[0] != $_SERVER['REMOTE_ADDR']
			&& $online[1] > time() ) {
			array_push($temp, $online[0] . ',' . $online[1]);
		}
	}

	// 更新当前的ip（自己）时间
	array_push($temp, $_SERVER['REMOTE_ADDR'] . ',' . (time()+$timeout));

	// 更新在线人数的文件
	$onlines = implode("\n", $temp);
	$fp = fopen($filename, 'w');
	fputs($fp, $onlines);
	fclose($fp);

	return "当前在线人数" . count($temp);

}

/**
 * 创建文件，并返回文件名；
 * 根据调用这个方法的方法的方法名，作为文件名；
 */
function createLogFile()
{
	$filename = __FUNCTION__. '.log';
	if (!file_exists($filename)) {
		touch($filename);
	}
	return $filename;
}

/*
  @ PHP 在线人数统计程序
  Copyright (c) www.vgot.cn by Pader 1:25 2009年1月7日
  How to use it: <script src="online.php"></script>
  note: 一般独立在线人数统计程序都是统计在线的IP数，而这并不准确
  例如局域网的访问者，比如公司，学校机房和网吧，虽然内网IP不同，但是外网IP都是一样；
  如果同一个局域网的无论多少人人访问你的网站则只被认为是一个人
  这个小巧的程序解决了此问题，它以电脑为单为，每台电脑便算一个访问者
  当然因为使用的是COOKIE，如果你在同一台电脑上使用两种不同核心的浏览器访问那就别当别论了

	这种方法相比于只是用IP，引入了cookie来更精确地统计在线人数；

*	@param $timeout 在线有效时间；单位：秒；

*/
function statisticByCookieAndLog($timeout = '1800')
{
	$filename = createLogFile();

	$cookiename = 'VGOTCN_OnLineCount'; //cookie名称
	$online = file($filename);
	$nowtime = time();
	$nowonline = array();



	/*
	  @ 得到仍然有效的数据
	*/
	foreach($online as $line) {
		$row = explode('|',$line);
		$sesstime = trim($row[1]);
		if(($nowtime - $sesstime) <= $timeout) { //如果仍在有效时间内，则数据继续保存，否则被放弃不再统计
			$nowonline[$row[0]] = $sesstime; //获取在线列表到数组，会话ID为键名，最后通信时间为键值
		}
	}

	/*
	  @ 创建访问者通信状态
		使用cookie通信
		COOKIE 将在关闭浏览器时失效，但如果不关闭浏览器，此 COOKIE 将一直有效，直到程序设置的在线时间超时
	*/
	if (isset($_COOKIE[$cookiename])) { //如果有COOKIE即并非初次访问则不添加人数并更新通信时间
		$uid = $_COOKIE[$cookiename];
	} else { //如果没有COOKIE即是初次访问
		$vid = 0; //初始化访问者ID
		//给用户一个新ID
		do {
			$vid++;
			$uid = 'U'.$vid;
		} while (
			array_key_exists($uid,$nowonline)
		);
		setcookie($cookiename,$uid);
	}

//更新现在的时间状态
	$nowonline[$uid] = $nowtime;
	/*
	  @ 统计现在在线人数
	*/
	$total_online = count($nowonline);
	/*
	  @ 写入数据
	*/
	if($fp = @fopen($filename,'w')) {
		if(flock($fp,LOCK_EX)) {
			rewind($fp);
			foreach($nowonline as $fuid => $ftime) {
				$fline = $fuid.'|'.$ftime."\n";
				@fputs($fp,$fline);
			}
			flock($fp,LOCK_UN);
			fclose($fp);
		}
	}
	return "当前在线人数". $total_online;
}

//createLogFile();
//var_dump(statisticByIpAndLog());
var_dump(statisticByCookieAndLog());


/**
 * 使用redis的bitmap来实现统计网站当前在线人数；
 */
function statisticByRedisBitMap()
{
	$redis = new Redis();
// 用户ID
	$id = 1;
// 在线失效时间，即10分钟后用户没有任何操作，表示不在线了
	$time = 10*60;
// 保存用户在线记录，以分钟为单位
	$bitmap = 'online_'.date("Hi");
//var_dump($bitmap);die;

	$redis->setBit($bitmap,$id,1);
// 设置失效时间
	$redis->setTimeout($bitmap,$time);

	$bitop_param[] = 'or';
	$bitop_param[] = 'online';
// 统计2分钟内在线人数，也可是设置为4,5分钟等
	for($i = 0;$i < 2;$i++){
		$bitop_param[] = 'online_'.date('Hi',time()-60*$i);
	} // 利用bitOp将多个在线记录的bitmap合并成一个，并保存到临时的bitmap中 call_user_func_array([$redis, "bitOp"], $bitop_param);

// 统计总的用户在线记录 $online = $redis->bitCount($bitop_param[1]);
// 删除临时统计的bitmap
	$redis->delete($bitop_param[1]);
}





/**
 *
 * 用redis的有序集合set来实现的统计网站当前在线人数；
 *
 */
function statisticByRedisSet()
{
	define('ONLINE_MINUTES', 3);
	$redis = new Redis();
	$redis->connect('localhost', 6379) OR die("Unable to connect to Redis");
//用ip来定义用户，也可以根据需求用session或者cookie来。
	$remote_ip = $_SERVER["REMOTE_ADDR"];
//通过redis
	setOnline($remote_ip);

//在线用户数（处理数据）
	$online_users = getAllOnline();
	var_dump($online_users);
//统计用户个数
	$online_users_num = count($online_users);
	echo "Online Users: ".$online_users_num;
}

function setOnline($id){
	global $redis;
	$now = time();
	//取当前的时间戳，截取到分钟部分，作为当前1分钟的key
	$now_min = floor($now/60);
	//设置有效的截止时间的时间戳
	$expire_timestamp = $now + ONLINE_MINUTES * 60 + 10;
	//设置当前这1分钟的在线用户组的key
	$min_users_key = 'online-users:'.$now_min;
	//设置当前用户的key
	$user_key = 'user-activity:'.$id;
	//phpredis的pipeline
	$pipe = $redis->multi(Redis::PIPELINE);
	//添加当前用户到当前1分钟的在线用户组中
	$pipe->sadd($min_users_key, $id);
	//更新当前用户的最后活动时间
	$pipe->set($user_key, $now);
	//设置过期时间
	$pipe->expireat($min_users_key, $expire_timestamp);
	$pipe->expireat($user_key, $expire_timestamp);
	//pipeline统一执行
	$replies = $pipe->exec();
}


/**
 * @return array
 */
function getAllOnline(){
	global $redis;
	$now = time();
	//取当前的时间戳，截取到分钟部分，作为当前1分钟的key
	$now_min = floor($now/60);
	//求N分钟内N个在线用户组的set的并集，结果就是N分钟内所有在线用户
	$set_keys_arr = array();
	for ($i = 0; $i <= ONLINE_MINUTES; $i++){
		$set_keys_arr[] = 'online-users:'.($now_min-$i);
	}
	$result = $redis->sunion($set_keys_arr);
	return $result;
}