<?php

namespace app\library;
 
class MyClass {
     
    public function __construct()
    {
        var_dump('ยินดีตอนรับสู่ MyClass');
    }
     
    public static function getVersion()
    {
        var_dump('เวอร์ชั่น 1.0');
    }
     
}