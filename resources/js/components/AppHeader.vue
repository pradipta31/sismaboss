<template>
  <header class="main-header">
    <a href="/#/main" class="logo" style="text-decoration: none">
      <span class="logo-mini"><b>BOSS</b></span>
      <span class="logo-lg"><b>UKM</b>BOSS</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="text-decoration: none">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span v-if="user.pict">
                <img :src="'images/avatar/'+user.pict" class="user-image" alt="User Image">
              </span>
              <span v-else>
                <img src="images/logoboss.jpg" class="user-image" alt="User Image">
              </span>
              <span class="hidden-xs">{{user.username}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <span v-if="user.pict">
                  <img :src="'images/avatar/'+user.pict" class="profile-user-img img-responsive img-circle" alt="User Image">
                </span>
                <span v-else>
                  <img src="images/logoboss.jpg" class="profile-user-img img-responsive img-circle" alt="User Image">
                </span>
                <p>
                  {{user.name}}
                  <small><b>{{user.role}}</b></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="javascript:void(0)" @click="showProfile(user.id)" class="btn btn-default">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="javascript:void(0);" @click="logout" class="btn btn-default">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    mounted(){
        this.checkAuth();
    },
    computed:{
      ...mapGetters([
            'user'
        ])
    },
    methods:{
        logout(){
            axios.post('api/auth/logout')
            .then(r => {
                toast.success('Logout berhasil!');
                this.$localStorage.remove('access_token');
                this.$cookies.remove('sismaboss_auth_data');
                this.$cookies.remove('sismaboss_token');
                this.$router.push({name: 'login'});
                window.location.reload();
            })
            .catch(e => {
                toast.error(e);
                this.$localStorage.remove('access_token');
                this.$cookies.remove('sismaboss_auth_data');
                this.$cookies.remove('sismaboss_token');
                window.location.reload();
            })
        },
        showProfile(id){
          this.$router.push({name: 'profile_index',params: {id: id}});
        }
    }
}
</script>

<style>

</style>
