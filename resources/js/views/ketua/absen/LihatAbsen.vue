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
                            <div class="col-md-12"> 
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th scope="col">NIM</th>
                                        <th scope="col">Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in absen" :key="index">
                                            <td>{{index+1}}</td>
                                            <td>
                                                {{item.nim}}
                                            </td>
                                            <td>
                                                {{item.nama}}
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
    data(){
        return{
            table: null,
            absen: [],
            nim: ''
        }
    },
    mounted(){
        this.getData()
    },
    methods:{
        getData(){
            axios.get('api/absen/lihat-absen/'+this.$route.params.id)
            .then(r => {
               console.log(r);
               this.absen = r.data.absents;
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
    }
}
</script>

<style>

</style>
