<?php


    function isActiveRoute($route, $output = 'active')
    {
        if (Route::currentRouteName() == $route) {
            return $output;
        }
    }

    function size_formatted($size)
    {
        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
