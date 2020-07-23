<template>
        <div class="justify-content-center">
            <h2>Login</h2>
            <div class="alert alert-danger" v-if="errors">
                <p>{{ errors }}</p>
            </div>
            <form  class="mb-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="email" required v-model="user.email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="password" required v-model="user.password">
                </div>
                <div type="submit" class="btn btn-info text-white btn-block" @click="login()">Login</div>
            </form>
        </div>
</template>
<script>
import axios from 'axios';

export default {
    data(){
        return{
            user : [
                'email',
                'password'
            ],
            errors: '',
        }
    },

    methods : {
        login(){
            var user = {};
            user['email'] = this.user.email;
            user['password'] = this.user.password;

            // console.log(user);
            axios
                .post('api/login', user)
                .then(res => {
                    this.errors = res.data.message;
                    if(!this.errors){
                        document.cookie ="token=Bearer "+res.data.token;
                        document.cookie="userid="+res.data.user.id;
                        console.log(this.getCookie('userid'));
                        window.location='/dashboard';
                        // this.$router.push('/dashboard');
                    }
                    
                })
                .catch(err => {
                    console.log(err);
                })
        },

        getCookie (name){
            let a = `; ${document.cookie}`.match(`;\\s*${name}=([^;]+)`);
            return a ? a[1] : '';
        }
    }
}
</script>