<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 10:36
 */

namespace kickPeach\mdCalls;

use kickPeach\mdCalls\Exceptions\MdCallsException;

abstract class MdCallsService
{
    //单例模式
    private function __clone(){}

    private static $mdCallsInstance;

    private function __construct(){}

    public static function getInstance()
    {
        if (empty(self::$mdCallsInstance)) {
            self::$mdCallsInstance = new static();
        }

        return self::$mdCallsInstance;
    }

    protected $mdCallsNamespace;

    //找到
    public function __get($moduleName)
    {
        $moduleName = ucfirst($moduleName);
        if (property_exists($this,$moduleName)) {
            throw new MdCallsException("Module name {$moduleName} should begin with a captian letter");
        }

        $className =  $this->mdCallsNamespace . '\Service\\' .$moduleName.'\\'.$moduleName.'Index';
        $this->$moduleName = new $className();
        $this->$moduleName->mdc = $this;
        $this->$moduleName->initService($this->mdCallsNamespace,$moduleName);
        return $this->$moduleName;
    }

}