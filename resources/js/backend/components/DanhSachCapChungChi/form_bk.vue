<template>
    <div class="form_product_color">
       <div style="margin-top: -30px">
           <span style="font-size: 13px; font-weight: bold; text-transform: uppercase">{{title}}</span>
           <el-divider></el-divider>
       </div>
        <el-form :inline="true" :model="form"  ref="form" label-width="150px" class="demo-ruleForm">
            <el-form-item :rules="requiredForm" label="Mã chứng chỉ" prop="maChungChi">
                <el-input v-model="form.maChungChi"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Họ tên" prop="hoTen">
                <el-input v-model="form.hoTen"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Năm sinh" prop="namSinh">
                <el-input v-model="form.namSinh"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Giới tính" prop="gioiTinh">
                <el-input v-model="form.gioiTinh"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Văn hóa" prop="vanHoa">
                <el-input v-model="form.vanHoa"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Dân tộc" prop="danToc">
                <el-input v-model="form.danToc"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Quê quán" prop="queQuan">
                <el-input v-model="form.queQuan"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Điểm trung bình" prop="diemTrungBinh">
                <el-input v-model="form.diemTrungBinh"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Xếp loại" prop="xepLoai">
                <el-input v-model="form.xepLoai"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Ghi chú" prop="ghiChu">
                <el-input  type="textarea" v-model="form.ghiChu"></el-input>
            </el-form-item>
        </el-form>
        <div style="display: flex; justify-content: end">
            <el-button type="primary" @click="submit">Lưu lại</el-button>
            <el-button @click="$refs.form.resetFields()">Reset Form</el-button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "create_update",
        props:['resID'],
        data(){
            return {
                title:'',
                form:{
                    maChungChi:'',
                    hoTen:'',
                    namSinh:'',
                    gioiTinh:'',
                    vanHoa:'',
                    danToc:'',
                    queQuan:'',
                    diemTrungBinh:'',
                    xepLoai:'',
                    ghiChu:'',
                },
                requiredForm: { required: true, message: 'Vui lòng không bỏ trống!', trigger: 'blur' }
            }
        },
        mounted() {
            if(this.resID){
                this.title='Cập nhật danh sách cấp chứng chỉ'
                this.getDetail(this.resID)
            }else {
                this.title='Thêm mới danh sách cấp chứng chỉ'
                this.$refs.form.resetFields()
            }
        },
        watch:{
            resID(e){
                if(e){
                    this.title='Cập nhật danh sách cấp chứng chỉ'
                    this.getDetail(e)
                }else {
                    this.title='Thêm mới danh sách cấp chứng chỉ'
                }
            }
        },
        methods:{
            submit(){
                let _this= this
                let url
                url = this.resID?('/api/admin/cap-chung-chi/update/'+this.resID):'/api/admin/cap-chung-chi/create'
                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        axios({
                            method: 'post',
                            url: url,
                            data: this.form
                        })
                            .then(function (response) {
                                if(response.data['success']){
                                    _this.$notify({
                                        title: 'Success',
                                        message: response.data['mess'],
                                        type: 'success'
                                    });

                                    _this.$emit('success')
                                    _this.$refs.form.resetFields()
                                }else{
                                    _this.$notify({
                                        title: 'Error',
                                        message: response.data['mess'],
                                        type: 'error'
                                    });
                                }

                            });
                    } else {
                        return false;
                    }
                });
            },
            async getDetail(id){
                let _this = this
                await axios({
                    method: 'get',
                    url: '/api/admin/cap-chung-chi/detail/'+id,
                })
                    .then(({data})=> {
                        if(data['success']){
                            let res = data['data']                           
                            _this.form.maChungChi=res['maChungChi'],
                            _this.form.hoTen=res['hoTen'],
                            _this.form.namSinh=res['namSinh'],
                            _this.form.gioiTinh=res['gioiTinh'],
                            _this.form.vanHoa=res['vanHoa'],
                            _this.form.danToc=res['danToc'],
                            _this.form.queQuan=res['queQuan'],
                            _this.form.diemTrungBinh=res['diemTrungBinh'],
                            _this.form.xepLoai=res['xepLoai'],
                            _this.form.ghiChu=res['ghiChu']
                        }
                    });

            },
        }
    }
</script>

<style scoped>

</style>
