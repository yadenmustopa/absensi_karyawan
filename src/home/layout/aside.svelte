<script>
    "use strict"
    import getMenu from '../menu/index';
    import { createEventDispatcher } from 'svelte';

    const dispatch = createEventDispatcher();

    let role;

    let menus = [];
    let menu_active = "dashboard";

    $:if( role ){
        menus = getMenu( role );
        console.log({ role });
    }

    starter();

    function starter(){
        getStatus();
    }

    function getStatus(){
        let data_user = JSON.parse(localStorage.getItem('ak-data-user'));

        role = data_user.role;
    }

    function changeMenu( active ){
        menu_active = active;
        dispatch('change',{ menu_active });
    }


    let base_url = window.config.base_url;
</script>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/" target="_self">
        <img src="{ base_url }/assets/images/logo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold"> | Absensi Karywan</span>
      </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">

        <ul class="navbar-nav">
            
            { #each menus as menu }
                <li class="nav-item">
                    <a class="nav-link  { menu.href === menu_active ? 'active' : '' }" href="javascript:;" on:click = { () => { changeMenu( menu.href ) } }>

                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class={ menu.icon }></i>
                        </div>
                        
                        <span class="nav-link-text ms-1">{ menu.name }</span>

                    </a>
                </li>
            { /each }
        </ul>
    </div>
</aside>
