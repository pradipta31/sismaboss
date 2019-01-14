<template>
    <div>
        <section class="content-header">
            <h1>
                Data Inventaris
                <small>data-data inventaris UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Inventaris</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <router-link :to="{name: 'sekretaris_inventaris_tambah'}" class="btn btn-primary" style="margin-bottom: 5px">Tambah Inventaris</router-link>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="15px">No</th>
                                    <th>Nama</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Foto</th>
                                    <th>Keterangan</th>
                                    <th width="100px">Opsi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in invents" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{item.nama}}</td>
                                        <td>{{item.penanggung_jawab}}</td>
                                        <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showGambar" @click="lihatGambar(item.id)">
                                            Lihat Gambar
                                            </button>
                                            <div class="modal fade" id="showGambar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="exampleModalLabel">Data : {{modal.nama}}</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <img :src="'images/inventaris/'+modal.pict" class="img-responsive" height="1080px" width="650px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{item.keterangan}}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSurat" @click="editInventaris(item.id)"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-danger btn-sm" @click="deleteInventaris(item.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <h6>Note: PJ = Penanggung Jawab</h6>
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
            invents: [],
            modal:{
                nama: '',
                pict: ''
            }
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(reload = false){
            if(reload) window.location.reload();
            axios.get('api/inventaris')
            .then(r => {
               console.log(r);
               this.invents = r.data.inventories;
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
        editInventaris(id){
            this.$router.push({name: 'sekretaris_inventaris_edit',params: {id: id}});
        },
        deleteInventaris(id){
            swal({
                title: 'Apakah anda yakin ingin menghapus data inventaris ini ?',
                buttons: true,
                icon: 'info',
                dangerMode: true
            })
            .then(yes => {
                if(yes){
                    axios.delete(`api/inventaris/${id}`)
                    .then(r => {
                        swal({
                            title: "Berhasil!",
                            text: "Data inventaris berhasil dihapus!",
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
                        toast.error('Gagal menghapus data inventaris yang dipilih');
                    })
                }
            })
        },
        lihatGambar(id){
            axios.get(`api/inventaris/show/${id}`)
            .then(r => {
                this.modal = r.data.inventaris
                console.log(r.data.inventaris)
            })
            .catch(e => {
                console.log(e)
            })
        }
    }
}
</script>

<style>

</style>
