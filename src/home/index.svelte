<script>
    import Aside from './layout/aside.svelte';
    import Main from './layout/main.svelte';
    import Fixed from './layout/fixed.svelte';

    import { createEventDispatcher, onMount } from 'svelte';

    const dispatch = createEventDispatcher();
    export let status = "";
    let menu_active = 'dashboard';


    onMount( ()=>{
       init();
       
    });

    function init(){
 
    }

    function changeMenu( e ){
        menu_active = e.detail.menu_active ;
    }

    function triggerLogout(){
        dispatch( 'logout', { "logout" : true });
    }
</script>

<Aside status = { status } on:change = {  changeMenu }></Aside>
<Main menu_active = { menu_active } on:logout = { triggerLogout } ></Main>
<!-- <Fixed></Fixed>  -->







 