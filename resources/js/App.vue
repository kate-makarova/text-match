<template>
    <div class="wrapper">
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
        <div class="container"><router-link to="/" class="navbar-brand js-scroll-trigger">RIGHT READ</router-link>
            <button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu <i class="fas fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
<!--                    <li class="nav-item mx-0 mx-lg-1"><router-link to="/download" class="nav-link py-3 px-0 px-lg-3 rounded">DOWNLOAD</router-link>-->
<!--                    </li>-->
                    <li class="nav-item mx-0 mx-lg-1"><router-link v-if="user" :to="{ name: 'texts' }" class="nav-link py-3 px-0 px-lg-3 rounded">TEXTS</router-link>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1"><router-link v-if="!user" :to="{ name: 'login' }" class="nav-link py-3 px-0 px-lg-3 rounded">LOGIN</router-link>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1"><router-link v-if="!user" :to="{ name: 'register' }" class="nav-link py-3 px-0 px-lg-3 rounded">REGISTER</router-link>
                    </li>
                    <li v-if="user"  class="nav-item mx-0 mx-lg-1 dropdown">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            USER MENU
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
<!--                            <a class="dropdown-item" href="#">Laguages</a>-->
<!--                            <a class="dropdown-item" href="#">Bookmarks</a>-->
<!--                            <a class="dropdown-item" href="#">History</a>-->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" @click.prevent="logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <div id="content-container">
            <router-view></router-view>
        </div>


        <footer class="footer text-center">
            <div class="container-fluid p-3">
                <ul class="bd-footer-links">
                    <li><router-link :to="{ name: 'about' }">About</router-link></li>
                    <li><router-link :to="{ name: 'copyright' }">Concerning copyright</router-link></li>
                    <li><a href="https://github.com/kate-makarova/right-read">GitHub</a></li>
                </ul>
            </div>
        </footer>
        <!-- Copyright Section-->
        <section class="copyright py-4 text-center text-white">
            <div class="container"><small class="pre-wrap">Copyright © Right Read 2020 </small></div>
        </section>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
    </div>
</template>

<script>
const LOGIN = "LOGIN";
const LOGIN_SUCCESS = "LOGIN_SUCCESS";
const LOGOUT = "LOGOUT";

export default {
    data() {
        return {
            user: false
        }
    },
    updated() {
        this.user = localStorage.getItem('auth_stay_signed_in') || false;
    },
    methods: {
        logout: function() {
            const app = this;
            this.$auth.logout().then(response => {
                app.$store.commit(LOGOUT);
                localStorage.removeItem('auth_token');
                localStorage.removeItem('auth_stay_signed_in');

                // remove any other authenticated user data you put in local storage

                // Assuming that you set this earlier for subsequent Ajax request at some point like so:
                // axios.defaults.headers.common['Authorization'] = 'Bearer ' + auth_token ;
                delete axios.defaults.headers.common['Authorization'];

                // If using 'vue-router' redirect to login page
                this.$router.go('/');
            })
        }
    }
}
</script>
