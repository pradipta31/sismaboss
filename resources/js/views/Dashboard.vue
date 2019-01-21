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
                        <h4 class="alert-heading">Selamat datang {{user.name}} di Sistem Informasi Manajemen UKM BOSS!</h4>
                        <p>jabatan anda adalah sebagai {{user.role}} hanya dapat mengakses beberapa menu saja. Sistem ini hanya digunakan untuk manajemen data-data inventaris dari UKM BOSS!</p>
                        <hr>
                        <p class="mb-0">Mohon untuk menggunakan sistem dengan baik demi menciptakan kenyamanan bersama.</p>
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
