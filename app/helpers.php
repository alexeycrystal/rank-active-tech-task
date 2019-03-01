<?php

function array_key_unique($arr, $key) {
    $uniquekeys = array();
    $output     = array();
    foreach ($arr as $item) {
        if (!in_array($item[$key], $uniquekeys)) {
            $uniquekeys[] = $item[$key];
            $output[]     = $item;
        }
    }
    return $output;
}