<template>
    <div>
        <section class="content-header">
            <h1>
                Data Anggota
                <small>data anggota UKM BOSS</small>
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
                            <router-link class="btn btn-primary" :to="{name: 'sekretaris_anggota_create'}" style="margin-bottom: 10px">
                                Tambah Anggota
                            </router-link>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>Nama</th>
                                        <th>Nim</th>
                                        <th>No Telp</th>
                                        <th>Opsi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(member, index) in anggota" :key="index">
                                            <td>{{index+1}}</td>
                                            <td>{{member.periode}}</td>
                                            <td>{{member.name}}</td>
                                            <td>{{member.nim}}</td>
                                            <td v-if="member.handphone">
                                                {{member.handphone}}
                                            </td>
                                            <td v-else>
                                                -
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMember" @click="editMember(member.id)"><i class="fa fa-pencil"></i></button>
                                                <button class="btn btn-danger btn-sm" @click="deleteMember(member.id)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="editMember" tabindex="-1" role="dialog" aria-labelledby="editMemberLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="editMemberLabel">Edit Anggota {{edit.name}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Nama</label>
                                                <input type="text" v-model="edit.name" class="form-control" placeholder="Masukan nama anggota">
                                            </div>
                                            <div class="form-group">
                                                <label for="">NIM</label>
                                                <input type="number" v-model="edit.nim" class="form-control" placeholder="Masukan nim anggota">
                                            </div>
                                            <div class="form-group">
                                                <label for="" style="margin-top: 10px">No Telepon</label>
                                                <input type="text" v-model="edit.handphone" class="form-control" placeholder="Masukan nomor telepon anggota">
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
export default {
    data(){
        return {
            table: null,
            data:{
                name: '',
                nim: '',
                handphone: ''
            },
            edit:{
                name: '',
                nim: '',
                handphone: ''
            },
            form: new FormData(),
            isLoading: false,
            isLoadingUploadFile: false,
            isLoadingEdit: false,
            anggota: []
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/anggota')
            .then(r => {
               console.log(r);
               this.anggota = r.data.members;
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
        showMember(id){
            axios.get(`api/anggota/${id}`)
            .then(r => {
                console.log(r);
                this.show = r.data.members
            })
            .catch(e => {
                console.log(e)
            })
        },
        editMember(id){
            axios.get(`api/anggota/edit/${id}`)
            .then(r => {
                this.edit = r.data.members
            })
            .catch(e => {
                console.log(e)
            })
        },
        saveEdit(){
            axios.put('api/anggota/edit/'+this.edit.id,this.edit)
            .then(r => {
                this.edit.nama = '';
                this.edit.nim = '';
                this.edit.handphone = '';
                console.log(r)
                swal({
                    title: "Berhasil!",
                    text: "Data Anggota berhasil diubah!",
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
        },
        deleteMember(id){
            swal({
                title: 'Apakah anda yakin ingin menghapus data anggota ini ?',
                buttons: true,
                icon: 'info',
                dangerMode: true
            })
            .then(yes => {
                if(yes){
                    axios.delete(`api/anggota/${id}`)
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
                        toast.error('Gagal menghapus data anggota yang dipilih');
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
