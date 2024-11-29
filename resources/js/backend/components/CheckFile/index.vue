<template>

    <div class="main-login">
        <div class="header-page">
            <div class="container-header">
                <div style="display: flex; align-items: center;">
                    <div class="box-logo">
                        <img class="img-logo" style="width:100%; height: auto;" src="/images/logo.webp" />
                    </div>
                    <div style="padding: 10px;">
                        <span class="text-header">HỆ THỐNG QUẢN LÝ VÀ CẤP CHỨNG NHẬN TỐT NGHIỆP</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pdf-box" v-if="showPdf">
            <embed v-if="pdfSrc" style="width: 100%; height: 100%" :src="pdfSrc" title="Embedded PDF Viewer"
                type="application/pdf" />
            <div v-if="loading===false && !pdfSrc" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <lottie-animation style="width: 300px; height: 300px;" ref="anim"
                    :animationData="require('../../../common/Animation - 1731050852688.json')" />
                <span><i>Chứng chỉ không tồn tại, Vui lòng kiểm tra lại mã QR</i></span>
                <br>
                <el-button icon="el-icon-back" @click="showPdf = false">Quay về </el-button>
            </div>
            <div v-if="loading===true" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">              
                <!-- <lottie-animation  v-if="loading===true" style="width: 300px; height: 300px;" ref="anim"
                    :animationData="require('../../../common/Animation - 1731053803101.json')" />                -->
                    <lottie-animation style="width: 300px; height: 300px;" ref="anim"
                    :animationData="require('../../../common/Animation - 1731050852688.json')" />
            </div>
        </div>
        <div class="menu-box" v-else>
            <div class="hexagon-menu clear">
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fa fa-universal-access"></i>
                            </span>
                            <span class="title">Trang chủ</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
                <div class="hexagon-item" @click="navLogin()">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fa fa-id-badge"></i>
                            </span>
                            <span class="title">Hệ thống quản lý</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
                <div class="hexagon-item"  @click="validFile()">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fa fa-bullseye"></i>
                            </span>
                            <span class="title">Kiểm tra chứng chỉ</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>
                <div class="hexagon-item">
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="hex-item">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <a class="hex-content">
                        <span class="hex-content-inner">
                            <span class="icon">
                                <i class="fa fa-braille"></i>
                            </span>
                            <span class="title">Liên hệ</span>
                        </span>
                        <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                fill="#1e2530"></path>
                        </svg>
                    </a>
                </div>                
            </div>
        </div>
        <el-dialog :visible.sync="validDialog" width="50vw">
            <div style="margin-top: -30px">
                <span style="font-size: 13px; font-weight: bold; text-transform: uppercase">KIỂM TRA TÍNH HỢP LỆ CỦA CHỨNG CHỈ</span>
                <el-divider></el-divider>
            </div>
            <div>
                <el-upload
                    accept=".pdf"
                    class="upload-demo"
                    drag
                    action=""
                    :limit="1"
                    :on-change="readPdf"
                    :auto-upload="false"
                    :on-remove="handleRemove"
                    :before-upload="beforeUpload"
                    :file-list="fileList">
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text"><em>Click to upload</em></div>
                    <!-- <div class="el-upload__tip" slot="tip">pdf files with a size less than 500kb</div> -->
                </el-upload>
            </div>
            <div v-if="publicKey=='' || signature==''">
                <el-alert v-if="fileList.length>0"
                          title="File tải lên chưa được ký duyệt hoặc không đúng định dạng, Vui lòng kiểm tra lại"
                          type="error">
                </el-alert>
            </div>
            <div v-else>
                <el-alert
                    :closable=false
                    title="File tải lên đã hợp lệ"
                    type="success">
                </el-alert>
            </div>
            <el-divider v-if="publicKey && signature" content-position="left">
                <el-button v-show="publicKey && signature" style="margin-left: 10px;" size="small" type="success"
                           @click="validKey()">Kiểm tra tính hợp lệ chữ ký
                </el-button>
            </el-divider>
            <el-progress v-if="percentage>0 && percentage<100" :percentage="percentage" color="success"></el-progress>
            <div v-if="percentage==100">
                <el-alert v-if="statusValid===true"
                          :closable=false
                          title="Kết quả"
                          type="success"
                          description="Khóa hợp lệ"
                          show-icon>
                </el-alert>
                <el-alert v-if="statusValid===false"
                          :closable=false
                          title="Kết quả"
                          type="error"
                          description="Khóa không hợp lệ"
                          show-icon>
                </el-alert>
            </div>

        </el-dialog>
    </div>
</template>
<script>

import { PDFDocument, rgb } from "pdf-lib";
import fontkit from '@pdf-lib/fontkit'; // Import fontkit
import robotoFont from '/assets/fonts/Roboto-Regular.ttf'; // Đường dẫn đến phông chữ
import robotoItalicFont from '/assets/fonts/Roboto-Italic.ttf'; // Đường dẫn đến phông chữ
import backgroundImage from '/assets/chungchimau/chungchiv2.jpg';
import backgroundImage2 from '/assets/chungchimau/chungchimau_back.jpg';
import QRCode from 'qrcode';
import VueQRCodeComponent from 'vue-qrcode-component'
import moment from 'moment/moment';
import LottieAnimation from 'lottie-web-vue'
import genPdfFunction from "../../common/genPdfFunction";
export default {
    data() {
        return {
            data: '',
            pdfSrc: '',
            showPdf: false,
            loading:true,
            fileList: [],
            validDialog:false,
            percentage: 0,
            publicKey:'',
            signature:''

        }
    },
    components: { VueQRCodeComponent, LottieAnimation },
    mixins:[genPdfFunction],
    watch: {
        $route(to, from) {
            if(this.$route.params.id){
                this.getDetail(this.$route.params.id)                
            }
        }
    },
    mounted() {
        if(this.$route.params.id){
            this.showPdf=true
            this.getDetail(this.$route.params.id)
        }else{
            this.showPdf=false
        }
       
    },
    methods: {
        navLogin(){
            this.$router.push({name:'Login'})
        },
        beforeUpload(file) {
            if (this.fileList.length >= 1) {
                this.fileList.splice(0, 1); // Remove existing file
            }
            return true; // Allow upload
        },
        fakeLoading() {
            this.percentage = 0
            setInterval(() => {
                if (this.percentage < 100) {
                    this.percentage += 10;
                }
            }, 100);
        },
        handleRemove(el) {
            this.fileList = this.fileList.filter(e => e.uid != el.uid)
            this.publicKey = this.signature = this.statusValid = ''
        },
        validFile() {
            this.validDialog = true
        },       
        validKey() {
            this.fakeLoading()
            axios({
                method: 'post',
                url: 'http://localhost:3000/blocks/isChainValid',
                data: {
                    publicKey: this.publicKey,
                    providedSignature: this.signature
                }
            }).then(({data}) => {
                this.showValidMess = this.statusValid = data.status
            });
        },
        async readPdf() {
            const file = event.target.files[0];
            const arrayBuffer = await file.arrayBuffer();

            const pdfDoc = await PDFDocument.load(arrayBuffer);

            // 7. Đọc Public Key từ metadata (trường Author)
            const author = pdfDoc.getAuthor();
            const signature = pdfDoc.getSubject();

            if (!author && !signature) {
                this.$notify({
                    title: 'Error',
                    message: 'File tải lên không hợp lệ',
                    type: 'error'
                });
                this.fileList = []
            } else {
                this.publicKey = author || '';
                this.signature = signature || '';
            }


        },
        async getDetail(id) {
            let _this = this
            _this.loading=true
            _this.idUpdate = id
            await axios({
                method: 'get',
                url: '/api/admin/cap-chung-chi/detail/' + id,
            })
                .then(({ data }) => {
                    if (data['success'] && data['data'] && data['data']['maHoSoKyDuyet'] != null) {
                        let res = data['data']
                        this.data = res
                        this.signPfd(res, true)
                    }
                    setTimeout(()=>{                     
                        this.loading=false
                    },1000)
                });

        },
        
    }
}
</script>
<style lang="scss">
.header-page {
    height: 100px;
    width: calc(100%);
    background: rgb(245, 241, 241, 0.9);
    position: fixed;
    top: 0;
    display: flex;
    justify-content: center;

    .container-header {
        width: 80%;
        height: 100%;
        display: flex;
        justify-content: space-between;
        padding: 10px;
    }

    .box-logo {
        margin-top: 40px;
        height: 120px;
        width: 120px;
        background-color: rgb(245, 241, 241);
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        padding: 10px;
    }

    .text-header {
        text-transform: uppercase;
        font-weight: bold;
        font-size: 18px;
        color: #ee4d2d;
    }
}

.main-login {
    display: flex;
    justify-content: center;
    align-items: center;
    /* background-color: #2d3a4b; */
    background-image: url('/img/bg.PNG');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    width: 100%;
}

.pdf-box {
    margin-top: 100px;
    background-color: rgb(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    /* background-color: rgb(0,0,0, 0.6); */
    // box-shadow: -16px 18px 0px 5px rgba(222,222,222,0.08);
    // -webkit-box-shadow: -16px 18px 0px 5px rgba(222,222,222,0.08);
    // -moz-box-shadow: -16px 18px 0px 5px rgba(222,222,222,0.08);
    width: 80vw;
    height: 80vh;
}

.menu-box {
    margin-top: 100px;
    // background-color: rgb(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    /* background-color: rgb(0,0,0, 0.6); */
    // box-shadow: -16px 18px 0px 5px rgba(222, 222, 222, 0.08);
    // -webkit-box-shadow: -16px 18px 0px 5px rgba(222, 222, 222, 0.08);
    // -moz-box-shadow: -16px 18px 0px 5px rgba(222, 222, 222, 0.08);
    min-width: 500px;
    padding: 50px;
}

.heading-page {
    text-transform: uppercase;
    font-size: 43px;
    font-weight: bolder;
    letter-spacing: 3px;
    color: white;
}

a {
    color: inherit;
    -webkit-transition: all 0.3s ease 0s;
    -moz-transition: all 0.3s ease 0s;
    -o-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}

a:hover,
a:focus {
    color: #ababab;
    text-decoration: none;
    outline: 0 none;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    color: #1e2530;
    font-family: "Open Sans", sans-serif;
    margin: 0;
    line-height: 1.3;
}

p {
    margin-bottom: 20px;
}

p:last-child {
    margin-bottom: 0;
}

/*
 * Selection color
 */
::-moz-selection {
    background-color: #FA6862;
    color: #fff;
}

::selection {
    background-color: #FA6862;
    color: #fff;
}

/*
 *  Reset bootstrap's default style
 */
.form-control::-webkit-input-placeholder,
::-webkit-input-placeholder {
    opacity: 1;
    color: inherit;
}

.form-control:-moz-placeholder,
:-moz-placeholder {
    /* Firefox 18- */
    opacity: 1;
    color: inherit;
}

.form-control::-moz-placeholder,
::-moz-placeholder {
    /* Firefox 19+ */
    opacity: 1;
    color: inherit;
}

.form-control:-ms-input-placeholder,
:-ms-input-placeholder {
    opacity: 1;
    color: inherit;
}

button,
input,
select,
textarea,
label {
    font-weight: 400;
}

.btn {
    -webkit-transition: all 0.3s ease 0s;
    -moz-transition: all 0.3s ease 0s;
    -o-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}

.btn:hover,
.btn:focus,
.btn:active:focus {
    outline: 0 none;
}

.btn-primary {
    background-color: #FA6862;
    border: 0;
    font-family: "Open Sans", sans-serif;
    font-weight: 700;
    height: 48px;
    line-height: 50px;
    padding: 0 42px;
    text-transform: uppercase;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary:active:focus {
    background-color: #f9423a;
}

.btn-border {
    border: 1px solid #d7d8db;
    display: inline-block;
    padding: 7px;
}

/*
 *  CSS Helper Class
 */
.clear:before,
.clear:after {
    content: " ";
    display: table;
}

.clear:after {
    clear: both;
}

.pt-table {
    display: table;
    width: 100%;
    height: -webkit-calc(100vh - 4px);
    height: -moz-calc(100vh - 4px);
    height: calc(100vh - 4px);
}

.pt-tablecell {
    display: table-cell;
    vertical-align: middle;
}

.overlay {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}

.relative {
    position: relative;
}

.primary,
.link:hover {
    color: #FA6862;
}

.no-gutter {
    margin-left: 0;
    margin-right: 0;
}

.no-gutter>[class^="col-"] {
    padding-left: 0;
    padding-right: 0;
}

.flex {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
}

.flex-middle {
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    align-items: center;
}

.space-between {
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    -webkit-justify-content: space-between;
    -moz-justify-content: space-between;
    justify-content: space-between;
}

.nicescroll-cursors {
    background: #FA6862 !important;
}

.preloader {
    bottom: 0;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1000;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
}

.preloader.active.hidden {
    display: none;
}

.loading-mask {
    background-color: #FA6862;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 20%;
    -webkit-transition: all 0.6s cubic-bezier(0.61, 0, 0.6, 1) 0s;
    -moz-transition: all 0.6s cubic-bezier(0.61, 0, 0.6, 1) 0s;
    -o-transition: all 0.6s cubic-bezier(0.61, 0, 0.6, 1) 0s;
    transition: all 0.6s cubic-bezier(0.61, 0, 0.6, 1) 0s;
}

.loading-mask:nth-child(2) {
    left: 20%;
    -webkit-transition-delay: 0.1s;
    -moz-transition-delay: 0.1s;
    -o-transition-delay: 0.1s;
    transition-delay: 0.1s;
}

.loading-mask:nth-child(3) {
    left: 40%;
    -webkit-transition-delay: 0.2s;
    -moz-transition-delay: 0.2s;
    -o-transition-delay: 0.2s;
    transition-delay: 0.2s;
}

.loading-mask:nth-child(4) {
    left: 60%;
    -webkit-transition-delay: 0.3s;
    -moz-transition-delay: 0.3s;
    -o-transition-delay: 0.3s;
    transition-delay: 0.3s;
}

.loading-mask:nth-child(5) {
    left: 80%;
    -webkit-transition-delay: 0.4s;
    -moz-transition-delay: 0.4s;
    -o-transition-delay: 0.4s;
    transition-delay: 0.4s;
}

.preloader.active.done {
    z-index: 0;
}

.preloader.active .loading-mask {
    width: 0;
}

/*------------------------------------------------
	Start Styling
-------------------------------------------------*/
.mt20 {
    margin-top: 20px;
}

.site-wrapper {
    border-top: 4px solid #ff0037;
}

.page-close {
    font-size: 30px;
    position: absolute;
    right: 30px;
    top: 30px;
    z-index: 100;
}

.page-title {
    margin-bottom: 75px;
}

.page-title img {
    margin-bottom: 20px;
}

.page-title h2 {
    font-size: 68px;
    margin-bottom: 25px;
    position: relative;
    z-index: 0;
    font-weight: 900;
    text-transform: uppercase;
}

.page-title p {
    font-size: 14px;
    font-family: monospace;
    line-height: 21px;
}

.page-title .title-bg {
    color: rgba(30, 37, 48, 0.07);
    font-size: 158px;
    left: 0;
    letter-spacing: 10px;
    line-height: 0.7;
    position: absolute;
    right: 0;
    top: 50%;
    z-index: -1;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
}

.section-title {
    margin-bottom: 20px;
}

.section-title h3 {
    display: inline-block;
    position: relative;
}

.section-title h3::before,
.section-title h3::after {
    content: "";
    height: 2px;
    position: absolute;
    bottom: 8px;
    left: -webkit-calc(100% + 14px);
    left: -moz-calc(100% + 14px);
    left: calc(100% + 14px);
}

.section-title h3::before {
    background-color: #1e2530;
    width: 96px;
    bottom: 14px;
}

.section-title h3::after {
    background-color: #FA6862;
    width: 73px;
}

.section-title.light h3 {
    color: #fff;
}

.section-title.light h3::before {
    background-color: #fff;
}

.page-nav {
    bottom: 40px;
    left: 0;
    position: absolute;
    right: 0;
}

.page-nav span {
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    font-weight: 500;
    line-height: 0.9;
    text-transform: uppercase;
}

/*------------------------------------------------
    Home Page
-------------------------------------------------*/

.hexagon-item:first-child {
    margin-left: 0;
}

.page-home {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    vertical-align: middle;
}

//   .page-home .overlay {
// background-color: rgba(14, 17, 24, 0.97);
// background-image:url("https://images.unsplash.com/photo-1682686581220-689c34afb6ef?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
// }

/* End of container */
.hexagon-item {
    cursor: pointer;
    width: 200px;
    height: 173.20508px;
    float: left;
    margin-left: -29px;
    z-index: 0;
    position: relative;
    -webkit-transform: rotate(30deg);
    -moz-transform: rotate(30deg);
    -ms-transform: rotate(30deg);
    -o-transform: rotate(30deg);
    transform: rotate(30deg);
}

.hexagon-item:first-child {
    margin-left: 0;
}

.hexagon-item:hover {
    z-index: 1;
}

.hexagon-item:hover .hex-item:last-child {
    opacity: 1;
    -webkit-transform: scale(1.3);
    -moz-transform: scale(1.3);
    -ms-transform: scale(1.3);
    -o-transform: scale(1.3);
    transform: scale(1.3);
}

.hexagon-item:hover .hex-item:first-child {
    opacity: 1;
    -webkit-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -ms-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
}

.hexagon-item:hover .hex-item:first-child div:before,
.hexagon-item:hover .hex-item:first-child div:after {
    height: 5px;
}

.hexagon-item:hover .hex-item div::before,
.hexagon-item:hover .hex-item div::after {
    background-color: #ff0037;
}

.hexagon-item:hover .hex-content svg {
    -webkit-transform: scale(0.97);
    -moz-transform: scale(0.97);
    -ms-transform: scale(0.97);
    -o-transform: scale(0.97);
    transform: scale(0.97);
}

.page-home .hexagon-item:nth-last-child(1),
.page-home .hexagon-item:nth-last-child(2),
.page-home .hexagon-item:nth-last-child(3) {
    -webkit-transform: rotate(30deg) translate(87px, -80px);
    -moz-transform: rotate(30deg) translate(87px, -80px);
    -ms-transform: rotate(30deg) translate(87px, -80px);
    -o-transform: rotate(30deg) translate(87px, -80px);
    transform: rotate(30deg) translate(87px, -80px);
}

.hex-item {
    position: absolute;
    top: 0;
    left: 50px;
    width: 100px;
    height: 173.20508px;
}

.hex-item:first-child {
    z-index: 0;
    -webkit-transform: scale(0.9);
    -moz-transform: scale(0.9);
    -ms-transform: scale(0.9);
    -o-transform: scale(0.9);
    transform: scale(0.9);
    -webkit-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    -moz-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    -o-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.hex-item:last-child {
    transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
    z-index: 1;
}

.hex-item div {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    width: 100px;
    height: 173.20508px;
    -webkit-transform-origin: center center;
    -moz-transform-origin: center center;
    -ms-transform-origin: center center;
    -o-transform-origin: center center;
    transform-origin: center center;
}

.hex-item div::before,
.hex-item div::after {
    background-color: #1e2530;
    content: "";
    position: absolute;
    width: 100%;
    height: 3px;
    -webkit-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
    -moz-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
    -o-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
}

.hex-item div:before {
    top: 0;
}

.hex-item div:after {
    bottom: 0;
}

.hex-item div:nth-child(1) {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
}

.hex-item div:nth-child(2) {
    -webkit-transform: rotate(60deg);
    -moz-transform: rotate(60deg);
    -ms-transform: rotate(60deg);
    -o-transform: rotate(60deg);
    transform: rotate(60deg);
}

.hex-item div:nth-child(3) {
    -webkit-transform: rotate(120deg);
    -moz-transform: rotate(120deg);
    -ms-transform: rotate(120deg);
    -o-transform: rotate(120deg);
    transform: rotate(120deg);
}

.hex-content {
    color: #fff;
    display: block;
    height: 180px;
    margin: 0 auto;
    position: relative;
    text-align: center;
    transform: rotate(-30deg);
    width: 156px;
}

.hex-content .hex-content-inner {
    left: 50%;
    margin: -3px 0 0 2px;
    position: absolute;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

.hex-content .icon {
    display: block;
    font-size: 36px;
    line-height: 30px;
    margin-bottom: 11px;
}

.hex-content .title {
    display: block;
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    letter-spacing: 1px;
    line-height: 24px;
    text-transform: uppercase;
}

.hex-content svg {
    left: -7px;
    position: absolute;
    top: -13px;
    transform: scale(0.87);
    z-index: -1;
    -webkit-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
    -moz-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
    -o-transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) 0s;
}

.hex-content:hover {
    color: #fff;
}

.page-home .hexagon-item:nth-last-child(1),
.page-home .hexagon-item:nth-last-child(2),
.page-home .hexagon-item:nth-last-child(3) {
    -webkit-transform: rotate(30deg) translate(87px, -80px);
    -moz-transform: rotate(30deg) translate(87px, -80px);
    -ms-transform: rotate(30deg) translate(87px, -80px);
    -o-transform: rotate(30deg) translate(87px, -80px);
    transform: rotate(30deg) translate(87px, -80px);
}

/*------------------------------------------------
    Welcome Page
-------------------------------------------------*/
.author-image-large {
    position: absolute;
    right: 0;
    top: 0;
}

.author-image-large img {
    height: -webkit-calc(100vh - 4px);
    height: -moz-calc(100vh - 4px);
    height: calc(100vh - 4px);
}


@media (min-width: 1200px) {
    .col-lg-offset-2 {
        margin-left: 16.66666667%;
    }
}

@media (min-width: 1200px) {
    .col-lg-8 {
        width: 66.66666667%;
    }
}

.hexagon-item:first-child {
    margin-left: 0;
}

.pt-table.desktop-768 .pt-tablecell {
    padding-bottom: 110px;
    padding-top: 60px;
}



.hexagon-item:hover .icon i {
    color: #ff0037;
    transition: 0.6s;

}


.hexagon-item:hover .title {
    -webkit-animation: focus-in-contract 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    animation: focus-in-contract 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}

/***************************/

@-webkit-keyframes focus-in-contract {
    0% {
        letter-spacing: 1em;
        -webkit-filter: blur(12px);
        filter: blur(12px);
        opacity: 0;
    }

    100% {
        -webkit-filter: blur(0px);
        filter: blur(0px);
        opacity: 1;
    }
}

@keyframes focus-in-contract {
    0% {
        letter-spacing: 1em;
        -webkit-filter: blur(12px);
        filter: blur(12px);
        opacity: 0;
    }

    100% {
        -webkit-filter: blur(0px);
        filter: blur(0px);
        opacity: 1;
    }
}





@media only screen and (max-width: 767px) {
    .hexagon-item {
        float: none;
        margin: 0 auto 50px;
    }

    .hexagon-item:first-child {
        margin-left: auto;
    }

    .page-home .hexagon-item:nth-last-child(1),
    .page-home .hexagon-item:nth-last-child(2),
    .page-home .hexagon-item:nth-last-child(3) {
        -webkit-transform: rotate(30deg) translate(0px, 0px);
        -moz-transform: rotate(30deg) translate(0px, 0px);
        -ms-transform: rotate(30deg) translate(0px, 0px);
        -o-transform: rotate(30deg) translate(0px, 0px);
        transform: rotate(30deg) translate(0px, 0px);
    }

}
</style>
