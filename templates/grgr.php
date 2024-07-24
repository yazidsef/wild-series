<?php

function actions(int $number):string
{

$number = decbin($number);
echo $number .'<br>';
$number = strrev($number);
$string = '';
if($number[0]==='1'){
	$string .= 'wink';
}elseif($number[1] ==='1')
{
	$string .= ' , double click';
} 
elseif($number[2]==='1')
{
	$string .= ' , close your eyes';
	
}
elseif($number[3]==='1')
{
	$string .=' , jump';
}
    return $string;
}


?>