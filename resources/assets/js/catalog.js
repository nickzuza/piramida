import Multiselect from 'vue-multiselect';
if(document.getElementById('catalogPage')){
    window.catalogPage = new Vue({
        el:"#catalogPage",
        data:{
          filter:window.options[2],
          options:window.options
        },
        methods:{
            changeFilter(){
                console.log(1);
            },
        },
        components:{Multiselect}
    });
}