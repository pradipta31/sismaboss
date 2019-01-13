<template>
    <div>
        <section class="content-header">
            <h1>
                Data Absen
                <small>data-data absen UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Absen</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal" style="margin-bottom: 10px">
                                Tambah Absen
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="tambahModalLabel">Tambah Absen</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Judul Absen</label>
                                                <input type="text" v-model="data.judul_absen" class="form-control" placeholder="Masukan judul absen">
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Deskripsi</label>
                                                <textarea cols="78" rows="8" v-model="data.deskripsi" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="save">
                                                <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                                <i class="fa fa-check" v-else></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>PJ</th>
                                <th>Judul Absen</th>
                                <th>Tanggal</th>
                                <th>Absen</th>
                                <th>Opsi</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in absent" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.username}}</td>
                                    <td>{{item.judul_absen}}</td>
                                    <td>{{format(item.created_at)}}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" @click="createAbsent(item.id)">Absen</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showAbsent" @click="showAbsent(item.id)"><i class="fa fa-eye"></i></button>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAbsent" @click="editAbsent(item.id)"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-danger btn-sm" @click="deleteAbsent(item.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                            <div class="modal fade" id="showAbsent" tabindex="-1" role="dialog" aria-labelledby="showAbsentLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="showAbsentLabel">Judul Absen : {{show.judul_absen}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-6">
                                                <h4>Tanggal </h4>
                                                <h4>Deskripsi </h4>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>: {{format(show.created_at)}}</h4>
                                            </div>
                                            <textarea v-model="show.deskripsi" cols="56" rows="5" class="form-control" readonly></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="editAbsent" tabindex="-1" role="dialog" aria-labelledby="editAbsentLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="editAbsentLabel">Edit Absent {{edit.judul_absen}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Judul Absen</label>
                                                <input type="text" v-model="edit.judul_absen" class="form-control" placeholder="Masukan nama event">
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Deskripsi</label>
                                                <textarea cols="78" rows="8" v-model="edit.deskripsi" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" @click="saveEdit">
                                                <i class="fa fa-spin fa-spinner" v-if="isLoadingEdit"></i>
                                                <i class="fa fa-check" v-else></i>
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
        return {
            table: null,
            data: {
                judul_absen: '',
                deskripsi: ''
            },
            show: {
                judul_absen: '',
                user_id: '',
                created_at: '',
                deskripsi: ''
            },
            edit: {
                judul_absen: '',
                deskripsi: ''
            },
            isLoading: false,
            isLoadingEdit: false,
            absent: []
        }
    },
    mounted(){
        this.getData()
    },
    methods: {
        format(created_at){
            moment.locale('id');
            return moment(created_at).format('dddd, DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/absen')
            .then(r => {
               console.log(r);
               this.absent = r.data.absents;
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
        save(){
            this.isLoading = true
            axios.post('api/absen',this.data)
            .then(r => {
                this.data.judul_absen = '';
                this.data.deskripsi = '';
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
                console.log(e)
                toast.error('Semua kolom tidak boleh kosong!');
            })
        },
        showAbsent(id){
            axios.get(`api/absen/show/${id}`)
            .then(r => {
                console.log(r);
                this.show = r.data.absents
            })
            .catch(e => {
                console.log(e)
            })
        },
        editAbsent(id){
            axios.get(`api/absen/edit/${id}`)
            .then(r => {
                console.log(r);
                this.edit = r.data.absents
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveEdit(){
            swal({
                title: "Apakah anda yakin ingin menyimpan perubahan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((yes) => {
                if(yes){
                    axios.put('api/absen/edit/'+this.edit.id,this.edit)
                    .then(r => {
                        this.edit.judul_absen = '';
                        this.edit.deskripsi = '';
                        console.log(r)
                        swal({
                            title: "Berhasil!",
                            text: "Data absen berhasil diubah!",
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
                        console.log(e)
                        toast.error('Gagal mengubah absen');
                    })
                }
            })
        },
        deleteAbsent(id){
            swal({
                title: 'Apakah anda yakin ingin menghapus data absent ini ?',
                buttons: true,
                icon: 'info',
                dangerMode: true
            })
            .then(yes => {
                if(yes){
                    axios.delete(`api/absen/${id}`)
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
                        toast.error('Gagal menghapus data absen yang dipilih');
                    })
                }
            })
        },
        createAbsent(id){
            this.$router.push({name: 'sekretaris_absen_create',params: {id: id}});
        }
    }
}
</script>

<style>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
