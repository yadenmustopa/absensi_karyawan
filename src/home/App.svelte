<script>
    "use strict";
    import { onMount } from 'svelte';
    import Login from "./page/login/index.svelte";


    let page=['login','home'];
    let current_page = 'home';

    const API_KEY = localStorage.getItem('ak-api-key');

    if( !API_KEY ){
        current_page = 'login';
    }
</script>

{ #if ( current_page === 'login' ) }
    <Login></Login>
{ /if }