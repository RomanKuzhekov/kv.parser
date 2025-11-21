<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ParserComponent extends CBitrixComponent
{
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
