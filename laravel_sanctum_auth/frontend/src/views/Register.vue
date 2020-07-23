<template>
    <div class="justify-content-center">
        <h2>Add User</h2>
        <form  class="mb-3">
            <div class="form-group">
                <label for="name" class="col-md-4 col-form-label">User Email</label>
                <input type="text" class="form-control" placeholder="Full name" required v-model="user.name">
            </div>
            <div class="form-group">
                <label for="email" class="col-md-4 col-form-label">User Email</label>
                <input type="email" class="form-control" placeholder="Email" required v-model="user.email">
            </div>
              <div class="form-group">
                    <label for="role" class="col-md-4 col-form-label">User Role</label>
                    <select class="form-control" name="role" @change="onChange($event)">
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="guest">Guest</option>
                    </select>
                </div>
            <div class="btn btn-info text-white btn-block" @click="create()">Register</div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';


export default {
    data() {
       return{
            user: {
                'name': '',
                'email': '',
                'role': '',
            }
       }
    },

    methods: {

        onChange(event) {
           this.user.role = event.target.value;
        },

        create(){
            var _this = this;
            var user = _this.user;
            var token = this.getCookie('token');

            // alert(user);
            axios
                .post('api/create', user ,{
                    headers: {
                        'Authorization': token,
                    }
                })
                .then( function ()
                {
                    alert('Sucessfully added');
                    _this.user.name = '';
                    _this.user.email = '';
                    _this.user.role = null;
                })
                .catch(err => {
                    if (err.response.status === 401) {
                        alert('Sorry you are unauthorized for this function');
                        window.location='/';
                        document.cookie ="token="+'';
                    }

                })
            
        },

        getCookie (name){
            let a = `; ${document.cookie}`.match(`;\\s*${name}=([^;]+)`);
            return a ? a[1] : '';
        }
    }
}
</script>

<style scoped>

</style>