<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'GROUPS' => [
        'USER_CARD' => [
            'NAME' => 'Новости парсера',
        ],
    ],
    'PARAMETERS' => [
        'SHOW_DATE' => [
            'NAME' => 'Показывать дату новости',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
            'PARENT' => 'USER_CARD',
        ],
    ],
];
