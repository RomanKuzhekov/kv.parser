<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */
?>

<div id="news-app">
    <div v-if="loading" class="loading">Загрузка новостей...</div>
    <div v-else class="news-list">
        <div v-for="item in items" :key="item.ID" class="news-item">
            <h3><a :href="item.LINK" target="_blank">{{ item.TITLE }}</a></h3>
            <?php if ($arParams['SHOW_DATE'] === 'Y'): ?>
                <small>{{ formatDate(item.DATE_CREATE) }}</small>
            <?php endif; ?>
            <hr>
        </div>
        <div v-if="!items.length" class="no-news">Новостей пока нет.</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
