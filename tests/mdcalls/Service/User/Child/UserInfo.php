<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 15:38
 */

namespace Tests\kickPeach\mdCalls\Service\User\Child;

use Tests\kickPeach\mdCalls\Basic\MdCallsBasic as Basic;

class UserInfo extends Basic
{
    private $userInfo;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function getInfo()
    {
        return $this->userInfo;
    }

    public function setInfo($name,$age)
    {

        $this->userInfo =  [
            'name'=>$name,
            'age'=>$age
        ];

        return true;
    }
}