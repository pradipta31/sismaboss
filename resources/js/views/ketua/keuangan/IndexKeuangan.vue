<template>
    <div>
        <section class="content-header">
            <h1>
                Data Keuangan
                <small>data-data keuangan UKM BOSS</small>
            </h1>
            <ol class="breadcrumb">
                <li><router-link :to="{path : '/main'}"><i class="fa fa-dashboard"></i> Dashboard</router-link></li>
                <li class="active">Data Keuangan</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <a :href="`ketua/keuangan/${user.periode_id}`" class="btn btn-primary" style="margin-bottom: 5px">Download .xls</a>
                            <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                                <th>PJ</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(f, index) in fund" :key="index">
                                    <td>{{index+1}}</td>
                                    <td v-if="f.tanggal">
                                        {{f.tanggal}}
                                    </td>
                                    <td v-else>
                                        {{format(f.created_at)}}
                                    </td>
                                    <td>{{f.keterangan}}</td>
                                    <td>
                                        {{f.debit}}
                                    </td>
                                    <td>
                                        {{f.kredit}}
                                    </td>
                                    <td>
                                        {{f.saldo}}
                                    </td>
                                    <td>{{f.username}}</td>
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
        return{
            table: null,
            fund: []
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            axios.get('api/keuangan')
            .then(r => {
               console.log(r);
               this.fund = r.data.funds
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
