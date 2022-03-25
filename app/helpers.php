<?php

function formatPrice($price){
    return $price ? number_format($price/100, 2, ',','.') : 0;
}

function formatDate($date){
    return $date ? $date->format('d.m.Y H:i') : null;
}

