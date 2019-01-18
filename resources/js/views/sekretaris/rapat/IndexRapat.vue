<template>
    <div>
        <section class="content-header">
            <h1>
                Manajemen Data Rapat
                <small>manajemen data rapat</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path: '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Rapat</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="box-header">
                                <h3 class="box-ttitle">
                                    Tambah Data Rapat
                                </h3>
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="">Judul Rapat</label>
                                        <input type="text" v-model="data.judul_rapat" class="form-control" placeholder="Masukan judul rapat">
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="">Tanggal Rapat</label>
                                        <input type="date" v-model="data.tgl_rapat" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="">Pemimpin Rapat</label>
                                        <input type="text" v-model="data.moderator" class="form-control" placeholder="Masukan pemimpin rapat">
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="">Jumlah Kehadiran</label>
                                        <input type="number" v-model="data.jumlah_hadir" class="form-control" placeholder="Masukan jumlah anggota" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="">Hasil Rapat</label>
                                        <textarea v-model="data.hasil_rapat" rows="8" class="form-control"></textarea>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" @click="save" style="margin-left: 15px">
                                    <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                    <i class="fa fa-check" v-else></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Rapat UKM BOSS</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="15px">No</th>
                                    <th>Periode</th>
                                    <th>PJ</th>
                                    <th>Judul Rapat</th>
                                    <th>Tanggal</th>
                                    <th>Pemimpin Rapat</th>
                                    <th>Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(rapat, index) in meeting" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{rapat.periode}}</td>
                                        <td>{{rapat.username}}</td>
                                        <td>{{rapat.judul_rapat}}</td>
                                        <td>{{format(rapat.tgl_rapat)}}</td>
                                        <td>{{rapat.moderator}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showModal(rapat.id)"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModalEdit" @click="editRapat(rapat.id)"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" @click="deleteRapat(rapat.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="exampleModalLabel">Judul Rapat : {{modal.judul_rapat}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-6">
                                                                <h4>Tanggal Rapat </h4>
                                                                <h4>Jumlah Anggota Hadir </h4>
                                                                <h4>Pemimpin Rapat </h4>
                                                                <h4>Hasil Rapat </h4>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4>: {{format(modal.tgl_rapat)}}</h4>
                                                                <h4>: {{modal.jumlah_hadir}} Orang</h4>
                                                                <h4>: {{modal.moderator}}</h4>
                                                            </div>
                                                            <textarea v-model="modal.hasil_rapat" cols="78" rows="15" class="form-control" readonly></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="exampleModalLabel">Edit Data Rapat : {{edit.judul_rapat}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="">Judul Rapat</label>
                                                                        <input type="text" v-model="edit.judul_rapat" rows="8" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="">Tanggal Rapat</label>
                                                                        <input type="date" v-model="edit.tgl_rapat" rows="8" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="">Jumlah Anggota Hadir</label>
                                                                        <input type="number" v-model="edit.jumlah_hadir" rows="8" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="">Pemimpin Rapat</label>
                                                                        <input type="text" v-model="edit.moderator" rows="8" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="col-md-12">
                                                                            <label for="">Hasil Rapat</label>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <textarea v-model="edit.hasil_rapat" cols="78" rows="15" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" @click="saveEdit" style="margin-left: 15px">
                                                                <i class="fa fa-spin fa-spinner" v-if="isLoadingEdit"></i>
                                                                <i class="fa fa-check" v-else></i>
                                                                Simpan
                                                            </button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data(){
        return{
            table: null,
            data: {
                judul_rapat: '',
                tgl_rapat: '',
                moderator: '',
                jumlah_hadir: '',
                hasil_rapat: ''
            },
            modal: {
                judul_rapat: '',
                tgl_rapat: '',
                moderator: '',
                jumlah_hadir: '',
                hasil_rapat: ''
            },
            edit: {
                judul_rapat: '',
                tgl_rapat: '',
                moderator: '',
                jumlah_hadir: '',
                hasil_rapat: ''
            },
            isLoading: false,
            isLoadingEdit: false,
            meeting: []
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        save(){
            this.isLoading = true
            axios.post('api/rapat',this.data)
            .then(r => {
                this.isLoading = false;
                swal({
                    title: "Berhasil!",
                    text: r.data.message,
                    icon: "success",
                })
                .then((berhasil) => {
                    if(berhasil){
                        this.getData(true);
                    }
                })
            })
            .catch(e => {
                this.isLoading = false;
                toast.error('Semua kolom tidak boleh kosong!');
            })
        },
        format(created_at){
            moment.locale('id');
            return moment(created_at).format('DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/rapat')
            .then(r => {
               console.log(r);
               this.meeting = r.data.meetings;
            })
            .catch(e => {
                console.log(e);
            })
            .finally(() => {
                if(this.table == null){
                    this.table = $('table').dataTable();
                }else{
                    this.table.rows().invalidate().draw();
                }
            })
        },
        showModal(id){
            axios.get(`api/rapat/${id}`)
            .then(r => {
                console.log(r);
                this.modal = r.data.meetings
            })
            .catch(e => {
                console.log(e)
            })
        },
        editRapat(id){
            axios.get(`api/rapat/edit/${id}`)
            .then(r => {
                console.log(r);
                this.edit = r.data.rapats
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveEdit(id){
            swal({
                title: "Apakah anda yakin ingin menyimpan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((yes) => {
                if(yes){
                    axios.put('api/rapat/edit/'+this.edit.id,this.edit)
                    .then(r => {
                        this.edit.judul_rapat = '';
                        this.edit.tgl_rapat = '';
                        this.edit.moderator = '';
                        this.edit.jumlah_hadir = '';
                        this.edit.hasil_rapat = '';

                        swal({
                            title: "Berhasil!",
                            text: "Data rapat berhasil diubah!",
                            icon: "success",
                        })
                        .then((berhasil) => {
                            if(berhasil){
                                this.getData(true);
                            }
                        })
                        
                    })
                    .catch(e => {
                        this.isLoading = false;
                        console.log(this.$route.params.id)
                        toast.error('Gagal mengubah data rapat');
                    })
                }
            })
        },
        deleteRapat(id){
            swal({
                title: 'Apakah anda yakin ingin menghapus data rapat ini ?',
                buttons: true,
                icon: 'info',
                dangerMode: true
            })
            .then(yes => {
                if(yes){
                    axios.delete(`api/rapat/${id}`)
                    .then(r => {
                        swal({
                            title: "Berhasil!",
                            text: r.data.message,
                            icon: "success",
                        })
                        .then((berhasil) => {
                            if(berhasil){
                                this.getData(true);
                            }
                        })
                    })
                    .catch(e => {
                        console.log(e);
                        toast.error('Gagal menghapus data rapat yang dipilih');
                    })
                }
            })
        }
    }
}
</script>

<style scoped>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
