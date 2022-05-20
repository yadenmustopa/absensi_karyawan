<script>
    "use strict";
    import { onMount, createEventDispatcher } from 'svelte';
    import Login from "./page/login/index.svelte";
    import Storage from './store/Storage';
    import Home from "./index.svelte";

    const Store = new Storage();
    const dispatch = new createEventDispatcher();

    let page=['login','home'];
    let current_page = 'home';

    const API_KEY = localStorage.getItem('ak-key');


    if( !API_KEY ){
        current_page = 'login';
    }else{
        current_page = 'home';
    }

    /**
     * 
     * @param { String } page
     */
    function changeCurrentPage( page = 'login' ){
        current_page = page;
    }

</script>

{ #if ( current_page === 'login' ) }
    <Login on:auth = { changeCurrentPage('home') }></Login>
{ :else }
    <Home on:logout = { changeCurrentPage('login') }></Home>
{ /if }