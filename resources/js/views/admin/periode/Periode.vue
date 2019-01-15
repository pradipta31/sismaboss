<template>
    <div>
        <section class="content-header">
            <h1>
                Data Periode
                <small>data-data periode UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Periode</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-md-5">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-ttitle">
                                    Tambah Periode
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <input type="text" v-model="data.periode" class="form-control" placeholder="Masukan Periode">
                                    <h6>Contoh: 2015/2016</h6>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" @click="save">
                                    <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                    <i class="fa fa-check" v-else></i>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Data Periode UKM BOSS</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Periode</th>
                                        <th>Dibuat Pada Tanggal</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(prd, index) in periode" :key="index">
                                            <td>{{index+1}}</td>
                                            <td>{{prd.periode}}</td>
                                            <td>{{format(prd.created_at)}}</td>
                                            <td v-if="prd.status === 'aktif'">
                                                <span class="label label-success">Aktif</span>
                                            </td>
                                            <td v-else>
                                                <span class="label label-warning">Tidak Aktif</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPeriode" @click="editPeriode(prd.id)">Edit</button>
                                                <!-- <a href="javascript:void(0);" class="btn btn-danger btn-sm" @click="deletePeriode(prd.id)">Hapus</a> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <div class="modal fade" id="editPeriode" tabindex="-1" role="dialog" aria-labelledby="editPeriodeLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="editPeriodeLabel">Edit Periode {{edit.periode}}</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Periode</label>
                                                                <input type="text" v-model="edit.periode" class="form-control" placeholder="Masukan periode">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Status</label>
                                                                <select class="form-control" v-model="edit.status">
                                                                    <option value="aktif">Aktif</option>
                                                                    <option value="nonaktif">Non Aktif</option>
                                                                </select>
                                                            </div>
                                                        </div>
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
            </div>
        </section>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    mounted(){
        this.getData();
    },
    data(){
        return {
            table: null,
            data:{
                periode: ''
            },
            edit:{
                periode: '',
                status: ''
            },
            isLoading: false,
            isLoadingEdit: false,
            periode: []
        }
    },
    methods: {
        save(){
            this.isLoading = true;
            axios.post('api/periode',this.data)
            .then(r => {
                this.isLoading = false;
                this.getData(true);
                toast.success(r.data.message);
            })
            .catch(e => {
                toast.error('Data periode sudah ada!');
                this.isLoading = false;
            })
        },
        format(created_at){
            return moment(created_at).format('DD MMMM YYYY');
        },
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/periode')
            .then(r => {
               console.log(r);
               this.periode = r.data.periodes;
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
        editPeriode(id){
            axios.get(`api/periode/edit/${id}`)
            .then(r => {
                console.log(r);
                this.edit = r.data.periodes
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveEdit(id){
            swal({
                title: "Apakah anda yakin ingin menyimpan perubahan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((yes) => {
                if(yes){
                    axios.put('api/periode/edit/'+this.edit.id,this.edit)
                    .then(r => {
                        this.edit.periode = '';
                        this.edit.status = '';
                        console.log(r)
                        swal({
                            title: "Berhasil!",
                            text: "Data Periode berhasil diubah!",
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
                        toast.error('Gagal mengubah data periode');
                    })
                }
            })
        },
        deletePeriode(id){
            swal({
                title: "Apakah anda yakin ?",
                text: "Menghapus periode akan menghapus data-data pengurus",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((asDelete) => {
                if(asDelete){
                    axios.delete(`api/periode/${id}`)
                    .then(r => {
                        this.getData();
                        swal(r.data.message, {icon: "success"});
                    })
                    .catch(e => {
                        toast.error('Gagal menghapus periode');
                    })
                }
            })
        }
    }
}
</script>

<style>

</style>
