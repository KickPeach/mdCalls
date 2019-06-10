<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/28
 * Time: 20:59
 */

namespace kickPeach\mdCalls\Basic;

use kickPeach\mdCalls\Exceptions\MdCallsException;

abstract class MdCallsBasic
{
    public $mdc;

    private $namespace = '';

    final public function getNamespace()
    {
        return $this->namespace;
    }

    private $moduleName = '';

    final public function getModuleName()
    {
        return $this->moduleName;
    }

    final public function initService($namespace,$moduleName)
    {
        if ($this->namespace){
            throw new MdCallsException('method deny,invoke:'.__METHOD__.'@'.get_class($this));
        }

        //初始化模块属性
        $this->namespace = $namespace;
        $this->moduleName = $moduleName;

        $this->init();
    }

    abstract protected function init();


    final protected function loadC($class,...$args)
    {
        if(!empty($this->moduleName)) {
            //加载当前服务的子类
            $classNmae = '\\'.$this->namespace.'\Service\\'.$this->moduleName.'\\Child\\'.$class;

            $subObj = new $classNmae(...$args);

            if ($subObj instanceof self) {
                $subObj->mdc = $this->mdc;
                $subObj->initService($this->namespace,$this->moduleName);
            }

            return $subObj;
        }else{
            throw new Exception('can not loadC until construct obj, invoke:' . __METHOD__ . '@' . get_class($this));
        }
    }

    protected $rpc = [
        'host'=>'',
        'method'=>[]
    ];

    public function __call($method, $arguments)
    {
        if (empty($this->rpc['method']) || in_array($method,$this->rpc['method']) || empty($this->rpc['host'])){
            throw new \Exception('非法调用'.$method.'@'.get_class($this));
        }

        return $this->invokeRpc($method,$arguments);
    }

    abstract protected function invokeRpc($method,$args);

}
