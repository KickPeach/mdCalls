<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 16:45
 */

namespace Tests\mdCalls;


use PHPUnit\Framework\TestCase;
use Tests\kickPeach\mdCalls\MdCalls;

class MdCallTest extends TestCase
{
    protected $mdc;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        //初始化单例测试对象
        $this->mdc = MdCalls::getInstance();
    }

    public function testUserService()
    {
        $ret = $this->mdc->User->setInfo('seven',24);
        $this->assertEquals(true,$ret);
        $ret = $this->mdc->User->getInfo();
        $this->assertArrayHasKey('name',$ret);
        $this->assertArrayHasKey('age',$ret);
    }

    public function testUserRpcService()
    {
        $ret = $this->mdc->User->userRpc();
        $this->assertArrayHasKey('host',$ret);
        $this->assertArrayHasKey('method',$ret);
    }
}