<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-01-10
 * Time: 13:26
 */
namespace Packages\Factory;

//工厂模式的接口类；
interface ChoiceInterface
{
	public function choice();
}

class ChoiceOne implements ChoiceInterface
{
	public function choice()
	{
		// TODO: Implement choice() method.
		return '选择1';
	}
}

class ChoiceTwo implements ChoiceInterface
{
	public function choice()
	{
		// TODO: Implement choice() method.
		return '选择2';
	}
}

$choice = new ChoiceOne();