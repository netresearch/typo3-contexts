<?php

require_once __DIR__ . '../../../../../Classes/Context/Type/Ip.php';
//require_once __DIR__ . '../../../../../Classes/Context/Abstract.php';

require_once __DIR__ . '../../../../../../../../t3lib/class.t3lib_div.php';


class Tx_Contexts_Context_Type_IpTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider addressProvider
     */
    public function testIsIpInRange($ip, $range, $res)
    {
       $instance = new Tx_Contexts_Context_Type_Ip();
       
       $this->assertSame($res, $this->callProtected($instance, 'isIpInRange', $ip, $range));
       
    }
    
    
    public static function addressProvider()
    {
        return array(
          array('80.76.201.37', '80.76.201.32/27', true),
          array('FE80:FFFF:0:FFFF:129:144:52:38', "FE80::/16", true),
          array('80.76.202.37', '80.76.201.32/27', false),
          array('FE80:FFFF:0:FFFF:129:144:52:38', "FE80::/128", false),
          array('80.76.201.37', '', false),    
          array('80.76.201', '', false),
        );
    }
    
    /**
     * Make a proteced/private method accessible.
     *
     * @param string $strClass      Class name
     * @param string $strMethodName Method name
     *
     * @return ReflectionMethod
     */
    public function getAccessibleMethod($strClass, $strMethodName)
    {
        $reflectedClass = new ReflectionClass($strClass);

        /* @var $method ReflectionMethod */
        $method = $reflectedClass->getMethod($strMethodName);
        $method->setAccessible(true);

        return $method;
    }
    
    /**
     * Call a protected method on an object and return the result
     *
     * @param object $obj           Object the method should be called on
     * @param string $strMethodName Method to be called
     * @param mixed  $param1        First method parameter
     * @param mixed  $param2        Second method parameter
     * @param mixed  ...            ...
     *
     * @return mixed Whatever the method returns
     */
    public function callProtected($obj, $strMethodName)
    {
        $params = func_get_args();
        array_shift($params);
        array_shift($params);
        $m = $this->getAccessibleMethod(get_class($obj), $strMethodName);
        return $m->invokeArgs($obj, $params);
    }
}

abstract class Tx_Contexts_Context_Abstract{}
?>