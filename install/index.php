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

		$proxyFilePath = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/kv_news_list.php';
		$content = '<?php' . PHP_EOL . 'require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/' . $this->MODULE_ID . '/admin/kv_news_list.php");' . PHP_EOL;
		file_put_contents($proxyFilePath, $content);
	}

    public function UnInstallFiles()
    {
        DeleteDirFilesEx('/local/components/kv');

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/kv_news_list.php')) {
			unlink($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/kv_news_list.php');
		}

        return true;
    }


	// Зарегить событие которое будет запускать парсер после добавления новости




	// Зарегить агента который будет запускаться раз в день и очищать старые данные


    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);

		// Настройки по умолчанию
		include $_SERVER["DOCUMENT_ROOT"].'/local/modules/kv.parser/default_option.php';
		if (!empty($kv_parser_default_option) && is_array($kv_parser_default_option)) {
			foreach ($kv_parser_default_option as $option => $value) {
				Option::set($this->MODULE_ID, $option, $value);
			}
		}

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
