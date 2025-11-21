<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ParserComponent extends CBitrixComponent
{
    /**
     * Подготавливаем входные параметры
     *
     * @param  array $arParams
     *
     * @return array
     */
    public function onPrepareComponentParams($arParams)
    {
        $arParams['SHOW_DATE'] ??= 'Y';

        return $arParams;
    }
    /**
     * Основной метод выполнения компонента
     *
     * @return void
     */

    public function executeComponent()
    {
		$this->includeComponentTemplate();
    }

}
