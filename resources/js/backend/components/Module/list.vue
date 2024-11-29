<template>
    <div class="inner-body">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">FORM ROLE</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">FormRole</li>
                </ol>
            </div>
            <div class="d-flex">
                <div class="justify-content-center">
                    <button type="button" class="btn btn-white btn-icon-text my-2 me-2">
                        <i class="fe fe-download me-2"></i> Import
                    </button>
                    <button type="button" class="btn btn-white btn-icon-text my-2 me-2">
                        <i class="fe fe-filter me-2"></i> Filter
                    </button>
                    <!-- <button type="button" class="btn btn-primary my-2 btn-icon-text">
                        <i class="fe fe-download-cloud me-2"></i> Download Report
                    </button> -->
                    <button @click="$router.push({ name: 'ModuleCreate' })" class="btn btn-primary my-2 btn-icon-text"
                        type="button"><i class="el-icon-plus"></i> Thêm mới
                    </button>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="display: flex; flex-wrap: nowrap;">
                                    <el-input placeholder="Nhập kí tự cần tìm kiếm..." v-model="filterDataCategorys">
                                    </el-input>                                   
                                </div>
                                <el-divider></el-divider>
                                <el-tree ref="tree" empty-text="Không tìm thấy !" :filter-node-method="filterNode"
                                    v-show="data" :data="data" :show-checkbox="false" node-key="id" class="tree-module"
                                    default-expand-all :expand-on-click-node="false">
                                    <span class="custom-tree-node" slot-scope="{ node, data }">
                                        <span><i v-if="data.icon" :class="data.icon"></i> <span
                                                style="font-weight: bold; ">{{ data.code }}</span>{{ ' | ' + data.name
                                            }}</span>
                                        <span>
                                            <el-button type="text" size="mini" style="color:blue"
                                                @click="() => $router.push({ name: 'ActionList', params: { id_module: data.code } })">
                                                <i class="el-icon-menu"></i> Action
                                            </el-button>
                                            <el-divider direction="vertical"></el-divider>
                                            <el-button type="text" size="mini" style="color:green"
                                                @click="() => getDetail(data.id)">
                                                <i class="el-icon-edit"></i> Cập nhật
                                            </el-button>
                                            <el-divider direction="vertical"></el-divider>
                                            <el-popconfirm confirm-button-text='Xóa' cancel-button-text='Không'
                                                :title="'Bạn có chắc chắn muốn xóa danh mục *' + data.title + '* không ?'"
                                                @confirm="() => deleteCategory(data.id)">
                                                <el-button slot="reference" style="color: red;" type="text"
                                                    size="mini"><i class="el-icon-delete"></i> Xóa</el-button>
                                            </el-popconfirm>
                                        </span>
                                    </span>
                                </el-tree>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>


</template>

<script>
import ApiService from '../../common/api.service';
import VueUploadMultipleImage from 'vue-upload-multiple-image'

export default {
    watch: {
        filterDataCategorys(val) {
            this.$refs.tree.filter(val);
        }
    },
    components: {
        VueUploadMultipleImage,
    },
    data() {
        return {
            rules: {
                title: [
                    { required: true, message: 'Vui lòng không bỏ trống', trigger: 'blur' },
                ],
                level: [
                    { required: true, message: 'Vui lòng không bỏ trống', trigger: 'change' },
                ],
            },
            data: [],
            filterDataCategorys: '',
        }
    },
    mounted() {
        this.getList()
    },
    methods: {
        filterNode(value, data) {
            if (!value) return true;
            return data.name.indexOf(value) !== -1;
        },
        getList() {
            let _this = this
            ApiService.query('/api/admin/module', { params: { type: 'treeData' } }).then(({ data }) => {
                _this.data = data['data']
            })
        },
        async getDetail(id) {
            this.$router.push({ name: 'ModuleUpdate', params: { id: id } }).catch(() => { })
        },
        deleteCategory(id) {
            let _this = this
            axios({
                method: 'post',
                url: '/api/admin/module/delete/' + id,
                responseType: 'stream'
            })
                .then(function (response) {
                    if (response.data['success']) {
                        _this.$notify({
                            title: 'Success',
                            message: response.data['mess'],
                            type: 'success'
                        });
                        _this.getList()
                    } else {
                        _this.$notify({
                            title: 'Error',
                            message: response.data['mess'],
                            type: 'error'
                        });
                    }
                });
        },
    }
};
</script>

<style>
.custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
}

.label__form {
    font-size: 13px;
}

.tree-module .el-tree-node__content {
    height: 40px;
    /* border: 1px dotted rgb(0,0,0,0.2);
    border-radius: 5px;
    margin-bottom: 5px; */

}

.custom-tree-node {
    /* border-bottom: 1px solid rgba(53, 191, 7, 0.2); */

}

.el-tree-node__content:hover,
.el-upload-list__item:hover {
    background-color: transparent !important;
}
</style>
