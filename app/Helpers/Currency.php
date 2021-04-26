<?php

function currency($angka){ 
    $hasil =  number_format($angka,0, ',' , '.'); 
    return $hasil; 
}