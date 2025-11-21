<?php

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Kv\Parser\Db\NewsTable;

Loc::loadMessages(__FILE__);

class kv_parser extends CModule
{
    public $MODULE_ID = 'kv.parser';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_URI;
    public $MODULE_GROUP_RIGHTS;

    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('kv_module_name');
        $this->MODULE_DESCRIPTION = Loc::getMessage('kv_module_description');
        $this->PARTNER_NAME = Loc::getMessage('kv_partner_name');
        $this->PARTNER_URI = Loc::getMessage('kv_partner_uri');
        $this->MODULE_GROUP_RIGHTS = 'N';
    }

    public  function InstallDB($arParams = [])
    {
		if (Loader::includeModule($this->MODULE_ID)) {
			NewsTable::getEntity()->createDbTable();
		}

        return true;
    }

    public  function UnInstallDB($arParams = [])
    {
		if (Loader::includeModule($this->MODULE_ID)) {
			$connection = Application::getConnection();
			$tableName = NewsTable::getTableName();
			if ($connection->isTableExists($tableName)) {
				$connection->dropTable($tableName);
			}
		}

        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/local/modules/'.$this->MODULE_ID.'/install/components', $_SERVER['DOCUMENT_ROOT'] . '/local/components', true, true);
    }

    public function UnInstallFiles()
    {
        DeleteDirFilesEx('/local/components/kv');
        return true;
    }


	// Зарегить событие которое будет запускать парсер после добавления новости




	// Зарегить агента который будет запускаться раз в день и очищать старые данные


    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);

		Option::set($this->MODULE_ID, "SOURCE_URL");
		Option::set($this->MODULE_ID, "NEWS_LIMIT");

		$this->InstallFiles();
		$this->InstallDB();
    }

    public function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallFiles();

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
