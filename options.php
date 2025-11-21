<?php
use Bitrix\Main\Config\Option;

$module_id = "kv.parser";

if ($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid()) {
    Option::set($module_id, "SOURCE_URL", $_POST["SOURCE_URL"]);
    Option::set($module_id, "NEWS_LIMIT", $_POST["NEWS_LIMIT"]);
}

$sourceUrl = Option::get($module_id, "SOURCE_URL");
$newsLimit = Option::get($module_id, "NEWS_LIMIT");
?>

<form method="POST">
    <?=bitrix_sessid_post()?>
    <table class="adm-detail-content-table edit-table">
        <tr>
            <td><?=GetMessage('URL_SOURCE')?>:</td>
            <td><input type="text" name="SOURCE_URL" value="<?=$sourceUrl?>" size="50"></td>
        </tr>
        <tr>
            <td><?=GetMessage('LIMIT_NEWS')?>:</td>
            <td><input type="text" name="NEWS_LIMIT" value="<?=$newsLimit?>" size="5"></td>
        </tr>
    </table>
    <input type="submit" value="Сохранить" class="adm-btn-save">
</form>
