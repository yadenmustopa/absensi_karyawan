<script>
    "use strict";
    import { onMount, createEventDispatcher } from 'svelte';
    import Login from "./page/login/index.svelte";
    import Storage from './store/Storage';
    import Home from "./index.svelte";
    import AddModal from './layout/modal/add_user';

    onMount( ()=>{})

    const Store = new Storage();
    const dispatch = new createEventDispatcher();

    let page=['login','home'];
    let current_page = 'home';
    let role ;

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


    function auth( e ){
        changeCurrentPage('home');
        let data = e.detail.data;
        role     = data.role;
    }

</script>

{ #if ( current_page === 'login' ) }
    <Login on:auth = { auth }></Login>
{ :else }
    <Home on:logout = { () => { changeCurrentPage('login') } } role = { role } ></Home>
{ /if }


