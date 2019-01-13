<template>
    <section class="content-header">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-md-5">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-ttitle">
                                    Edit Periode
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <input type="text" class="form-control" placeholder="Masukan Periode" v-model="data.periode">
                                    <h6>Contoh: 2015/2016</h6>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary" @click="saveEdit">
                                    <i class="fa fa-spin fa-spinner" v-if="isLoading"></i>
                                    <i class="fa fa-check" v-else></i>
                                    Simpan
                                </button>
                                <router-link :to="{name:'periode'}" class="btn btn-info">Kembali</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>

<script>
export default {
    data(){
        return {
            data:{
                periode: ''
            },
            periodes: [],
            isLoading: false
        }
    },
    mounted(){
        this.init()
    },
    methods:{
        init(){
            axios.get('api/periode/'+this.$route.params.id)
            .then(r => {
                this.data = r.data.periodes;
            })
            .catch(e => {
                console.log(e);
            })
        },
        saveEdit(){
            swal({
                title: "Apakah anda yakin ingin menyimpan?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willSave) => {
                if(willSave){
                    axios.put('api/periode/'+this.$route.params.id, this.data)
                    .then(r => {
                        this.isLoading = false;
                        toast.success(r.data.message);
                        this.$router.push({name: 'periode'});
                    })
                    .catch(e => {
                        this.isLoading = false;
                        console.log(e.response.data.errors);
                        toast.error('Gagal mengubah periode');
                    })
                }
            })
        },
    }
}
</script>

<style>

</style>
