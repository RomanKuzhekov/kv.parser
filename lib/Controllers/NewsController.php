<?php
namespace Kv\Parser\Controllers;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Contract\Controllerable;

class NewsController extends Controller implements Controllerable
{
	public function configureActions(): array
	{
		return [
			'getLatest' => [
				'prefilters' => [],
			],
		];
	}

    public function getLatestAction($limit = 10)
    {
        $service = ServiceLocator::getInstance()->get('newservice');

        return $service->getNews($limit);
    }
}
