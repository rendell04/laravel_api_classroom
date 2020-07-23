<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-info justify-content-between mb-2">
        
        <a href="#" class="navbar-brand">VUE Praktis</a>
        <div class="form-inline">
            <a v-if="!token" @click="$router.push('/')" class="nav-link text-white">Login</a>
            <a v-if="!token" @click="$router.push('/about')" class="nav-link text-white">About</a>
            <a v-if="token" @click="$router.push('/register')" class="nav-link text-white">Add User</a>
            <a v-if="token" @click="$router.push('/dashboard')" class="nav-link text-white">Dashboard</a>
            <a v-if="token" @click="logout()" class="nav-link text-white">Logout</a>
            
        </div>
        <!-- <a href="#" class="float-right">Register<a> -->
    </nav>
</template>
<script>
import axios from 'axios';

export default {
    data () {
        return{
            token: '',
            id: '',
        }
    },

    created : function created() {
        this.token = this.getCookie('token');
        this.id = this.getCookie('userid');
    },

    methods : {
         getCookie (name){
            let a = `; ${document.cookie}`.match(`;\\s*${name}=([^;]+)`);
            return a ? a[1] : '';
        },

        logout(){
            console.log('User ID:' + this.id);
            document.cookie ="token="+'';
            document.cookie ="userid="+'';
            axios
                .get('api/logout/' + this.id)
                .then( function ()
                {
                    // this.$router.push('/');
                    window.location='/';
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
</script>
<style scoped>
    a{
        cursor: pointer;
    }
</style>