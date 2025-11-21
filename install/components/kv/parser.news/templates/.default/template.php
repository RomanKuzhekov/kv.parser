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

<div id="news-app" v-cloak>
	<div v-if="loading" class="loading">Загрузка новостей...</div>
	<div v-else class="news-list">
		<div v-for="item in items" :key="item.ID" class="news-list__item">
			<h3 class="news-list__title"><a :href="item.LINK" target="_blank">{{ item.TITLE }}</a></h3>
			<?php if ($arParams['SHOW_DATE'] === 'Y'): ?>
				<small class="news-list__date">{{ formatDate(item.DATE_CREATE) }}</small>
			<?php endif; ?>
			<hr>
		</div>
		<div v-if="!items.length" class="news-list__empty">Новостей пока нет.</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
