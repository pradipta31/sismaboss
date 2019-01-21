<template>
    <div>
        <section class="content-header">
            <h1>
                Data Event
                <small>data-data event UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Event</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal" style="margin-bottom: 10px">
                                Tambah Event
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="tambahModalLabel">Tambah Event</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama Event</label>
                                                <input type="text" v-model="data.nama_event" class="form-control" placeholder="Masukan nama event">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Ketua Panitia</label>
                                                <input type="text" v-model="data.ketua_panitia" class="form-control" placeholder="Masukan nama ketua panitia">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tanggal Event</label>
                                                <div class="col-md-12">
                                                    <div class="col-md-5">
                                                        <input type="date" v-model="data.tgl_mulai" class="form-control" style="margin-left: -30px">
                                                    </div>
                                                    <div class="col-md-1" style="margin-left: -50px; margin-top: 5px">
                                                        <b>s/d</b>
                                                    </div>
                                                    <div class="col-md-5" style="margin-left: -20px">
                                                        <input type="date" v-model="data.tgl_akhir" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">Deskripsi Event</label>
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
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>PJ</th>
                                    <th>Nama Event</th>
                                    <th>Ketua Panitia</th>
                                    <th>Tanggal Event</th>
                                    <th>Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(e, index) in event" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{e.periode}}</td>
                                        <td>{{e.username}}</td>
                                        <td>{{e.nama_event}}</td>
                                        <td>{{e.ketua_panitia}}</td>
                                        <td v-if="e.tgl_akhir">
                                            {{tglMulai(e.tgl_mulai)}} s/d {{tglAkhir(e.tgl_akhir)}}
                                        </td>
                                        <td v-else>
                                            {{tglAkhir(e.tgl_mulai)}}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showEvent" @click="showEvent(e.id)"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editEvent" @click="editEvent(e.id)"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" @click="deleteEvent(e.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            <div class="modal fade" id="showEvent" tabindex="-1" role="dialog" aria-labelledby="showEventLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="showEventLabel">Nama Event : {{show.nama_event}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-md-6">
                                                                <h4>Tanggal Event </h4>
                                                                <h4>Nama Ketua Panitia </h4>
                                                                <h4>Deskripsi Event </h4>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h4 v-if="show.tgl_akhir">: 
                                                                    {{tglMulai(show.tgl_mulai)}} s/d {{tglAkhir(show.tgl_akhir)}}
                                                                </h4>
                                                                <h4 v-else>: 
                                                                    {{tglAkhir(show.tgl_mulai)}}
                                                                </h4>
                                                                <h4>: {{show.ketua_panitia}}</h4>
                                                            </div>
                                                            <textarea v-model="show.deskripsi" cols="78" rows="8" class="form-control" readonly></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                                <div class="modal fade" id="editEvent" tabindex="-1" role="dialog" aria-labelledby="editEventLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="editEventLabel">Edit Event {{edit.nama_event}}</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Nama Event</label>
                                                    <input type="text" v-model="edit.nama_event" class="form-control" placeholder="Masukan nama event">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Ketua Panitia</label>
                                                    <input type="text" v-model="edit.ketua_panitia" class="form-control" placeholder="Masukan nama ketua panitia">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tanggal Event</label>
                                                    <div class="col-md-12">
                                                        <div class="col-md-5">
                                                            <input type="date" v-model="edit.tgl_mulai" class="form-control" style="margin-left: -30px">
                                                        </div>
                                                        <div class="col-md-1" style="margin-left: -50px; margin-top: 5px">
                                                            <b>s/d</b>
                                                        </div>
                                                        <div class="col-md-5" style="margin-left: -20px">
                                                            <input type="date" v-model="edit.tgl_akhir" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" style="margin-top: 10px">Deskripsi Event</label>
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
                nama_event: '',
                ketua_panitia: '',
                tgl_mulai: '',
                tgl_akhir: '',
                deskripsi: ''
            },
            show: {
                nama_event: '',
                ketua_panitia: '',
                tgl_mulai: '',
                tgl_akhir: '',
                deskripsi: ''
            },
            edit: {
                nama_event: '',
                ketua_panitia: '',
                tgl_mulai: '',
                tgl_akhir: '',
                deskripsi: ''
            },
            isLoading: false,
            isLoadingEdit: false,
            event: []
        }
    },
    mounted(){
        this.getData()
    },
    methods: {
        tglMulai(tgl_mulai){
            return moment(tgl_mulai).format('DD');
        },
        tglAkhir(tgl_akhir){
            moment.locale('id');
            return moment(tgl_akhir).format('DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/event')
            .then(r => {
               console.log(r);
               this.event = r.data.events;
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
            axios.post('api/event',this.data)
            .then(r => {
                this.data.nama_event = '';
                this.data.ketua_panitia = '';
                this.data.tgl_mulai = '';
                this.data.tgl_akhir = '';
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
        showEvent(id){
            axios.get(`api/event/${id}`)
            .then(r => {
                console.log(r);
                this.show = r.data.events
            })
            .catch(e => {
                console.log(e)
            })
        },
        editEvent(id){
            axios.get(`api/event/edit/${id}`)
            .then(r => {
                console.log(r);
                this.edit = r.data.events
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
                    axios.put('api/event/edit/'+this.edit.id,this.edit)
                    .then(r => {
                        this.edit.nama_event = '';
                        this.edit.ketua_panitia = '';
                        this.edit.tgl_mulai = '';
                        this.edit.tgl_akhir = '';
                        this.edit.deskripsi = '';
                        console.log(r)
                        swal({
                            title: "Berhasil!",
                            text: "Data Event berhasil diubah!",
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
                        toast.error('Gagal mengubah event');
                    })
                }
            })
        },
        deleteEvent(id){
            swal({
                title: 'Apakah anda yakin ingin menghapus data event ini ?',
                buttons: true,
                icon: 'info',
                dangerMode: true
            })
            .then(yes => {
                if(yes){
                    axios.delete(`api/event/${id}`)
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
                        toast.error('Gagal menghapus data event yang dipilih');
                    })
                }
            })
        }
    }
}
</script>

<style>
    input[type="date"].form-control{
        line-height: 14px;
    }
</style>
