<template>
    <div id="app">

        <!-- Header -->
        <nav class="navbar navbar-dark bg-dark sticky-top navbar-expand-lg">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand" href="#">Selim Can CABA</router-link>

                <button class="navbar-toggler" type="button" @click="navbarShow = !navbarShow">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" :class="{ show: navbarShow }">
                    <div class="navbar-nav">
                        <router-link :to="{ name: 'home' }" class="nav-item nav-link">Blog</router-link>
                        <a v-for="page in pages" :href="'/page/'+page.slug+'-'+page.id" class="nav-item nav-link">{{ page.title }}</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="container p-0">
            <div class="card content-card shadow-sm">

                <router-view></router-view>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                navbarShow: false,
                pages: []
            }
        },
        created () {
            this.fetchData();
        },
        methods: {
            fetchData () {
                let vm = this;
                fetch('/api/pages')
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        if (typeof json.items !== 'undefined') {
                            vm.pages = json.items;
                        }
                    });
            }
        }
    }
</script>

<style>

</style>