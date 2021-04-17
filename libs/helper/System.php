<?php


namespace HS\libs\helper;


class System
{
    const OS_UNKNOWN = 0;
    const OS_SOLARIS = 1;
    const OS_LINUX = 2;
    const OS_OSX = 3;
    const OS_WIN = 4;

    public static function GetOS(){
        switch (true){
            case stristr(PHP_OS_FAMILY, 'WIN'):
                return self::OS_WIN;
            case stristr(PHP_OS_FAMILY, 'LIN'):
                return self::OS_LINUX;
            case stristr(PHP_OS_FAMILY,  'OSX'):
                return self::OS_OSX;
            case stristr(PHP_OS_FAMILY, 'SOL'):
                return self::OS_SOLARIS;
            default:
                return self::OS_UNKNOWN;
        }
    }
}