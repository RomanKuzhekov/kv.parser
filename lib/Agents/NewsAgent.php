<?php
namespace Kv\Parser\Agents;

use Bitrix\Main\Type\DateTime;
use Kv\Parser\Db\NewsTable;

class NewsAgent
{
	public static function DeleteOldNews()
	{
		// Дата, старше которой удаляем новости
		$dateLimit = new DateTime();
		$dateLimit->add('-30 days');

		$newsList = NewsTable::getList([
			'select' => ['ID'],
			'filter' => [
				'<=DATE_CREATE' => $dateLimit,
			],
			'order' => ['DATE_CREATE' => 'ASC'],
		]);

		while ($news = $newsList->fetch()) {
			NewsTable::delete($news['ID']);
		}

		return __METHOD__ . '();';
	}
}