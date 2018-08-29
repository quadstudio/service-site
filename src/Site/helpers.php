<?php
if (!function_exists('numberof')) {
    /**
     * @param $numberof
     * @param $value
     * @param $suffix
     * @return string
     */
    function numberof($numberof, $value, $suffix)
    {
        // не будем склонять отрицательные числа
        $numberof = abs($numberof);
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $numberof % 100;
        $suffix_key = $mod > 4 && $mod < 20 ? 2 : $keys[min($mod % 10, 5)];

        return $value . $suffix[$suffix_key];
    }
}

if (!function_exists('w1251')) {
    /**
     * @param $txt
     * @return string
     */
    function w1251($txt)
    {
        return iconv('utf-8', "windows-1251//TRANSLIT", implode("\n", explode("\n", $txt)));
    }
}