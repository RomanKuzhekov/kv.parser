<?php

return [
    [
        "parent_menu" => "global_menu_services",
        "section" => "kv_parser",
        "sort" => 0,
        "text" => "Парсер новостей",
        "title" => "Парсер новостей",
        "icon" => "util_menu_icon",
        "page_icon" => "util_page_icon",
        "items_id" => "menu_kv_parser",
        "items" => [
            [
                "text" => "Новости парсера",
                "url" => "kv_parser_news_list.php?lang=".LANG,
                "more_url" => [],
                "title" => "Список новостей",
            ],
        ],
    ],
];
