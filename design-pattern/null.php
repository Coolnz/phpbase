<?php
////测试类
//class Person{
//	public function code(){
//		echo 'code makes me happy'.PHP_EOL;
//	}
//}
//
//
//class NullObject{
//
//	public function __call($name, $arguments)
//	{
//		// TODO: Implement __call() method.
//		echo "invalid arguments. ($arguments) function--- $name";
//	}
//
//}
//
//
////定义一个生成对象函数，只有PHPer才允许生成对象
//function getPerson($name){
//	if($name=='PHPer'){
//		return new Person;
//	} else {
//		return new NullObject();
//	}
//}
//
////$phper = getPerson('PHPer');
//$phper = getPerson('PHP');
//$phper->code();

interface LoggerInterface
{
    public function log(string $str);
}

class PrintLogger implements LoggerInterface
{
    public function log(string $str)
    {
        // TODO: Implement log() method.
    }
}

class NullLogger implements LoggerInterface
{
    public function log(string $str)
    {
        // TODO: Implement log() method.
    }
}

class Service
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function doSomething()
    {
        $this->logger->log('we are in' . __METHOD__);
    }
}

$dd = new Service(new NullLogger());
echo $dd->doSomething('ddddddd');
