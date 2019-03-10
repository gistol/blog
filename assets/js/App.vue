<template>
    <div id="app">

        <!-- Header -->
        <nav class="navbar navbar-dark bg-dark sticky-top navbar-expand-lg">
            <div class="container">
                <router-link :to="{ name: 'home' }" class="navbar-brand" href="#">{{ appTitle }}</router-link>

                <button class="navbar-toggler" type="button" @click="navbarShow = !navbarShow">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" :class="{ show: navbarShow }">
                    <div class="navbar-nav">

                        <router-link :to="{ name: 'home' }" class="nav-item nav-link">Blog</router-link>

                        <div v-for="page in pages">
                            <router-link :to="{ name: 'page', params: { id: page.id, slug: page.slug } }" class="nav-item nav-link">
                                {{ page.title }}
                            </router-link>
                        </div>

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

        <!-- Download -->
        <div class="text-secondary text-center">
            <small>
            Bu blogun kaynak kodlarını <a href="https://github.com/RetroHat/blog">github</a>tan indirebilirsiniz.
            </small>
        </div>

    </div>
</template>

<script>

    import { mapGetters, mapActions } from 'vuex';

    export default {
        data: function () {
            return {
                navbarShow: false,
                pages: [],
                appTitle: ''
            }
        },
        created () {
            this.fetchData();
            this.updateGAID(window.GA_ID);
            this.updateAppTitle(window.appTitle);
            this.appTitle = this.getAppTitle;
        },
        computed: Object.assign(mapGetters(['getAppTitle'])),
        methods:
            Object.assign({
                updateGAID(ga_id) {
                    this.updateGAID(ga_id);
                },
                updateAppTitle(title) {
                    this.updateAppTitle(title);
                },
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
            }, mapActions(['updateGAID', 'updateAppTitle'])),
    }
</script>

<style>

</style>