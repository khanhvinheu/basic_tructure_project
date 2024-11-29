<template>
    <div class="inner-body">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">LIST DATA USER</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ListDataUser</li>
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
                    <button @click="$router.push({ name: 'UserCreate' })" type="button" class="btn btn-primary my-2 btn-icon-text">
                        <i class="el-icon-plus"></i> Thêm mới
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
                        <!-- <div class="row"> -->
                            <!-- <div class="col-md-12"> -->
                                <div class="row"
                                    style="display: flex; flex-wrap: nowrap; padding-bottom: 8px; justify-content: space-between">
                                    <el-input style="width: 500px" v-model="textSearch"
                                        placeholder="Nhập kí tự cần tìm kiếm ..." @keyup.enter.native="getList()">
                                        <template v-slot:append>
                                            <el-button type="primary" @click="getList()"><i class="el-icon-search"></i>
                                                Tìm
                                                kiếm
                                            </el-button>
                                        </template>
                                    </el-input>                                  
                                </div>
                                <el-table empty-text="Chưa có dữ liệu !" :data="tableData" style="width: 100%" border
                                    :resizable="true" v-loading="loadingTable" :row-class-name="tableRowClassName">

                                    <el-table-column prop="name" label="Họ & Tên" sortable>
                                    </el-table-column>

                                    <el-table-column prop="chucvu" label="Chức vụ/ chức danh">
                                        <template slot-scope="scope">
                                            <el-tag>{{ scope.row.chucvu }}</el-tag>
                                        </template>
                                    </el-table-column>

                                    <el-table-column prop="donvicongtac" label="Đơn vị công tác">
                                    </el-table-column>
                                    <el-table-column prop="note" label="GHI CHÚ">
                                    </el-table-column>

                                    <el-table-column prop="created_at" label="NGÀY TẠO" width="150">
                                        <template slot-scope="scope">
                                            {{ scope.row.created_at | formatDate }}
                                        </template>
                                    </el-table-column>

                                    <el-table-column label="THAO TÁC" width="320">
                                        <template slot-scope="scope">
                                            <el-button type="success" size="mini" @click="createSign(scope.row)">
                                                <i class="el-icon-key"></i>
                                                Tạo chữ ký số
                                            </el-button>
                                            <el-button size="mini" @click="update(scope.row)">Cập
                                                nhật
                                            </el-button>
                                            <!-- <el-button
                                          size="mini"
                                          type="danger"
                                          @click="delete(scope.row.id)">Xóa</el-button> -->
                                            <el-popconfirm confirm-button-text='Xóa' cancel-button-text='Không'
                                                :title="'Bạn có chắc chắn muốn xóa?'"
                                                @confirm="() => deleteUser(scope.row.id)">
                                                <el-button slot="reference" type="danger" size="mini"><i
                                                        class="el-icon-delete"></i> Xóa
                                                </el-button>
                                            </el-popconfirm>
                                        </template>
                                    </el-table-column>
                                    <template slot="empty">
                                        <el-empty description="No data"></el-empty>
                                    </template>
                                </el-table>
                            <!-- </div> -->
                            <div class="block" style="margin-left: 0px;margin-right: 8px;padding: 10px;width: 100%">
                                <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                                    :current-page.sync="currentPage" :page-sizes="[10, 20, 50, 100]"
                                    :page-size="options.PageLimit" layout="total, sizes, prev, pager, next, jumper"
                                    :total="options.Total">
                                </el-pagination>
                            </div>
                            <!-- /.col -->

                        <!-- </div> -->
                        <!-- /.row -->
                        <!-- /.card-body -->                      
                        <el-dialog top="5vh" :visible.sync="outerVisible">
                            <!-- <formData :resID="idUpdate" :trigger="trigger" @success="success"/> -->
                            <formCreateSignature :resID="idUpdate" :trigger="trigger" @success="success"
                                @close="outerVisible = false" />
                        </el-dialog>                       
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

</template>

<script>
import ApiService from '../../common/api.service';
import formCreateSignature from './formCreateSignature.vue';
export default {
    components: { formCreateSignature },
    data() {
        return {
            idUpdate: '',
            outerVisible: false,
            loadingTable: false,
            tableData: [],
            slideData: [],
            textSearch: '',
            currentPage: 1,
            options: {
                Total: 10,
                Page: 1,
                PageLimit: 10
            },
            trigger: ''
        }
    },
    mounted() {
        this.getList()
    },
    methods: {
        success() {
            this.outerVisible = false
            this.getList()
        },
        update(e) {
            this.idUpdate = e.id
            this.$router.push({ name: 'UserUpdate', params: { id: e.id } })
        },
        createSign(e) {
            this.trigger = new Date().getTime()
            this.idUpdate = e.id
            this.outerVisible = true
        },
        handleSizeChange(val) {
            this.options.PageLimit = val
            this.getList()
        },
        handleCurrentChange(val) {
            this.options.Page = val
            this.getList()
        },
        updateStatus(id, hidden) {
            let _this = this
            var formData = new FormData()
            console.log(hidden, hidden == "0" ? "1" : "0")
            formData.append('hidden', hidden == "0" ? "1" : "0")
            axios({
                method: 'post',
                url: '/api/admin/product_color/update/' + id,
                data: formData
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
        deleteUser(id) {
            let _this = this
            axios({
                method: 'post',
                url: '/api/admin/users/delete/' + id,
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
        getList() {
            let _this = this
            _this.loadingTable = true
            let param = {}
            this.options.Page && (param.Page = this.options.Page)
            this.options.PageLimit && (param.PageLimit = this.options.PageLimit)
            this.textSearch && (param.TextSearch = this.textSearch)
            axios({
                method: 'get',
                url: '/api/admin/users',
                params: param
            })
                .then(function ({ data }) {
                    if (data['success']) {
                        _this.tableData = data['data']
                        _this.options.Total = data['total']
                        _this.slideData = data['data'].filter(e => e.hidden == 1)
                    }
                    _this.loadingTable = false
                });
        }, changeStatus(id) {
            alert(id)
        },
        tableRowClassName({ row, rowIndex }) {
            if (rowIndex === 1) {
                return 'warning-row';
            } else if (rowIndex === 3) {
                return 'success-row';
            }
            return '';
        }
    }
};
</script>

<style>
.el-table .warning-row {
    background: oldlace;
}

.el-table .success-row {
    background: #f0f9eb;
}

.color-item {
    height: 20px;
    width: 40px;
    border-radius: 6px;
}
</style>
