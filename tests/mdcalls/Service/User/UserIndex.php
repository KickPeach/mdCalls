<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 14:57
 */

namespace Tests\kickPeach\mdCalls\Service\User;

use Tests\kickPeach\mdCalls\Basic\MdCallsBasic as Basic;

class UserIndex extends Basic
{
    private $user;

    public function init()
    {
        $this->user = $this->loadC('UserInfo','getInfo');
    }

    public function getInfo()
    {
        return $this->user->getInfo();
    }

    public function setInfo($name,$age)
    {
        return $this->user->setInfo($name,$age);
    }

    const EXAMPLE_MDC_RPC_HOST = 'https://example.com/rpc';

    protected $rpc = [
        'host'=>self::EXAMPLE_MDC_RPC_HOST,
        'method'=>['userRpc'],//方法名
    ];

    public function userRpc()
    {
        return $this->rpc;
    }

}