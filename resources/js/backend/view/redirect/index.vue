<script>
    export default {
        beforeCreate() {            
            const {params, query} = this.$route;
            const {pathMatch} = params;  
            let pathDefault = this.$store.getters.user.ModuleDefault[0].path
            if (pathMatch == undefined || pathMatch=='' || pathMatch =='/admin') {
                if(pathDefault){
                    this.$router.replace({path: pathDefault});
                }else{
                    this.$router.replace({path: '/index'});
                }
            } else {                
                // this.$router.replace({ path: '/' + path, query });              
                this.$router.replace({path: '/404'});
            }
        },
        render: function (h) {
            return h(); // avoid warning message
        },
    };
</script>
