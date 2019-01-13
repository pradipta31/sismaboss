import Vue from 'vue'
import Router from 'vue-router'
import Login from './views/Login'
import Main from './views/App'
import Dashboard from './views/Dashboard'
import Profile from './views/Profile'
/**
 * ==================== ADMIN =====================
 */
import Periode from './views/admin/periode/periode'
import TambahKetua from './views/admin/ketua/CreateKetua'
import IndexKetua from './views/admin/ketua/IndexKetua'
import EditKetua from './views/admin/ketua/EditKetua'

/**
 * ==================== KETUA =====================
 */
import IndexPengurus from './views/ketua/pengurus/IndexPengurus'
import TambahPengurus from './views/ketua/pengurus/CreatePengurus'
import EditPengurus from './views/ketua/pengurus/EditPengurus'
import IndexEventKetua from './views/ketua/event/IndexEvent'
import IndexRapatKetua from './views/ketua/rapat/IndexRapat'
import KetuaIndexKeuangan from './views/ketua/keuangan/IndexKeuangan'
import KetuaIndexSurat from './views/ketua/surat/IndexSurat'
import KetuaIndexAnggota from './views/ketua/anggota/IndexAnggota'


/**
 * ==================== WAKIL KETUA =====================
 */

import IndexEventWakil from './views/wakil/event/IndexEvent'
import IndexRapatWakil from './views/wakil/rapat/IndexRapat'
import WakilIndexAnggota from './views/wakil/anggota/IndexAnggota'
import WakilIndexKeuangan from './views/wakil/keuangan/IndexKeuangan'
import WakilIndexSurat from './views/wakil/surat/IndexSurat'

/**
 * ==================== SEKRETARIS =====================
 */
import TambahAnggota from './views/sekretaris/anggota/CreateMember'
import IndexAnggota from './views/sekretaris/anggota/IndexMember'
import TambahSurat from './views/sekretaris/surat/TambahSurat'
import SuratMasuk from './views/sekretaris/surat/SuratMasuk'
import SuratKeluar from './views/sekretaris/surat/SuratKeluar'
import IndexRapat from './views/sekretaris/rapat/IndexRapat'
import IndexEvent from './views/sekretaris/event/IndexEvent'
import IndexAbsen from './views/sekretaris/absen/IndexAbsen'
import TambahAbsen from './views/sekretaris/absen/TambahAbsen'
import TambahInventaris from './views/sekretaris/inventaris/TambahInventaris'
import IndexInventaris from './views/sekretaris/inventaris/IndexInventaris'

/**
 * ==================== BENDAHARA =====================
 */
import IndexKeuanganBendahara from './views/bendahara/keuangan/IndexKeuangan'

Vue.use(Router);
export default new Router({
    routes: [
        {
            path: '/',
            component: Login,
            name: 'login'
        },
        {
            path: '/main',
            component: Main,
            children: [
                {
                    path: '',
                    component: Dashboard,
                    name: 'dashboard'
                },
                {
                    path: 'profile/:id',
                    component: Profile,
                    name: 'profile_index'
                },
                {
                    path: 'admin/periode',
                    component: Periode,
                    name: 'periode'
                },
                {
                    path: 'admin/ketua/tambah-ketua',
                    component: TambahKetua,
                    name: 'admin_ketua_create'
                },
                {
                    path: 'admin/ketua',
                    component: IndexKetua,
                    name: 'admin_ketua_index'
                },
                {
                    path: 'admin/ketua/:id/edit',
                    component: EditKetua,
                    name: 'admin_edit_ketua'
                },
                {
                    path: 'ketua/pengurus/tambah-pengurus',
                    component: TambahPengurus,
                    name: 'ketua_pengurus_create'
                },
                {
                    path: 'ketua/pengurus',
                    component: IndexPengurus,
                    name: 'ketua_pengurus_index'
                },
                {
                    path: 'ketua/pengurus/:id/edit',
                    component: EditPengurus,
                    name: 'ketua_pengurus_edit'
                },
                {
                    path: 'ketua/keuangan',
                    component: KetuaIndexKeuangan,
                    name: 'ketua_keuangan_index'
                },
                {
                    path: 'ketua/surat',
                    component: KetuaIndexSurat,
                    name: 'ketua_surat_index'
                },
                {
                    path: 'ketua/rapat',
                    component: IndexRapatKetua,
                    name: 'ketua_rapat_index'
                },
                {
                    path: 'ketua/event',
                    component: IndexEventKetua,
                    name: 'ketua_event_index'
                },
                {
                    path: 'ketua/anggota',
                    component: KetuaIndexAnggota,
                    name: 'ketua_anggota_index'
                },
                {
                    path: 'wakil/event',
                    component: IndexEventWakil,
                    name: 'wakil_event_index'
                },
                {
                    path: 'wakil/surat',
                    component: WakilIndexSurat,
                    name: 'wakil_surat_index'
                },
                {
                    path: 'wakil/anggota',
                    component: WakilIndexAnggota,
                    name: 'wakil_anggota_index'
                },
                {
                    path: 'wakil/keuangan',
                    component: WakilIndexKeuangan,
                    name: 'wakil_keuangan_index'
                },
                {
                    path: 'wakil/rapat',
                    component: IndexRapatWakil,
                    name: 'wakil_rapat_index'
                },
                {
                    path: 'sekretaris/anggota/tambah-anggota',
                    component: TambahAnggota,
                    name: 'sekretaris_anggota_create'
                },
                {
                    path: 'sekretaris/anggota',
                    component: IndexAnggota,
                    name: 'sekretaris_anggota_index'
                },
                {
                    path: 'sekretaris/surat/tambah-surat',
                    component: TambahSurat,
                    name: 'sekretaris_surat_tambah'
                },
                {
                    path: 'sekretaris/surat-masuk',
                    component: SuratMasuk,
                    name: 'sekretaris_surat_masuk_index'
                },
                {
                    path: 'sekretaris/surat-keluar',
                    component: SuratKeluar,
                    name: 'sekretaris_surat_keluar_index'
                },
                {
                    path: 'sekretaris/rapat',
                    component: IndexRapat,
                    name: 'sekretaris_rapat_index'
                },
                {
                    path: 'sekretaris/event',
                    component: IndexEvent,
                    name: 'sekretaris_event_index'
                },
                {
                    path: 'sekretaris/absen',
                    component: IndexAbsen,
                    name: 'sekretaris_absen_index'
                },
                {
                    path: 'sekretaris/absen/tambah/:id',
                    component: TambahAbsen,
                    name: 'sekretaris_absen_create'
                },
                {
                    path: 'sekretaris/inventaris/tambah-inventaris',
                    component: TambahInventaris,
                    name: 'sekretaris_inventaris_tambah'
                },
                {
                    path: 'sekretaris/inventaris',
                    component: IndexInventaris,
                    name: 'sekretaris_inventaris_index'
                },
                {
                    path: 'bendahara/keuangan',
                    component: IndexKeuanganBendahara,
                    name: 'bendahara_keuangan_index'
                },
            ]
        }
    ]
    
})