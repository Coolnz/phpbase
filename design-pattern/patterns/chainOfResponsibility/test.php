<?php

spl_autoload_register('autoload');

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

// test

use chainOfResponsibility\Request;
use chainOfResponsibility\HandlerSign;
use chainOfResponsibility\HandlerFrequent;
use chainOfResponsibility\HandlerArguments;
use chainOfResponsibility\HandlerAuthority;
use chainOfResponsibility\HandlerAccessToken;

try {
    // 下面我们用责任链模式实现一个api-gateway即接口网关

    // 初始化一个请求对象
    $request = new Request();
    // 设置一个请求身份id
    $request->requestId = uniqid();

    // 初始化一个：令牌校验的handler
    $handlerAccessToken = new HandlerAccessToken();
    // 初始化一个：访问频次校验的handler
    $handlerFrequent = new HandlerFrequent();
    // 初始化一个：必传参数校验的handler
    $handlerArguments = new HandlerArguments();
    // 初始化一个：签名校验的handler
    $handlerSign = new HandlerSign();
    // 初始化一个：访问权限校验的handler
    $handlerAuthority = new HandlerAuthority();

    // 构成对象链
    $handlerAccessToken->setNext($handlerFrequent)
                     ->setNext($handlerArguments)
                     ->setNext($handlerSign)
                     ->setNext($handlerAuthority);
    // 启动网关
    $handlerAccessToken->start($request);
} catch (\Exception $e) {
    echo $e->getMessage();
}
