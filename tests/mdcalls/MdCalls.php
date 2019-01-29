<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 14:38
 */

namespace Tests\kickPeach\mdCalls;

use kickPeach\mdCalls\MdCallsService;

class MdCalls extends MdCallsService
{
    protected static $mdCallsInstance;

    protected $mdCallsNamespace = 'Tests\kickPeach\mdCalls';
}