<template>
    <div>
        <section class="content-header">
            <h1>
                Data Kepengurusan UKM BOSS
                <small>data-data Kepengurusan UKM BOSS Berdasarkan periode</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Kepengurusan</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="15px">No</th>
                                    <th>Periode</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>NIM</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th width="100px">Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in ketua" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{item.periode}}</td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.username}}</td>
                                        <td>{{item.nim}}</td>
                                        <td>{{item.email}}</td>
                                        <td>
                                            <span class="label label-success" v-if="item.status">Aktif</span>
                                            <span class="label label-warning" v-else>Non Aktif</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" @click="showModal(item.id)"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-warning btn-sm" @click="editKetua(item.id)"><i class="fa fa-pencil"></i></button>
                                            <!-- <button class="btn btn-danger btn-sm" @click="deleteKetua(item.id)">
                                                <i class="fa fa-trash"></i>
                                            </button> -->

                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">Data : {{modal.name}}</h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-sm-2">
                                                                <h4>Periode </h4>
                                                                <h4>Nama </h4>
                                                                <h4>Username </h4>
                                                                <h4>Email </h4>
                                                                <h4>NIM </h4>
                                                                <h4>Status </h4>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <h4>: {{modal.periode}}</h4>
                                                                <h4>: {{modal.name}}</h4>
                                                                <h4>: {{modal.username}}</h4>
                                                                <h4>: {{modal.email}}</h4>
                                                                <h4>: {{modal.nim}}</h4>
                                                                <h4 v-if="modal.status">
                                                                    : <span class="label label-success">Aktif</span>
                                                                </h4>
                                                                <h4 v-else>
                                                                    : <span class="label label-warning">Non Aktif</span>
                                                                </h4>
                                                            </div>
                                                        </div>
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
    mounted(){
        this.getData();
    },
    data(){
        return{
            table: null,
            modal: {
                periode_id: '',
                name: '',
                username: '',
                email: '',
                nim: '',
                status: ''
            },
            ketua:[]
        }
    },
    methods:{
        getData(){
            axios.get('api/ketua')
            .then(r => {
                this.ketua = r.data.ketuas
            })
            .catch(e => {
                console.log(e)
            })
            .finally(() => {
                if(this.table == null){
                    this.table = $('table').dataTable();
                }else{
                    this.table.rows().invalidate().draw();
                }
            })
        },
        // deleteKetua(id){
        //     swal({
        //         title: 'Apakah anda yakin ingin menghapus data ketua ini ?',
        //         buttons: true,
        //         icon: 'info',
        //         dangerMode: true
        //     })
        //     .then(yes => {
        //         if(yes){
        //             axios.delete(`api/ketua/${id}`)
        //             .then(r => {
        //                 this.getData();
        //                 swal(r.data.message, {icon: "success"});
        //             })
        //             .catch(e => {
        //                 console.log(e);
        //                 toast.error('Gagal menghapus data Ketua yang dipilih');
        //             })
        //         }
        //     })
        // },
        showModal(id){
            axios.get(`api/ketua/show/${id}`)
            .then(r => {
                console.log(r);
                this.modal = r.data.user
            })
            .catch(e => {
                console.log(e)
            })
        },
        editKetua(id){
            this.$router.push({name: 'admin_edit_ketua',params: {id: id}});
        },
    }
}
</script>

<style>

</style>
