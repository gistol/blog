<template>
    <div>

        <div v-if="loading" class="text-center m-4">
            <font-awesome-icon icon="spinner" spin size="4x"/>
        </div>

        <div v-else class="card-body pb-1">
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3" v-for="post in posts">

                    <div class="card shadow-sm">

                        <router-link :to="{ name: 'post', params: { id: post.id, slug: post.slug } }">
                            <img :src="post.image" :alt="post.title" class="card-img-top">
                        </router-link>

                        <div class="card-body">
                            <h5 class="card-title">
                                <router-link :to="{ name: 'post', params: { id: post.id, slug: post.slug } }" class="card-link text-dark">
                                    {{ post.title }}
                                </router-link>
                            </h5>
                            <p class="card-text">{{ post.summary }}</p>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">{{ post.createdAt }}</small>
                                </div>
                                <div class="col-6 text-right">
                                    <router-link :to="{ name: 'post', params: { id: post.id, slug: post.slug } }" class="card-link text-dark">Devamını oku</router-link>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                loading: true,
                posts: [
                    {
                        id: 0,
                        title: '',
                        summary: '',
                        image: ''
                    }
                ]
            }
        },
        created () {
            this.fetchData();
        },
        methods: {
            fetchData () {
                let vm = this;

                fetch('/api/posts')
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        vm.posts = json.items;
                        vm.loading = false;
                    });
            }
        }
    }
</script>

<style>

</style>