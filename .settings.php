<?php

use Bitrix\Main\Loader;

$arModule = [
    'iblock',
    'highloadblock',
    'sale',
    'catalog'
];

foreach($arModule as $moduleId){
    if(!Loader::includeModule($moduleId)){
        return;
    }
}

return [
    "controllers" => [
        "value" => [
            "defaultNamespace" => "\\Kv\\Parser\\Controllers"
        ],
        "readonly" => true
    ],
    'services' => [
		'value' => [
            'newservice' => [
                'className' => Kv\Parser\Services\NewsService::class,
			],
            'parser' => [
                'className' => \Kv\Parser\Parsers\Parser::class,
            ],
		],
		'readonly' => true,
	],
];