<template>
   <div>
      <h2>Edit</h2>
        <form>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Full name" >
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email">
            </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="password">
            </div>
            <button class="btn btn-info text-white btn-block">Add</button>
            <div class="btn btn-warning text-white btn-block" @click="$emit('update', false)">Cancel</div>
        </form>
   </div>
</template>
<script>
    export default {
       
    }
</script>