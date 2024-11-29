<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header" style="background-color: rgb(0,0,0,0.1);">
                    <h3 class="card-title"><i class="el-icon-loading"></i> BLOCK ECDSA</h3>
                    <div class="card-tools">
<!--                        <el-button @click="dialogTool=true" type="primary"><i class="el-icon-home"></i> Tool</el-button>-->
                        <el-dialog top="5vh" :visible.sync="dialogTool">
                            <!-- <formData :resID="idUpdate" :trigger="trigger" @success="success"/> -->
                            <toolCheck @close="dialogTool=false"/>
                        </el-dialog>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="block" style="margin-left: 0px;margin-right: 8px;padding: 10px;width: 100%">
                            <div style="display: flex; justify-content: space-between">
                                <span style="font-weight: bold">Total block: {{ listBlock.length }}</span>
                                <el-button type="danger" @click="addBlock"><i class="el-icon-plus"></i> Add block</el-button>
                            </div>
                            <el-divider></el-divider>
                            <el-timeline style="max-height: 60vh; overflow-y: auto">
                                <el-timeline-item v-for="(item, i) in listBlock" :key="i" :timestamp="item.timestamp"
                                    :icon="'el-icon-key'" color="#0bbd87"  placement="top">
                                    <el-card>
                                        <h4>Block # {{ item.index }}</h4>
<!--                                        <p class="textContent">Data: {{ item.data }}</p>-->
                                        <p class="textContent">PreviousHash: {{ item.previousHash }}</p>
                                        <p class="textContent">Hash: {{ item.hash }}</p>
                                        <p class="textContent">Signature: {{ item.signature }}</p>
                                    </el-card>
                                </el-timeline-item>
                            </el-timeline>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import VJsoneditor from 'v-jsoneditor/src/index'
import formCreateSignature from "./formCreateSignature.vue";
import toolCheck from "./toolCheck.vue";
import * as filters from "../../../filters";

export default {
    data() {
        return {
            publicKey: '',
            isValid: '',
            listBlock: '',
            options: {},
            dialogTool:false
        };
    },
    components: {formCreateSignature, VJsoneditor, toolCheck},
    async mounted(params) {
        this.getListBlog()
    },
    methods: {
        addBlock() {
            axios({
                method: 'post',
                url: 'http://localhost:3000/add-block',
                data:{
                    privateKey:this.$store.getters.user.privatekey
                }
            }).then(({data}) => {
                this.$notify({
                    title: data.status?'Success':'Error',
                    message: data['messages'],
                    type: data.status?'success':'error'
                });
                this.getListBlog()
            });
        },
        getListBlog() {
            axios({
                method: 'get',
                url: '/api/admin/blocks/get-all',
            }).then(({data}) => {
                this.listBlock = data
            });
        },


    },
};
</script>
<style lang="scss">
.textContent {
    color: #239a1a;
}
</style>
