<script>
    import Aside from './layout/aside.svelte';
    import Main from './layout/main.svelte';
    import Fixed from './layout/fixed.svelte';

    import { createEventDispatcher, onMount } from 'svelte';

    const dispatch = createEventDispatcher();
    export let status = "";

    const HAK_AKSES_ADMIN = ['DASHBOARD','USER'];
    const HAK_AKSES_KARYAWAN = [];

    onMount( ()=>{
       init();
       
    });

    function init(){
 
    }

    function logout()
    {
        localStorage.setItem('ak-key','');
        localStorage.setItem('ak-data-user','');

        dispatch('logout',{ logout : true });

    }
</script>

<Aside></Aside>
<!-- <Main></Main>
<Fixed></Fixed> -->







 