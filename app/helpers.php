<?php
/*
 * Created by PhpStorm.
 * User: Remx
 * Time: 17/12/15 PM4:32
 */

function subtext($text, $length){
    if(mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8').'...';
    return $text;
}