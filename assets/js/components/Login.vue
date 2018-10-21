<template>
    <div>
        <div v-if="loading" class="text-center m-4">
            <font-awesome-icon icon="spinner" spin size="4x"/>
        </div>

        <div v-else class="card-body">
            <form onsubmit="return false;">

                <div v-if="error !== ''" class="alert alert-danger" role="alert">
                    {{ error }}
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" id="username" v-model="username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" v-model="password">
                </div>

                <button class="btn btn-success" type="submit" @click="login">Login</button>

            </form>

        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                loading: false,
                error: '',
                username: '',
                password: ''
            }
        },
        methods: {
            login: function () {
                this.loading = true;

                let vm = this;

                fetch('/check_login', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: "POST",
                    body: JSON.stringify({username: this.username, password: this.password})
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (json) {
                        if (json.success) {
                            window.location = json.targetPath;
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