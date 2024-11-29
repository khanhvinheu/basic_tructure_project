<template>
    <div>
        <div class="card card-default">
            <div class="card-body">
                <p>
                   PublicKey: {{$store.getters.user.publickey}}
                </p>
                <p>
                   PrivateKey:  {{$store.getters.user.privatekey}}
                </p>
                <el-input v-model="publicKey"></el-input>
                <el-input v-model="providedSignature"></el-input>
            </div>

            <div class="card-footer">
                <el-button type="primary" @click="checkIsvalid">Check signature</el-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:"toolCheck",
        data(){
            return{
                providedSignature:'',
                publicKey:''
            }
        },
        methods:{
            checkIsvalid() {
                axios({
                    method: 'post',
                    url: 'http://localhost:3000/blocks/isChainValid',
                    data: {
                        publicKey: this.publicKey,
                        providedSignature: this.providedSignature
                    }
                }).then(({data}) => {
                    if(data.status){
                        this.$notify({
                            title: 'Success',
                            message: data['messages'],
                            type: 'success'
                        });
                    }else {
                        this.$notify({
                            title: 'Error',
                            message: data['messages'],
                            type: 'error'
                        });
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>
