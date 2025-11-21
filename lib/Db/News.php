<?php
namespace Kv\Parser\Db;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\Type\DateTime;

class NewsTable extends Entity\DataManager
{
    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'kv_parser_news';
    }

    /**
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new StringField('TITLE', [
                'default_value' => '',
            ]),
            new StringField('LINK', [
                'default_value' => '',
            ]),
            new DatetimeField('DATE_CREATE', [
                'default_value' => new DateTime()
            ]),

        ];
    }
}
