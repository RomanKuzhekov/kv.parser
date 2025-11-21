<?php
namespace Kv\Parser\Parsers;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;
use Kv\Parser\Db\NewsTable;

class Parser
{
    public static function run()
    {
        Loader::includeModule("iblock");

        $moduleId = "kv.parser";
        $url = Option::get($moduleId, "SOURCE_URL");
        $limit = Option::get($moduleId, "NEWS_LIMIT");

        $xml = simplexml_load_file($url);

        $count = 0;
        foreach ($xml->channel->item as $item) {
            if ($count >= $limit) break;

			NewsTable::add([
				"TITLE" => (string)$item->title,
				"LINK" => (string)$item->link,
				"DATE_CREATE" => new DateTime()
			]);

            $count++;
        }

        return $count;
    }
}
