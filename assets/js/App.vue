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
                        <router-link :to="{ name: 'contact' }" class="nav-item nav-link">İletişim</router-link>
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

    import { mapGetters, mapActions } from 'vuex';

    export default {
        data: function () {
            return {
                navbarShow: false,
                appTitle: ''
            }
        },
        computed: Object.assign(mapGetters(['getAppTitle'])),
        methods:
            Object.assign({
                updateGAID(ga_id) {
                    this.updateGAID(ga_id);
                },
                updateAppTitle(title) {
                    this.updateAppTitle(title);
                }
            }, mapActions(['updateGAID', 'updateAppTitle'])),
        created() {
            this.updateGAID(window.GA_ID);
            this.updateAppTitle(window.appTitle);
            this.appTitle = this.getAppTitle;
        }
    }
</script>

<style>

</style>