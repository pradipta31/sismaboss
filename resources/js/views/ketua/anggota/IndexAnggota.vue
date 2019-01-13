<template>
    <div>
        <section class="content-header">
            <h1>
                Data Anggota
                <small>data anggota UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Anggota</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <a :href="`ketua/anggota/${user.periode_id}`" class="btn btn-primary" style="margin-bottom: 5px">Download .xls</a>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>PJ</th>
                                    <th>Nama</th>
                                    <th>Nim</th>
                                    <th>No Telp</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(member, index) in anggota" :key="index">
                                        <td>{{index+1}}</td>
                                        <td>{{member.periode}}</td>
                                        <td>{{member.username}}</td>
                                        <td>{{member.nama}}</td>
                                        <td>{{member.nim}}</td>
                                        <td>{{member.handphone}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import {mapGetters} from "vuex"
export default {
    data(){
        return {
            anggota:[]
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
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
        }
    },
    computed:
    {
        ...mapGetters([
            'user'
        ])
    }
}
</script>

<style>

</style>
