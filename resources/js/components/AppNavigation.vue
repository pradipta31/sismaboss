<template>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <span v-if="user.pict">
            <img :src="'images/avatar/'+user.pict" class="profile-user-img img-responsive img-circle" alt="User Image">
          </span>
          <span v-else>
            <img src="images/logoboss.jpg" class="profile-user-img img-responsive img-circle" alt="User Image">
          </span>
        </div>
        <div class="pull-left info">
          <p>{{user.username}}</p>
          <h6>{{user.role}}</h6>
        </div>
      </div>
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
          <!-- ========== NAVIGATION ADMIN ============ -->
          <li v-if="isAdmin">
            <router-link :to="{ name: 'dashboard'}" class="dec">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </router-link>
          </li>
          <li v-if="isAdmin">
            <router-link :to="{ name: 'periode'}" class="dec">
              <i class="fa fa-bar-chart"></i> <span>Periode</span>
            </router-link>
          </li>
          
          <li class="treeview" v-if="isAdmin">
            <a href="/#/main" class="dec">
              <i class="fa fa-group"></i>
              <span>Kepengurusan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><router-link :to="{name: 'admin_ketua_create'}" class="dec"><i class="fa fa-plus"></i> Tambah Kepengurusan</router-link></li>
              <li><router-link :to="{name: 'admin_ketua_index'}" class="dec"><i class="fa fa-circle-o"></i> Data Kepengurusan</router-link></li>
            </ul>
          </li>

          <!-- ========== NAVIGATION KETUA ============ -->
          <li v-if="isKetua">
            <router-link :to="{ name: 'dashboard'}" class="dec">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </router-link>
          </li>
          <li class="treeview" v-if="isKetua">
            <a href="/#/main" class="dec">
              <i class="fa fa-users"></i>
              <span>Pengurus</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><router-link :to="{name: 'ketua_pengurus_create'}" class="dec"><i class="fa fa-plus"></i> Tambah Pengurus</router-link></li>
              <li><router-link :to="{name: 'ketua_pengurus_index'}" class="dec"><i class="fa fa-circle-o"></i> Data Pengurus</router-link></li>
            </ul>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_anggota_index'}" class="dec">
              <i class="fa fa-address-book-o"></i> <span>Anggota</span>
            </router-link>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_surat_index'}" class="dec">
              <i class="fa fa-envelope"></i> <span>Surat</span>
            </router-link>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_keuangan_index'}" class="dec">
              <i class="fa fa-money"></i> <span>Keuangan</span>
            </router-link>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_absen_index'}" class="dec">
              <i class="fa fa-address-book-o"></i> <span>Absen</span>
            </router-link>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_inventaris_index'}" class="dec">
              <i class="fa fa-gear"></i> <span>Inventaris</span>
            </router-link>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_rapat_index'}" class="dec">
              <i class="fa fa-comments"></i> <span>Rapat</span>
            </router-link>
          </li>
          <li v-if="isKetua">
            <router-link :to="{ name: 'ketua_event_index'}" class="dec">
              <i class="fa fa-table"></i> <span>Event</span>
            </router-link>
          </li>
          <!-- <li class="treeview" v-if="isKetua">
            <a href="/#/main" class="dec">
              <i class="fa fa-file"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><router-link :to="{name: 'ketua_laporan_sekretaris'}" class="dec"><i class="fa fa-circle-o"></i> Laporan Sekretaris</router-link></li>
              <li><router-link :to="{name: 'ketua_laporan_bendahara'}" class="dec"><i class="fa fa-circle-o"></i> Laporan Bendahara</router-link></li>
            </ul>
          </li> -->

          <!-- ========== NAVIGATION WAKIL ============ -->
          <li v-if="isWakil">
            <router-link :to="{ name: 'dashboard'}" class="dec">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </router-link>
          </li>
          <li v-if="isWakil">
            <router-link :to="{ name: 'wakil_anggota_index'}" class="dec">
              <i class="fa fa-address-book-o"></i> <span>Anggota</span>
            </router-link>
          </li>
          <li v-if="isWakil">
            <router-link :to="{ name: 'wakil_surat_index'}" class="dec">
              <i class="fa fa-envelope"></i> <span>Surat</span>
            </router-link>
          </li>
          <li v-if="isWakil">
            <router-link :to="{ name: 'wakil_keuangan_index'}" class="dec">
              <i class="fa fa-money"></i> <span>Keuangan</span>
            </router-link>
          </li>
          <li v-if="isWakil">
            <router-link :to="{ name: 'wakil_rapat_index'}" class="dec">
              <i class="fa fa-comments"></i> <span>Rapat</span>
            </router-link>
          </li>
          <li v-if="isWakil">
            <router-link :to="{ name: 'wakil_event_index'}" class="dec">
              <i class="fa fa-calendar"></i> <span>Event</span>
            </router-link>
          </li>

          <!-- ========== NAVIGATION SEKRETARIS ============ -->
          <li v-if="isSekretaris">
            <router-link :to="{ name: 'dashboard'}" class="dec">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </router-link>
          </li>
          <li class="treeview" v-if="isSekretaris">
            <a href="/#/main" class="dec">
              <i class="fa fa-group"></i>
              <span>Anggota</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><router-link :to="{name: 'sekretaris_anggota_create'}" class="dec"><i class="fa fa-plus"></i> Tambah Anggota</router-link></li>
              <li><router-link :to="{name: 'sekretaris_anggota_index'}" class="dec"><i class="fa fa-circle-o"></i> Data Anggota</router-link></li>
            </ul>
          </li>
          <li class="treeview" v-if="isSekretaris">
            <a href="/#/main" class="dec">
              <i class="fa fa-envelope"></i>
              <span>Surat</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><router-link :to="{name: 'sekretaris_surat_tambah'}" class="dec"><i class="fa fa-plus"></i> Tambah Surat</router-link></li>
              <li><router-link :to="{name: 'sekretaris_surat_masuk_index'}" class="dec"><i class="fa fa-circle-o"></i> Surat Masuk</router-link></li>
              <li><router-link :to="{name: 'sekretaris_surat_keluar_index'}" class="dec"><i class="fa fa-circle-o"></i> Surat Keluar</router-link></li>
            </ul>
          </li>
          <li v-if="isSekretaris">
            <router-link :to="{ name: 'sekretaris_absen_index'}" class="dec">
              <i class="fa fa-address-book-o"></i> <span>Absen</span>
            </router-link>
          </li>
          <li v-if="isSekretaris">
            <router-link :to="{ name: 'sekretaris_rapat_index'}" class="dec">
              <i class="fa fa-comments"></i> <span>Rapat</span>
            </router-link>
          </li>
          <li v-if="isSekretaris">
            <router-link :to="{ name: 'sekretaris_inventaris_index'}" class="dec">
              <i class="fa fa-gear"></i> <span>Inventaris</span>
            </router-link>
          </li>
          <li v-if="isSekretaris">
            <router-link :to="{ name: 'sekretaris_event_index'}" class="dec">
              <i class="fa fa-calendar"></i> <span>Event</span>
            </router-link>
          </li>
          <!-- <li class="treeview" v-if="isSekretaris">
            <a href="#" class="dec">
              <i class="fa fa-file"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display: none;">
              <li><router-link :to="{name: 'sekretaris_surat_tambah'}" class="dec"><i class="fa fa-plus"></i> Tambah Laporan</router-link></li>
              <li><router-link :to="{name: 'sekretaris_surat_masuk_index'}" class="dec"><i class="fa fa-circle-o"></i> Data Laporan</router-link></li>
            </ul>
          </li> -->
          

          <!-- ========== NAVIGATION BENDAHARA ============ -->
          <li v-if="isBendahara">
            <router-link :to="{ name: 'dashboard'}" class="dec">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </router-link>
          </li>
          <li v-if="isBendahara">
            <router-link :to="{ name: 'bendahara_keuangan_index'}" class="dec">
              <i class="fa fa-money"></i> <span>Keuangan</span>
            </router-link>
          </li>
          <!-- <li v-if="isBendahara">
            <router-link :to="{ name: 'bendahara_pemasukan_index'}" class="dec">
              <i class="fa fa-download"></i> <span>Pemasukan</span>
            </router-link>
          </li>
          <li v-if="isBendahara">
            <router-link :to="{ name: 'bendahara_pengeluaran_index'}" class="dec">
              <i class="fa fa-upload"></i> <span>Pengeluaran</span>
            </router-link>
          </li>
          <li v-if="isBendahara">
            <router-link :to="{ name: 'bendahara_kas_index'}" class="dec">
              <i class="fa fa-money"></i> <span>Kas</span>
            </router-link>
          </li> -->
          <!-- <li v-if="isBendahara">
            <router-link :to="{ name: 'bendahara_laporan_index'}" class="dec">
              <i class="fa fa-file "></i> <span>Laporan</span>
            </router-link>
          </li> -->
        
      </ul>
    </section>
  </aside>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
  mounted(){
    this.checkAuth()
  },
  computed: {
    ...mapGetters([
      'user'
    ]),
    isAdmin(){
      return this.$store.state.auth.role == 'admin'
    },
    isKetua(){
      return this.$store.state.auth.role == 'ketua'
    },
    isWakil(){
      return this.$store.state.auth.role == 'wakil'
    },
    isSekretaris(){
      return this.$store.state.auth.role == 'sekretaris'
    },
    isBendahara(){
      return this.$store.state.auth.role == 'bendahara'
    }
  }
}
</script>

<style scoped>
  .dec{
    text-decoration: none;
  }
  .profile-user-img{
    width: 55px;
    height: 55px;
  }
</style>
