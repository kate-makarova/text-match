<template>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div class="alert alert-danger" v-if="has_error && !success">
                            <p v-if="error == 'login_error'">Validation Errors.</p>
                            <p v-else>Error, unable to connect with these credentials.</p>
                        </div>
                        <form autocomplete="off" @submit.prevent="login" method="post">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Signin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
const LOGIN = "LOGIN";
const LOGIN_SUCCESS = "LOGIN_SUCCESS";
const LOGOUT = "LOGOUT";

export default {
    data() {
        return {
            email: null,
            password: null,
            success: false,
            has_error: false,
            error: ''
        }
    },
    mounted() {
        //
    },
    methods: {
        login() {
            // get the redirect object
            var redirect = this.$auth.redirect()
            var app = this
            app.$store.commit(LOGIN);

            this.$auth.login({
                data: {
                    email: app.email,
                    password: app.password
                },
                success: function () {
                    // handle redirection
                    console.log('success');
                    app.success = true
                    app.$store.commit(LOGIN_SUCCESS);
                },
                error: function () {
                    console.log('error');
                    console.log(res.response);
                    app.has_error = true
                    app.error = res.response.data.error
                },
                rememberMe: true,
                fetchUser: true,
                redirect: {
                    path: '/texts'
                },
            })
        }
    }
}
</script>
