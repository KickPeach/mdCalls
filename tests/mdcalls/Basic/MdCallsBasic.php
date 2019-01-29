<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 15:28
 */

namespace Tests\kickPeach\mdCalls\Basic;

use kickPeach\mdCalls\Basic\MdCallsBasic as Basic;

abstract class MdCallsBasic extends Basic
{
    protected function invokeRpc($method, $args)
    {
        return sprintf('rpc host:%s,modulename:%s,method:%s,args:%s',$this->rpc['host'],$this->getModuleName(),$method,var_export($args,true));
    }
}
