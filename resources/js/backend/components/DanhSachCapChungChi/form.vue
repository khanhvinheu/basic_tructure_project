<template>
    <div class="row">    
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header" style="background-color: rgb(0,0,0,0.1);">
                    <h3 class="card-title">{{ title }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>              
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <el-form label-position="right" :model="formData" :rules="rules" ref="formData"
                                     label-width="220px" class="demo-ruleForm">   
                                <span class="title-divider">Thông tin học viên</span>     
                                <el-divider></el-divider>                                
                                <el-form-item label="Mã chứng chỉ" prop="maChungChi">
                                    <div class="form-group">
                                        <el-input disabled validate-event placeholder="Mã chứng chỉ"
                                                    v-model="formData.maChungChi"></el-input>
                                    </div>
                                </el-form-item>                         
                                <el-form-item label="Tên học viên" prop="hoTen">
                                    <div class="form-group">
                                        <el-input validate-event placeholder="Nhập tên học viên"
                                                    v-model="formData.hoTen"></el-input>
                                    </div>
                                </el-form-item>                         
                                <el-form-item label="Ngày sinh" prop="namSinh">
                                    <div class="form-group">
                                        <!-- <el-input validate-event placeholder="Nhập ngày tháng năm sinh: dd/mm/yyyy"
                                                    v-model="formData.namSinh"></el-input> -->
                                        <el-date-picker
                                            style="width: 100%;"
                                            format="dd/MM/yyyy"
                                            v-model="formData.namSinh"
                                            type="date"
                                            placeholder="Nhập ngày tháng năm sinh: dd/mm/yyyy">
                                        </el-date-picker>
                                    </div>
                                </el-form-item>     
                                <el-form-item label="Giới tính" prop="gioiTinh">
                                    <div class="form-group">
                                        <!-- <el-input validate-event placeholder="Nhập giới tính"
                                                    v-model="formData.gioiTinh"></el-input> -->
                                        <el-select style="width: 100%;" v-model="formData.gioiTinh" placeholder="Nhập giới tính">
                                            <el-option label="Nam" value="Nam"></el-option>
                                            <el-option label="Nữ" value="Nữ"></el-option>
                                        </el-select>
                                    </div>
                                </el-form-item>                       
                                                            
                                <el-form-item label="Văn hóa" prop="vanHoa">
                                    <div class="form-group">
                                        <el-input validate-event placeholder="Nhập trình độ văn hóa"
                                                  v-model="formData.vanHoa"></el-input>
                                    </div>
                                </el-form-item> 
                                <el-form-item label="Dân tộc" prop="danToc">
                                    <div class="form-group">
                                        <!-- <el-input validate-event placeholder="Nhập dân tộc"
                                                  v-model="formData.danToc"></el-input> -->
                                        <el-select style="width: 100%;" v-model="formData.danToc" placeholder="Chọn dân tộc">
                                            <el-option label="Kinh" value="Kinh"></el-option>
                                            <el-option label="Khmer" value="Khmer"></el-option>
                                            <el-option label="Hoa" value="Hoa"></el-option>
                                        </el-select>
                                    </div>
                                </el-form-item> 
                                <el-form-item label="Quê quán" prop="queQuan">
                                    <div class="form-group">
                                        <el-input validate-event placeholder="Nhập quê quán"
                                                  v-model="formData.queQuan"></el-input>
                                    </div>
                                </el-form-item> 
                                <el-form-item label="Điểm trung bình toàn khóa" prop="diemTrungBinh">
                                    <div class="form-group">
                                        <el-input validate-event placeholder="Nhập điểm trung bình toàn khóa"
                                                  v-model="formData.diemTrungBinh"></el-input>
                                    </div>
                                </el-form-item> 
                                <el-form-item label="Xếp loại toàn khóa" prop="xepLoai">
                                    <div class="form-group">
                                        <!-- <el-input validate-event placeholder="Nhập xếp loại toàn khóa"
                                                  v-model="formData.xepLoai"></el-input> -->
                                        <el-select style="width: 100%;" v-model="formData.xepLoai" placeholder="Chọn xếp loại">
                                            <el-option label="Trung bình" value="Trung bình"></el-option>
                                            <el-option label="Khá" value="Khá"></el-option>
                                            <el-option label="Giỏi" value="Giỏi"></el-option>
                                            <el-option label="Xuất sắc" value="Xuất sắc"></el-option>
                                        </el-select>
                                    </div>
                                </el-form-item> 
                                <el-form-item label-width="220px" label="Ảnh 3x4">
                                    <div class="form-group">
                                        <el-upload class="custorm-upload" ref="upload" :auto-upload="false" accept="image/png, image/jpeg"
                                            action="/api/admin/upload" list-type="picture-card" :on-change="handleUploadChange"
                                            :on-remove="removeImg" multiple :limit="limitImg" :on-exceed="messLimit" :file-list="fileList">
                                            <div slot="file" slot-scope="{file}">
                                                <img class="el-upload-list__item-thumbnail" :src="file.url" alt="">
                                                <span class="el-upload-list__item-actions">
                                                    <span class="el-upload-list__item-delete" @click="removeImg(file)">
                                                        <i class="el-icon-delete"></i>
                                                    </span>
                                                    <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                                        <i class="el-icon-zoom-in"></i>
                                                    </span>
                                                </span>
                                                <div style="background-color: rgba(139,145,147,0.66); color: #fff;
                                                            position: absolute;bottom: 0;
                                                            width: 100%; text-align: center"
                                                    v-if="fileList.length && fileList[0].uid == file.uid">Ảnh bìa</div>
                                            </div>
                                            <div
                                                style="text-align: center;line-height: 20px;display: flex; align-items: center; flex-direction: column">
                                                <i color="red" class="el-icon-picture-outline"></i>
                                                <span style="font-size: 10px">Thêm hình ảnh {{ fileList.length }}/{{ limitImg }}</span>
                                            </div>
                                        </el-upload>
                                        <el-dialog :visible.sync="dialogVisible">
                                            <img width="100%" :src="dialogImageUrl" alt="">
                                        </el-dialog>
                                    </div>
                                    <!-- <el-button @click="$refs.upload.submit()" size="small" type="primary">Upload</el-button> -->
                                </el-form-item>                              
                                <span class="title-divider">Thông tin khóa học</span>     
                                <el-divider></el-divider>                                 
                                <el-form-item label="Khóa học" prop="maKhoaHoc">
                                    <div class="form-group">
                                        <el-select style="width: 100%" v-model="formData.maKhoaHoc" size="large"
                                                   filterable 
                                                   placeholder="Chọn khóa học">
                                            <el-option
                                                v-for="item in listKhoaHoc"
                                                :key="item.id"
                                                :label="item.maKhoaHoc + ' | ' + item.tenKhoaHoc"
                                                :value="item.maKhoaHoc"
                                            >                                            
                                            </el-option>
                                        </el-select>
                                    </div>
                                </el-form-item>                                                           
                                 
                                <span class="title-divider">Thông tin xét tốt nghiệp và cấp chứng chỉ</span>    
                                <el-divider></el-divider>
                                <el-form-item label="Đợt cấp" prop="maDotCap">
                                    <div class="form-group">
                                        <el-select style="width: 100%" v-model="formData.maDotCap" size="large"
                                                   filterable 
                                                   placeholder="Chọn đợt cấp">
                                            <el-option
                                                v-for="item in listDotCap"
                                                :key="item.id"
                                                :label="item.maDot + ' | ' + item.thoiGianCap"
                                                :value="item.maDot"
                                            >                                            
                                            </el-option>
                                        </el-select>
                                    </div>
                                </el-form-item>     
                                <el-form-item label="Ghi chú" prop="ghiChu">
                                    <div class="form-group">
                                        <el-input type="textarea" rows="6" validate-event placeholder="Nhập ghi chú"
                                                    v-model="formData.ghiChu"></el-input>
                                    </div>
                                </el-form-item>                                                   
                            </el-form>

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="display: flex; justify-content: end;">
                    <el-button v-show="!idUpdate" type="success" @click="create"><i class="el-icon-plus"></i> Lưu lại
                    </el-button>
                    <el-button v-show="idUpdate" type="success" @click="update"><i class="el-icon-edit"></i> Cập nhật
                    </el-button>
                    <el-button @click="$router.push({name:'DanhSachCapChungChi'})">Đóng</el-button>
                </div>
            </div>
        </div>
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
        var validatePass = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Vui lòng không bỏ trống'));
            } else {        
                if (this.formData.password !== '') {
                    this.$refs.formData.validateField('password_confirmation');
                }
                callback();
            }
        };
        var validatePass2 = (rule, value, callback) => {    
            if (value === '') {
                callback(new Error('Vui lòng nhập lại mật khẩu'));
            } else if (value !== this.formData.password) {
                callback(new Error('Mật khẩu không trùng khớp'));
            } else {
                callback();
            }
        };
        return {
            title:'THÊM MỚI NHÂN VIÊN',           
            idUpdate: '',
            rules: {
                name: [
                    {required: true, message: 'Vui lòng không bỏ trống', trigger: 'blur'},
                ],
                email: [
                    {required: true, message: 'Vui lòng không bỏ trống', trigger: 'blur'},
                    {
                        type: 'email',
                        message: 'Vui lòng nhập đúng định dạng: abc@gmail.com',
                        trigger: ['blur', 'change'],
                    },
                ],               
                password: [
                    {required: true, validator: validatePass, trigger: 'blur' }
                ],
                password_confirmation: [
                    {required: true, validator: validatePass2, trigger: 'blur' }
                ],
            },
            data: [],
            filterDataCategorys: '',
            listDotCap: [],
            listKhoaHoc: [],             
            form:new FormData(),
            formData: {
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
                delete_image:''
            },
            files: [],
            fileListOption: [],
            limitImg:1,
            fileList:[],
            dialogVisible:false,
            dialogImageUrl:false

        }
    },
    async mounted() {
        this.title=this.$route.name=='UserUpdate'?'CẬP NHẬT THÔNG TIN HỌC VIÊN VÀ KHÓA HỌC':'THÊM MỚI HỌC VIÊN VÀ KHÓA HỌC'
        await this.getListDotCap()
        await this.getListKhoaHoc()
        if(this.$route.params.id){
            this.idUpdate=this.$route.params.id
            await this.getDetail(this.$route.params.id)
        }else{
            this.genCode()     
        }
    },
    methods: {
        async genCode() {
            let _this = this
            ApiService.query('/api/admin/cap-chung-chi/gen_code').then(({data}) => {
                _this.formData.maChungChi = data
            })
        },
         //Custorm upload images
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file.url;
            this.dialogVisible = true;
        },
        handleUploadChange(file) {
            if (this.fileList.findIndex(e => e.uid == file.uid) == -1) {
                this.fileList.push(file)
            }
        },
        messLimit() {
            this.$notify({
                title: 'Error',
                message: 'Không upload số lượng ảnh vượt quá mức cho phép',
                type: 'error'
            });
        },
        uploadFile(i) {
            // this.$refs['uploadFile'+i]
            this.$refs['uploadFile' + i][0].click();
        },
        clearImage(i){      
            this.fileListOption.splice(i, 1,null); 
        },
        handleFileUpload(event, index) {
            // Get the uploaded file
            const file = event.target.files[0]
            // Update the files array with the new file
            this.$set(this.fileListOption, index, file)           
          
        },  
        removeImg(el) {           
            if (el.url) {
                this.formData.delete_image=(el.url)
            }
            this.fileList = this.fileList.filter(e => e.uid != el.uid)
            // ApiService.post('/api/admin/removeFile', { path: el.url })
        },

        fileUrl(index) {
            // Get the URL for the uploaded file
            if (this.fileListOption[index] && this.fileListOption[index] instanceof File) {
                return URL.createObjectURL(this.fileListOption[index])
            }else{
                return this.fileListOption[index]
            }
        },

        handleSubmit(event) {
            event.preventDefault()
            // Handle form submission here
        },
        resetForm(formName) {            
            this.$refs[formName].resetFields();
        },
       
        async getListDotCap(id, update) {
            let _this = this
            ApiService.query('/api/admin/dot-cap', {params: {type: 'data'}}).then(({data}) => {
                _this.listDotCap = data['data']              
            })

        },
        async getListKhoaHoc(id, update) {
            let _this = this
            ApiService.query('/api/admin/khoa-hoc', {params: {type: 'data'}}).then(({data}) => {
                _this.listKhoaHoc = data['data']              
            })

        },       
        async getDetail(id) {
            let _this = this
            _this.idUpdate = id
            await axios({
                method: 'get',
                url: '/api/admin/cap-chung-chi/detail/' + id,
            })
                .then(({data}) => {                  
                    if (data['success']) {
                        let res = data['data']
                        _this.formData.maChungChi=res['maChungChi'],
                        _this.formData.hoTen=res['hoTen'],
                        _this.formData.namSinh=res['namSinh'],
                        _this.formData.gioiTinh=res['gioiTinh'],
                        _this.formData.vanHoa=res['vanHoa'],
                        _this.formData.danToc=res['danToc'],
                        _this.formData.queQuan=res['queQuan'],
                        _this.formData.diemTrungBinh=res['diemTrungBinh'],
                        _this.formData.xepLoai=res['xepLoai'],
                        _this.formData.ghiChu=res['ghiChu']
                        _this.formData.maDotCap=res['maDotCap'],
                        _this.formData.maKhoaHoc=res['maKhoaHoc']
                        if(res['image'] && res['image'] !=''){
                            _this.fileList=[{url:res['image'], id:1}]
                        }else{
                            _this.fileList=[]
                        }
                          
                    }
                 
                });
           
        },
      
        appendToFormData() {
            let _this = this
            _this.form =new FormData()
            Object.keys(this.formData).forEach(key => {   
                if(this.formData[key]){
                     _this.form.set(key, this.formData[key])
                }             
               
            });          
        },
        appendFileToFormData() {
            let index = 0
            this.fileList.map((e) => {
                if (e && e.status == "ready") {
                    this.form.set('file' + index, e.raw)
                    index++
                }
            })
            if (this.fileList.length==0) {
                this.form.set('image', null)
            }

        },
        create() {
            let _this = this
            _this.appendToFormData()
            _this.appendFileToFormData()         
            this.$refs['formData'].validate((valid) => {
                if (valid) {
                    axios({
                        method: 'post',
                        url: '/api/admin/cap-chung-chi/create',
                        data: _this.form
                    })
                        .then(function (response) {
                            if (response.data['success']) {
                                _this.$notify({
                                    title: 'Success',
                                    message: response.data['mess'],
                                    type: 'success'
                                });
                                _this.resetForm('formData')
                                _this.$router.push({name:"DanhSachCapChungChi"})
                            } else {
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
        update() {
            let _this = this
            _this.appendToFormData()
            _this.appendFileToFormData()           
            this.$refs['formData'].validate((valid) => {
                if (valid) {
                    axios({
                        method: 'post',
                        url: '/api/admin/cap-chung-chi/update/' + _this.idUpdate,
                        data: _this.form
                    })
                        .then(function (response) {
                            if (response.data['success']) {
                                _this.$notify({
                                    title: 'Success',
                                    message: response.data['mess'],
                                    type: 'success'
                                });
                                _this.resetForm('formData')                               
                                _this.idUpdate = ''
                                _this.$router.push({name:"DanhSachCapChungChi"})
                            } else {
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
        }
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

/* .label__form::before{
  content: '+ ';
} */
.title-divider{
    font-weight: bold;
    color: rgb(0,0,0,0.6);
}
.title-divider::before{
    content: "+";
}
.custorm-upload .el-upload--picture-card {
    width: 120px;
    height: unset;
    line-height: 10px;
    padding: 25px;
}

.custorm-upload .el-upload-list--picture-card .el-upload-list__item {
    width: 120px;
    height: 120px;
}
.box-image-option:hover .overlay-remove{
    opacity:1 !important;
    background-color:rgb(0,0,0,0.3)!important;
    color:#fff;
    transition: all 0.9ms linear;
}
</style>
