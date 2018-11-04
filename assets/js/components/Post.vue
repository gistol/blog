<template>
    <div>

        <div v-if="loading" class="text-center m-4">
            <font-awesome-icon icon="spinner" spin size="4x"/>
        </div>

        <div v-else-if="error.length > 0">
            <div class="card-body">
                <h2 class="text-dark">{{ error }}</h2>
            </div>
        </div>

        <div v-else>

            <img :src="post.image" :alt="post.title" class="card-img-top">

            <div class="card-body">

                <h2 class="text-dark">{{ post.title }}</h2>

                <p class="text-muted small">
                    <font-awesome-icon icon="calendar-alt"/>
                    {{ post.createdAt }} ( Güncellenme: {{ post.updatedAt }} )
                </p>

                <hr>

                <div id="post_content" v-html="post.content"></div>

                <hr>

                <div class="row">

                    <div class="col-sm-12 col-md-6 mb-2 mb-md-0">

                        <div class="card shadow-sm text-center" v-for="suggestedPost in [post.previousPost]" v-if="suggestedPost">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <router-link :to="{ name: 'post', params: { id: suggestedPost.id, slug: suggestedPost.slug } }" class="card-link text-dark">
                                        {{ suggestedPost.title }}
                                    </router-link>
                                </h5>
                                <p class="card-text">{{ suggestedPost.summary }}</p>
                            </div>

                            <div class="card-footer">
                                <router-link :to="{ name: 'post', params: { id: suggestedPost.id, slug: suggestedPost.slug } }" class="card-link text-dark">Önceki yazıyı oku</router-link>
                            </div>

                        </div>

                    </div>

                    <div class="col-sm-12 col-md-6">

                        <div class="card shadow-sm text-center" v-for="suggestedPost in [post.nextPost]" v-if="suggestedPost">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <router-link :to="{ name: 'post', params: { id: suggestedPost.id, slug: suggestedPost.slug } }" class="card-link text-dark">
                                        {{ suggestedPost.title }}
                                    </router-link>
                                </h5>
                                <p class="card-text">{{ suggestedPost.summary }}</p>
                            </div>

                            <div class="card-footer">
                                <router-link :to="{ name: 'post', params: { id: suggestedPost.id, slug: suggestedPost.slug } }" class="card-link text-dark">Sonraki yazıyı oku</router-link>
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
                post: {},
                error: ''
            }
        },
        created () {
            this.fetchData();
        },
        updated () {
            window.updatePostContent();
        },
        watch: {
            '$route': 'fetchData'
        },
        methods: {
            fetchData () {
                let vm = this;

                fetch('/api/posts/' + this.$route.params.id)
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        if (typeof json.data !== 'undefined') {
                            vm.post = json.data;
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