<?php
namespace Kv\Parser\Services;

use Kv\Parser\Db\NewsTable;

class NewsService
{
    public function getNews($limit = 10)
    {
        $res = NewsTable::getList([
            'order' => ['DATE_CREATE' => 'DESC'],
            'limit' => $limit
        ]);

        return $res->fetchAll();
    }
}
