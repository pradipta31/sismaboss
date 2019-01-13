<template>
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class ="alert alert-success" role="alert">
                        <h4 class="alert-heading">Well done {{user.name}}!</h4>
                        <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                    </div>
                </div>
            </div>
        </section>
    </section>
    
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    mounted(){
        this.checkAuth()
    },
    computed:{
        ...mapGetters([
            'user'
        ])
    }
}
</script>

<style>

</style>
