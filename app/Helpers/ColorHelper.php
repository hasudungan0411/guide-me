<?php

if (!function_exists('generateColorFromText')) {
    function generateColorFromText($text)
    {
        $hash = md5($text);
        $hue = hexdec(substr($hash, 0, 6)) % 360;
        return "hsl($hue, 70%, 50%)";
    }
}
