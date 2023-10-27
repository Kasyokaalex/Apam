<?php 

function to_currency($number, $symbol = "", $decimals = 2)
{
    return $symbol . number_format($number, $decimals);
}