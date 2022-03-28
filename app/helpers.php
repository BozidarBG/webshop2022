<?php

function formatPrice($price){
    return $price ? number_format($price/100, 2, ',','.') : 0;
}

function formatDate($date){
    if(is_string($date)){
       return \Carbon\Carbon::parse($date)->format('d.m.Y H:i');
    }
    return $date ? $date->format('d.m.Y H:i') : null;
}

