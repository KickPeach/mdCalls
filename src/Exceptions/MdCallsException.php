<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/1/29
 * Time: 10:17
 */

namespace kickPeach\mdCalls\Exceptions;

use Throwable;

class MdCallsException extends \Exception
{
    public function __construct($message = "", $code =0)
    {
        parent::__construct($message, $code);
    }

}