<?php
if(!function_exists('string_contains')){
    function string_contains($stack,$needle){
        return ((version_compare(phpversion(), '8.0.0', '>=')) ? str_contains($stack,$needle) : (strpos($stack,$needle) !== false));
    }
}