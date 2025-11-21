<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use kv\Parser\Db\NewsTable;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

Loc::loadMessages(__FILE__);
Loader::includeModule('kv.parser');

// Проверка прав
$POST_RIGHT = $APPLICATION->GetGroupRight("kv.parser");
if ($POST_RIGHT == "D") {
    $APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}

// Заголовок
$APPLICATION->SetTitle("Новости из парсера");

// Таблица и сортировка
$sTableID = "kv_parser_news_list";
$oSort = new CAdminSorting($sTableID, "ID", "desc");
$lAdmin = new CAdminList($sTableID, $oSort);

// Кнопки над таблицей
$aContext = [
    [
        "TEXT" => "Запустить парсер",
        "TITLE" => "Запустить парсер вручную",
        "LINK" => $APPLICATION->GetCurPageParam("action=run_parser&lang=".LANG, ["action"]),
        "ICON" => "btn_new",
    ],
];
$lAdmin->AddAdminContextMenu($aContext);

// Обработка действий
if ($_REQUEST['action'] === 'run_parser') {
    try {
        // Подключаем сервис парсера
        $parserService = \Bitrix\Main\DI\ServiceLocator::getInstance()->get('parser');

        $count = $parserService::run(); // метод возвращает количество добавленных новостей

        CAdminMessage::ShowMessage([
            "MESSAGE" => "Парсер успешно выполнен. Добавлено новостей: " . intval($count),
            "TYPE" => "OK",
        ]);
    } catch (\Throwable $e) {
        CAdminMessage::ShowMessage([
            "MESSAGE" => "Ошибка при запуске парсера: " . $e->getMessage(),
            "TYPE" => "ERROR",
        ]);
    }
}

// Получаем данные из ORM
$rsData = NewsTable::getList([
    'order' => [$by => $order],
]);
$rsData = new CAdminResult($rsData, $sTableID);
$rsData->NavStart();
$lAdmin->NavText($rsData->GetNavPrint("Новости"));

// Заголовки таблицы
$lAdmin->AddHeaders([
    ["id" => "ID", "content" => "ID", "sort" => "ID", "default" => true],
    ["id" => "TITLE", "content" => "Заголовок", "sort" => "TITLE", "default" => true],
    ["id" => "LINK", "content" => "Ссылка", "sort" => "LINK", "default" => true],
    ["id" => "DATE_CREATE", "content" => "Дата создания", "sort" => "DATE_CREATE", "default" => true],
]);

// Формируем строки
while ($arRes = $rsData->NavNext(true, "f_")) {
    $row =& $lAdmin->AddRow($f_ID, $arRes);
    $row->AddViewField("TITLE", '<a href="'.$f_LINK.'" target="_blank">'.htmlspecialcharsbx($f_TITLE).'</a>');
}

// Вывод таблицы
$lAdmin->CheckListMode();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$lAdmin->DisplayList();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
