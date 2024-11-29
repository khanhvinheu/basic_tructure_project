<template>    
    <div class="form_product_color">
       <div style="margin-top: -30px">
           <span style="font-size: 13px; font-weight: bold; text-transform: uppercase">{{title}}</span>
           <el-divider></el-divider>
       </div>
        <el-form :model="form"  ref="form" label-width="150px" class="demo-ruleForm">
            <el-form-item :rules="requiredForm" label="Mã khóa học" prop="maKhoaHoc">
                <el-input disabled v-model="form.maKhoaHoc"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Tên khóa học" prop="tenKhoaHoc">
                <el-input v-model="form.tenKhoaHoc"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Tên khóa học (EN)" prop="tenKhoaHocEN">
                <el-input v-model="form.tenKhoaHocEN"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Chi tiết khóa học" prop="chiTietKhoaHoc">
                <el-input type="textarea" v-model="form.chiTietKhoaHoc"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Thời gian đào tạo" prop="thoiGianDaoTao">
                <el-input v-model="form.thoiGianDaoTao"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Từ ngày" prop="tuNgay">
                <el-date-picker
                    style="width: 100%;"
                    format="dd/MM/yyyy"
                    v-model="form.tuNgay"
                    type="date"
                    placeholder="Pick a day">
                </el-date-picker>
                <!-- <el-input v-model="form.tuNgay"></el-input> -->
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Đến ngày" prop="denNgay">
                <el-date-picker
                    style="width: 100%;"
                    format="dd/MM/yyyy"
                    v-model="form.denNgay"
                    type="date"
                    placeholder="Pick a day">
                </el-date-picker>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Nơi đào tạo" prop="noiDaoTao">
                <el-input v-model="form.noiDaoTao"></el-input>
            </el-form-item>
            <el-form-item :rules="requiredForm" label="Nơi đào tạo (EN)" prop="noiDaoTaoEN">
                <el-input v-model="form.noiDaoTaoEN"></el-input>
            </el-form-item>
        </el-form>
        <div style="display: flex; justify-content: end">
            <el-button type="primary" @click="submit">Lưu lại</el-button>
            <el-button @click="$refs.form.resetFields()">Reset Form</el-button>
        </div>
    </div>
</template> 
<script>
    import ApiService from '../../common/api.service'
    export default {
        name: "create_update",
        props:['resID','trigger'],
        data(){
            return {
                title:'',
                form:{
                    maKhoaHoc:'',
                    tenKhoaHoc:'',
                    tenKhoaHocEN:'',
                    chiTietKhoaHoc:'',
                    thoiGianDaoTao:'',
                    tuNgay:'',
                    denNgay:'',
                    noiDaoTao:'',
                    noiDaoTaoEN:''
                },
                requiredForm: { required: true, message: 'Vui lòng không bỏ trống!', trigger: 'blur' }
            }
        },
        mounted() {
            if(this.resID){
                this.title='Cập nhật khóa học'
                this.getDetail(this.resID)
            }else {
                this.title='Thêm mới khóa học'
                this.$refs.form.resetFields()
                this.genCode()
            }
        },
        watch:{
            trigger(e){
                if(this.resID){
                    this.title='Cập nhật khóa học'
                    this.getDetail(this.resID)
                }else {
                    this.title='Thêm mới khóa học'
                    this.$refs.form.resetFields()
                    this.genCode()
                }
            }
        },
        methods:{
            async genCode() {
                let _this = this
                ApiService.query('/api/admin/khoa-hoc/gen_code').then(({data}) => {
                    _this.form.maKhoaHoc = data
                })
            },
            submit(){
                let _this= this
                let url
                url = this.resID?('/api/admin/khoa-hoc/update/'+this.resID):'/api/admin/khoa-hoc/create'
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
                    url: '/api/admin/khoa-hoc/detail/'+id,
                })
                    .then(({data})=> {
                        if(data['success']){
                            let res = data['data']
                            _this.form.maKhoaHoc = res['maKhoaHoc']
                            _this.form.tenKhoaHoc = res['tenKhoaHoc']
                            _this.form.tenKhoaHocEN = res['tenKhoaHocEN']
                            _this.form.chiTietKhoaHoc = res['chiTietKhoaHoc']
                            _this.form.thoiGianDaoTao = res['thoiGianDaoTao']
                            _this.form.tuNgay = res['tuNgay']
                            _this.form.denNgay = res['denNgay']
                            _this.form.noiDaoTao = res['noiDaoTao']  
                            _this.form.noiDaoTaoEN = res['noiDaoTaoEN']  
                        }
                    });

            },
        }
    }
</script>

<style scoped>

</style>
