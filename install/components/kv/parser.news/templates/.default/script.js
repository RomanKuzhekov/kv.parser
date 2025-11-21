BX.ready(function() {
    new Vue({
        el: '#news-app',
        data: {
            items: [],
            loading: true,
            error: null
        },
        mounted() {
            this.fetchNews();
        },
        methods: {
            fetchNews() {
                BX.ajax.runAction('kv:parser.NewsController.getLatest', { data: { limit: 10 } })
                    .then(response => {
                        this.items = response.data ?? [];
                        this.loading = false;
                    })
                    .catch(error => {
                        console.error('Ошибка при получении новостей:', error);
                        this.error = 'Не удалось загрузить новости.';
                    });
            },
            formatDate(date) {
                return new Date(date).toLocaleString('ru-RU');
            }
        }
    });
});