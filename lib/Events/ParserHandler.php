<?php
namespace Kv\Parser\Events;

class ParserHandler
{
	public static function parserRun(&$fields)
	{
		try {
			$serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();

			if (!$serviceLocator->has('parser')) {
				throw new \Exception("Parser service not found in ServiceLocator");
			}

			/** @var \Kv\Parser\Parsers\Parser $parserService */
			$parserService = $serviceLocator->get('parser');

			// Запускаем парсер
			$parserService->run();

		} catch (\Throwable $e) {
			\Bitrix\Main\Diag\Debug::writeToFile(date("Y-m-d H:i:s") . " Parser error: " . $e->getMessage(), "", '/parser.log');
		}

		return true;
	}
}