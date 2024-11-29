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
                                     label-width="180px" class="demo-ruleForm">
                                <!-- <span class="title-divider">Thông tin nhân viên</span>
                                <el-divider></el-divider>                                      -->
                                <el-form-item label="Private Key" prop="privatekey">
                                    <div class="form-group">
                                        <el-input validate-event placeholder="Privatekey"
                                                  v-model="formData.privatekey"></el-input>
                                    </div>
                                </el-form-item>
                                <el-form-item label="Public Key" prop="publickey">
                                    <div class="form-group">
                                        <el-input validate-event placeholder="Publickey"
                                                  v-model="formData.publickey"></el-input>
                                    </div>
                                </el-form-item>
<!--                                <el-form-item label="Signature" prop="signature">-->
<!--                                    <div class="form-group">-->
<!--                                        <el-input validate-event placeholder="Signature"-->
<!--                                                  v-model="formData.signature"></el-input>-->
<!--                                    </div>-->
<!--                                </el-form-item>-->
                                <el-form-item  label="Ảnh chữ ký">
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
                            </el-form>

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="display: flex; justify-content: end;">
                    <el-button v-show="resID" type="success" @click="update"><i class="el-icon-plus"></i> Lưu lại
                    </el-button>
<!--                    <el-button v-show="resID" type="success" @click="checkUSB"><i class="el-icon-plus"></i> checkUSB-->
<!--                    </el-button>-->
                    <el-button @click="$refs.form.resetFields()">Reset Form</el-button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { update } from 'lodash';
import ApiService from '../../common/api.service';
import VueUploadMultipleImage from 'vue-upload-multiple-image'
import crypto from "crypto";
const EC = require('elliptic').ec;
export default {
    props:['resID','trigger'],
    watch: {
        trigger(e){
            if(this.resID){
                this.title='Cập nhật ký số'
                this.getDetail(this.resID)
            }
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
            title:'TẠO CHỮ KÝ SỐ',
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
            listCategoryParent: [],
            listModule: [],
            form:new FormData(),
            formData: {
                privatekey:'',
                publickey:'',
                hinhanhchuky:'',
                // signature:''
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
        if(this.resID){
            this.title='Cập nhật ký số'
            this.getDetail(this.resID)
        }
    },
    methods: {
        async checkUSB() {
            try {
                const device = await navigator.usb.requestDevice({
                filters: [] // Thay đổi vendorId theo thiết bị của bạn
                });
            console.log('USB device connected:', device);
            } catch (error) {
            console.error('No USB device selected or error:', error);
            }
        },
        pemToBase64(pem,type ='PUBLIC KEY') {
            // Step 1: Remove the PEM header and footer
            const base64String = pem
                .replace(`-----BEGIN ${type}-----`, '')
                .replace(`-----END ${type}-----`, '')
                .replace(/\s+/g, ''); // Remove all spaces and newlines

            return base64String;
        },
        // Hàm tạo cặp khóa ECDSA
        async generateKeys() {
            let privateKey='',publicKey=''
            await ApiService.query('http://localhost:3000/blocks/gen-key').then(({data})=>{
               privateKey = this.pemToBase64(data.privateKey,'PRIVATE KEY')
               publicKey = this.pemToBase64(data.publicKey)
            })
            return {privateKey, publicKey}
        },

        // Hàm lưu trữ khóa (giả định lưu trong localStorage)
        saveKeys(privateKey, publicKey) {
            localStorage.setItem('privateKey', JSON.stringify(privateKey));
            localStorage.setItem('publicKey', JSON.stringify(publicKey));
        },

        // Hàm ký thông điệp
        async signMessage(privateKey, message) {
            const importedPrivateKey = await crypto.subtle.importKey(
                'jwk',
                privateKey,
                {
                name: "ECDSA",
                namedCurve: "P-256",
                },
                false,
                ['sign']
            );
            const messageEncoded = new TextEncoder().encode(message);
            const signature = await crypto.subtle.sign(
                {
                name: "ECDSA",
                hash: { name: "SHA-256" }, // Thuật toán băm
                },
                importedPrivateKey,
                messageEncoded
            );

            return Array.from(new Uint8Array(signature)).map(b => b.toString(16).padStart(2, '0')).join('');

        },

        // Hàm xác minh chữ ký
        async verifySignature(publicKey, message, signatureHex) {
            const importedPublicKey = await crypto.subtle.importKey(
                'jwk',
                publicKey,
                {
                name: "ECDSA",
                namedCurve: "P-256",
                },
                false,
                ['verify']
            );
            const messageEncoded = new TextEncoder().encode(message);
            const signature = new Uint8Array(signatureHex.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

            const isValid = await crypto.subtle.verify(
                {
                name: "ECDSA",
                hash: { name: "SHA-256" }, // Thuật toán băm
                },
                importedPublicKey,
                signature,
                messageEncoded
            );
            return isValid;
        },


        messLimit() {
            this.$notify({
                title: 'Error',
                message: 'Không upload số lượng ảnh vượt quá mức cho phép',
                type: 'error'
            });
        },
        handleUploadChange(file) {
            if (this.fileList.findIndex(e => e.uid == file.uid) == -1) {
                this.fileList.push(file)
            }
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

        async getDetail(id) {
            let _this = this
            // _this.resID = id
            await axios({
                method: 'get',
                url: '/api/admin/users/detail/' + id,
            })
                .then(async({data}) => {
                    if (data['success']) {
                        let res = data['data']
                        if(res['publickey'] &&  res['privatekey']){
                            _this.formData.publickey = res['publickey']
                            _this.formData.privatekey = res['privatekey']
                        }else{
                            const { privateKey, publicKey } = await this.generateKeys();
                            _this.formData.publickey=publicKey
                            _this.formData.privatekey=privateKey
                        }

                        // const message = res['name'];
                        // if(res['signature']){
                            // _this.formData.signature=res['signature']
                        // }else{
                            // const signature = await _this.signMessage(JSON.parse(_this.formData.privatekey), message);
                            // await(_this.formData.signature=signature);
                        // }

                        if(res['hinhanhchuky']){
                            _this.fileList=[{url:res['hinhanhchuky'], id:1}]
                        }else{
                            _this.fileList=[]
                        }
                        //  res['hinhanhchuky'] && (_this.fileList=[{url:res['hinhanhchuky'], id:1}])
                    }

                }
            );
             // 4. Xác minh chữ ký
            // const isValid = await this.verifySignature(JSON.parse(_this.formData.publickey), 'This is a test message', _this.formData.signature);
            // console.log("Signature valid:", isValid);

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
        appendToFormData() {
            let _this = this
            _this.form =new FormData()
            Object.keys(this.formData).forEach(key => {
                if(this.formData[key]){
                     _this.form.set(key, this.formData[key])
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
                        url: '/api/admin/users/create-signature/' + _this.resID,
                        data: _this.form
                    })
                        .then(function (response) {
                            if (response.data['success']) {
                                _this.$notify({
                                    title: 'Success',
                                    message: response.data['mess'],
                                    type: 'success'
                                });
                                _this.$emit('close')
                                // _this.resetForm('formData')
                                // _this.resID = ''
                                // _this.$router.push({name:"UserList"})
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
