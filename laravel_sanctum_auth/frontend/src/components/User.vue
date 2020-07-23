<template>
    <div>
        <div v-if="isEdit">
            <h2>Edit</h2>
            <form>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Full name" required v-model="user.name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" required v-model="user.email">
            </div>
            <div class="btn btn-info text-white btn-block" @click="updateUser(user.id)">Add</div>
            <div class="btn btn-warning text-white btn-block" @click="isEdit=false">Cancel</div>
            </form>
        </div>
        <h1 class="mb3">View all User</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            
                <tr v-for="user in users" :key="user.id">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>
                        <button class="btn btn-primary" @click="isEdit=true;setData(user)">Edit</button> 
                        <button class="btn btn-danger" @click.prevent="deleteUser(user.id)">Delete</button>
                    </td>
                </tr>
        </table>
        
    </div>

</template>

<script>
import axios from 'axios';

export default {
    name: 'Users',
    data() {
        return{
            users: null,
            isEdit: false,
            user: {
                'id': '',
                'name': '',
                'email': '',
            }
        }
    },
    created (){
        this.getUsers()
    },
    methods : {
        getUsers(){
            var token = this.getCookie('token');

            axios
                .get('api/users',{
                    headers: {
                        'Authorization': token,
                    }
                }
                )
                .then(res => {
                    // console.log(res);
                    const {data:{data}} = res;
                    this.users = data;
                    // console.log(this.users);
                })
                .catch(err => {
                    console.log(err);
                    if (err.response.status === 401) {
                        alert('Sorry you are unauthorized for this function');
                        window.location='/';
                        document.cookie ="token="+'';
                    }
                })
        },

        setData(user){
            this.user.id = user.id;
            this.user.name = user.name;
            this.user.email = user.email;
        },

        updateUser(){
            var token = this.getCookie('token');
            var user = this.user;
            // console.log(user.id);
            axios
                .post('api/user/'+ user.id, user, {
                    headers: {
                        'Authorization': token,
                    }
                })
                .then(res=>{
                    console.log(res.data);
                    alert('sucessfully updated');
                    this.isEdit=false;
                    this.getUsers();
                })
                 .catch(err => {
                    console.log(err);
                    if (err.response.status === 401) {
                        alert('Sorry you are unauthorized for this function');
                        window.location='/';
                        document.cookie ="token="+'';
                    }
                })
                
        },

        deleteUser(id){
            var token = this.getCookie('token');

            axios
            .delete('api/user/'+ id, {
                headers: {
                    'Authorization': token,
                }
            })
            .then(res => {
                alert('Sucessfully deleted');
                const data = res;
                console.log(data);
                this.getUsers();
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

<style>

</style>