# mdCalls

mdCalls，module calls的简写，是一个解决依赖以及单例调用的模块化服务的package,支持rpc调用以及任意使用composer的框架使用，帮助模块化组织各种服务逻辑，让服务间调用方式更加同意

## 平常使用调用其他服务的方式

- new 创建

new UserService(),导致同个类被实例化多次，占用内存

- 依赖注入

虽说有容器可以解决依赖问题，但是在一些不支持容器的框架中也只能使用new 方式来创建。



## mdcalls模块化


mdcalls提供了一种新的选择，每个模块都会实例化一次，每个模块的服务提供唯一的入口暴露给调用方，每个模块之间可以划分各种子模块，模块可以调用子模块的来完成业务逻辑。

例如:
```cmd
    $ret = $this->mdc->User->setInfo('seven',24);
```

# 使用方法

## 安装

```cmd

composer require kickpeach/mdcalls -vvv

```

## mdCalls源码解析
```
src根文件夹
├── MdCallsService.php		MdCallsService服务类
├── Basic/					
│   └── MdCallsBasic.php	MdCalls基类
└── Exceptions/				
    └── MdCallsException.php MdCalls异常类
    
```

代码是不是很简单呢，只有三个文件，看懂了这三个文件，也差不多就可以很好的使用模块化了

[MdCallsService](https://github.com/KickPeach/mdCalls/blob/master/src/MdCallsService.php)
提供单例入口并且自动加载模块并调用，并返回模块实例对象

[MdCallsBasic](https://github.com/KickPeach/mdCalls/blob/master/src/Basic/MdCallsBasic.php)
加载服务子类

[MdCallsException](https://github.com/KickPeach/mdCalls/blob/fee1ca39eb7b548b7b7430c82ee4d52e739b34a5/src/Exceptions/MdCallsException.php)
简单抛出异常

## 编写模块化服务

- 参考例子

请见[这里](https://github.com/KickPeach/mdCalls/tree/master/tests/mdcalls)

- 目录结构

```
mdcalls 根文件夹
├── MdCalls.php				入口类
├── Basic/					文件夹
│   └── MdCallsBasic.php				服务基类
└── Service/				Service文件夹，包括所有的服务模块
    └── User/			    服务模块1：User模块
        └── UserIndex.php	服务模块入口
        ├── Child/			模块子类文件夹
        │   └── UserInfo.php	模块子类	
    └── Message/			服务模块2：Message模块
        ├── Child/
        │   └── MessageList.php
        └── MessageIndex.php		
```

- 入口类```php
MdCalls.php```

```php

<?php

namespace Tests\kickPeach\mdCalls;

use kickPeach\mdCalls\MdCallsService;

class MdCalls extends MdCallsService
{
    protected static $mdCallsInstance;

    protected $mdCallsNamespace = 'Tests\kickPeach\mdCalls';
}

```

需要定义好$mdCallsNamespace，这样子，在调用子类或者mdcalls的找得到文件，这个是重中之中的事情，同事也需要，定义好$mdCallsInstance。

- mdCalls基类```php
Basic/MdCallsBasic.php```

```php
<?php

namespace Tests\kickPeach\mdCalls\Basic;

use kickPeach\mdCalls\Basic\MdCallsBasic as Basic;

abstract class MdCallsBasic extends Basic
{
    protected function invokeRpc($method, $args)
    {
        return sprintf('rpc host:%s,modulename:%s,method:%s,args:%s',$this->rpc['host'],$this->getModuleName(),$method,var_export($args,true));
    }
}

```

这里需要使用rpc，那么需要实现invokeRpc方法，这个类为其他模块的父类，所有模块都需要继承此类。

- Service类的创建

首先，各个模块的服务都需要放在Service文件夹下，这里的服务指的是，可以单独完成某个功能的类，比如在我们的测试案例中，我们可以拆分成User,Passage,Goods等服务，

其次，每个服务的入口类在这里需要以 “服务名+Index”这样命名，比如在User服务中，入口类为```UserIndex.php```,在入口类，我们暴露一下对外访问的方法，只接受参数和返回数据，处理业务逻辑，不做具体业务功能的实现

具体的业务实现都在Child中，比如User服务中，我们需要获取用户信息```UserInfo```等等功能，我们可以在Child文件下，区分大小写，新建UserInfo类继承Basic/MdCallsBasic,这样子，我们在UserIndex可以通过
调用loadC获取到具体业务逻辑的实例，如下：
```cmd
        $this->user = $this->loadC('UserInfo','getInfo');
```

如果需要新建新的服务，同上的User做法，新建服务名文件夹，定义好以服务名+Index的入口类，然后再Child文件夹下，定义好各种实现具体业务逻辑的类，服务入口类还有业务逻辑的类都需要继承自```Basic/MdCallsBasic```
在入口调用子类的方法为loadC("子模块名"，"参数")


## 调用

- 在Service模块服务内调用

$this->mdc->模块->方法()

- 在Service模块服务外调用

先实例化mdc服务，参考[这里](https://github.com/KickPeach/mdCalls/blob/fee1ca39eb7b548b7b7430c82ee4d52e739b34a5/tests/MdCallTest.php)
```php
       $this->mdc = MdCalls::getInstance();
       $mdc->模块->方法()
```
     
## 使用rpc

需要在入口类中配置属性$rpc

```php
/**
 * rpc配置
 */
protected $rpc = [
	'host'      => '',  //网关地址
	'method'    => [], //方法名 减少无用的远程调用
];
```

以及实现你所需要的调用方法

# License

The MIT License (MIT).

