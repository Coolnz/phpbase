<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-18
 * Time: 10:18.
 */
trait Log
{
    public function parameterCheck($parameters)
    {
        echo __METHOD__ . ' parameter check' . $parameters . PHP_EOL;
    }

    public function startLog()
    {
        echo __METHOD__ . ' public function' . PHP_EOL;
    }
}

trait Check
{
    public function parameterCheck($parameters)
    {
        echo __METHOD__ . ' parameter check' . $parameters . PHP_EOL;
    }

    public function startLog()
    {
        echo __METHOD__ . ' public function' . PHP_EOL;
    }
}

class Publish
{
    use Check, Log {
        Check::parameterCheck insteadof Log;
        Log::startLog insteadof Check;
        Check::startLog as csl;
    }

    public function doPublish()
    {
        $this->startLog();
        $this->parameterCheck('params');
        $this->csl();
    }
}

$publish = new Publish();
$publish->doPublish();
