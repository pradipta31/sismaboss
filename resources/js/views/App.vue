<template>
    <div>
        <app-header></app-header>
        <app-navigation></app-navigation>
        <div class="content-wrapper">
            <router-view></router-view>
        </div>
        <app-footer></app-footer>
    </div>
</template>

<script>
import AppHeader from './../components/AppHeader'
import AppNavigation from './../components/AppNavigation'
import AppFooter from './../components/AppFooter'
export default {
    mounted(){
        document.body.className = 'hold-transition sidebar-mini skin-blue';
        document.getElementById('app').className = 'wrapper';
    },
    components:{
        AppHeader,
        AppNavigation,
        AppFooter
    },
}
</script>

<style>
    .content-wrapper{
        min-height: 916.3px;
    }
</style>
