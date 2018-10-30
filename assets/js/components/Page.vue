<template>
    <div :class="page.slug">

        <div v-if="loading" class="text-center m-4">
            <font-awesome-icon icon="spinner" spin size="4x"/>
        </div>

        <div v-else-if="error.length > 0">
            <div class="card-body">
                <h2 class="text-dark">{{ error }}</h2>
            </div>
        </div>

        <div v-else>

            <div class="card-body">

                <h2 class="text-dark">{{ page.title }}</h2>

                <hr>

                <div id="page_content" v-html="page.content"></div>

            </div>

        </div>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                loading: true,
                page: {},
                error: ''
            }
        },
        created () {
            this.fetchData();
        },
        updated () {

        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData () {
                let vm = this;
                fetch('/api/pages/' + this.$route.params.id)
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        if (typeof json.data !== 'undefined') {
                            vm.page = json.data;
                            vm.loading = false;

                            document.title = json.data.title;
                        } else {
                            vm.error = json.error;
                            vm.loading = false;
                        }
                    });
            }
        }
    }
</script>

<style>

</style>