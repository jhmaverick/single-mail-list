<?php

Vesta::add_filter("menu", function ($items) {
    // Change mail link
    $items = array_map(function ($item){
        if ($item['name'] == 'MAIL') $item['link'] = "/plugin/single-mail-list/";
        return $item;
    },$items);

    return $items;
}, 11);
