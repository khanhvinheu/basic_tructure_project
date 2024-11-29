import Vue from 'vue';
import VueRouter from 'vue-router';
import appConfig from '/config/appConfig'
Vue.use(VueRouter);

export const constantRouterMap = [
    {
        path: '/check-file-in-pdf/:id?',
        component: () => import('../components/CheckFile/index'),
        name:'CheckFile',
        meta:{title:'CheckFile'}
    },
    {
        path: '/login',
        component: () => import('../components/Auth/login'),
        name:'Login',
        meta:{title:'Login'}
    },
    {
        path: '/dashboard',
        component: ()=> import('../components/index'),
        name: 'admin',
        redirect: '/index',
        children: [
            //Dashboard
            {
                path: '/index',
                component: () => import('../components/Dashboard/index'),
                name:'Dashboard',
                meta:{title:'Home-Admin'}
            },
            //User
            {
                path: '/list-user',
                component: () => import('../components/User/list'),
                name:'UserList',
                meta:{title:'UserList'}
            },
            {
                path: '/list-user/create',
                component: () => import('../components/User/form'),
                name:'UserCreate',
                meta:{title:'UserCreate',type:'Form'}
            },
            {
                path: '/list-user/:id?',
                component: () => import('../components/User/form'),
                name:'UserUpdate',
                meta:{title:'UserUpdate', type:'Form'}
            },   
            {
                path: '/log',
                component: () => import('../components/User/blockChain.vue'),
                name:'Block',
                meta:{title:'UserUpdate', type:'Form'}
            },   
            //Module
            {
                path: '/list-module',
                component: () => import('../components/Module/list'),
                name:'ModuleList',
                meta:{title:'ModuleList'},
               
            },
            {
                path: '/list-module/create',
                component: () => import('../components/Module/form'),
                name:'ModuleCreate',
                meta:{title:'ModuleCreate',type:'Form'}
            },
            {
                path: '/list-module/:id?',
                component: () => import('../components/Module/form'),
                name:'ModuleUpdate',
                meta:{title:'ModuleUpdate',type:'Form'}
            },
            //Role
            {
                path: '/list-role',
                component: () => import('../components/Role/list'),
                name:'RoleList',
                meta:{title:'RoleList'},
               
            },
            {
                path: '/list-role/create',
                component: () => import('../components/Role/form'),
                name:'RoleCreate',
                meta:{title:'RoleCreate',type:'Form'}
            },
            {
                path: '/list-role/:id?',
                component: () => import('../components/Role/form'),
                name:'RoleUpdate',
                meta:{title:'RoleUpdate',type:'Form'}
            },
            //Action
            {
                path: '/action-module/:id_module?',
                component: () => import('../components/Action/list'),
                name:'ActionList',
                meta:{title:'ActionList'},
               
            },
            //Setting
            {
                path: '/settings',
                component: () => import('../components/Setting/index'),
                name:'Setting',
                meta:{title:'Settings'}
            },
            //Dot Cap
            {
                path: '/danh-sach-dot-cap',
                component: () => import('../components/DanhSachDotCap/list'),
                name:'DanhSachDotCap',
                meta:{title:'DanhSachDotCap'}
            },
            //Quan Ly Khoa Hoc
            {
                path: '/danh-sach-khoa-hoc',
                component: () => import('../components/DanhSachKhoaHoc/list'),
                name:'DanhSachKhoaHoc',
                meta:{title:'DanhSachKhoaHoc'}
            },
              //Quan Ly Cap Chung Chi
            {
                path: '/danh-sach-cap-chung-chi',
                component: () => import('../components/DanhSachCapChungChi/list'),
                name:'DanhSachCapChungChi',
                meta:{title:'DanhSachCapChungChi'}
            },
            {
                path: '/danh-sach-cap-chung-chi/create',
                component: () => import('../components/DanhSachCapChungChi/form'),
                name:'CapChungChiCreate',
                meta:{title:'UserCreate',type:'Form'}
            },
            {
                path: '/danh-sach-cap-chung-chi/:id?',
                component: () => import('../components/DanhSachCapChungChi/form'),
                name:'CapChungChiUpdate',
                meta:{title:'UserUpdate', type:'Form'}
            },   
        ]
    },
    {
        path: '/404',
        component: () => import('../../common/404'),
        meta:{
            title:'404-PageNotFound'
        }
    },
   
    {
        path: '/*',
        component: () => import('../view/redirect'),
    }

];

export const asyncRouterMap = [];
const createRouter = () =>
    new VueRouter({
        linkActiveClass: 'active', // active class
        mode: 'history',
        base: '/admin',
        routes: constantRouterMap,
        scrollBehavior: to => {
            if (to.hash) {
                return { selector: to.hash };
            } else {
                return { x: 0, y: 0 };
            }
        },
    });
const router = createRouter();
// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher; // reset router
}

const DEFAULT_TITLE ='ECDSA';
router.afterEach((to,from) => {  
    document.title =(DEFAULT_TITLE + ' - ' + to.meta.title )|| DEFAULT_TITLE + ' - '+(to.name);
});
(function() { 
    var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
    link.type = 'image/x-icon';
    link.rel = 'shortcut icon';
    link.href = appConfig.LOGO_META;
    document.getElementsByTagName('head')[0].appendChild(link);
})();


export default router;
