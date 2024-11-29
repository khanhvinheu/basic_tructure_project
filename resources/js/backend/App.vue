<template>
    <body class="ltr main-body leftmenu">
        <!-- Loader -->
        <div id="global-loader">
            <img src="/assetsSp/img/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- End Loader -->
        <!-- Page -->
        <div class="page">
            <!-- Main Header-->
            <Header></Header>
            <!-- End Main Header-->
            <!-- Sidemenu -->
            <Sidemenu></Sidemenu>
            <!-- End Sidemenu -->
            <!-- Main Content-->
            <div class="main-content side-content pt-0">

                <div class="main-container container-fluid">
                    <router-view></router-view>
                </div>
            </div>
            <!-- End Main Content-->
            <!-- Main Footer-->
            <Footer></Footer>
            <!--End Footer-->
        </div>
        <!-- End Page -->
        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
    </body>

</template>

<script>
import Footer from './template/footer.vue';
import Header from './template/header.vue';
import Sidemenu from './template/sidemenu.vue';


export default {
    name: 'app',
    components: { Sidemenu, Header, Footer }
};
</script>
