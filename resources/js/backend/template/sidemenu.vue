<template>    
     <!-- Sidemenu -->
    <div class="sticky">
        <div class="main-menu main-sidebar main-sidebar-sticky side-menu">
            <div class="main-sidebar-header main-container-1 active">
                <div class="sidemenu-logo">
                    <a class="main-logo" href="index.html">
                        <img src="/assetsSp/img/brand/logo-light.png" class="header-brand-img desktop-logo" alt="logo">
                        <img src="/assetsSp/img/brand/icon-light.png" class="header-brand-img icon-logo" alt="logo">
                        <img src="/assetsSp/img/brand/logo.png" class="header-brand-img desktop-logo theme-logo" alt="logo">
                        <img src="/assetsSp/img/brand/icon.png" class="header-brand-img icon-logo theme-logo" alt="logo">
                    </a>
                </div>
                <div class="main-sidebar-body main-body-1">
                    <div class="slide-left disabled" id="slide-left"><i class="fe fe-chevron-left"></i></div>
                    <ul class="menu-nav nav">
                        <li class="nav-header"><span class="nav-label">Dashboard</span></li>
                        <li class="nav-item">
                            <a class="nav-link" href="/index">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-home sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link with-sub" href="javascript:void(0)">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i  class="ti-wallet sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">User
                                    <span class="sidemenu-label2">Management</span>
                                </span>
                                <i class="angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="nav-sub">
                                <li class="side-menu-label1"><a href="javascript:void(0)">Crypto Currencies</a></li>
                                <li class="nav-sub-item"> <a class="nav-sub-link" href="/list-user">List user</a></li>
                                <li class="nav-sub-item"><a class="nav-sub-link" href="/list-role">List role</a></li>
                                <li class="nav-sub-item"><a class="nav-sub-link" href="/list-module">List module</a></li>                         
                            </ul>
                        </li>                    
                        <li class="nav-header"><span class="nav-label">Setting system</span></li>
                        <li class="nav-item">
                            <a class="nav-link" href="/settings">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-layout sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">Setting</span>
                            </a>
                        </li>
                                          
                    </ul>
                    <div class="slide-right" id="slide-right"><i class="fe fe-chevron-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sidemenu -->    
</template>

<script>
export default {
    name: 'sidemenu',
};
</script>
