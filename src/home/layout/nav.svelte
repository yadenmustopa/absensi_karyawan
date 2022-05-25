<script>
    export let menu_active = "dashboard";
    export let user;
    import Dropdown from 'sv-bootstrap-dropdown';
	let dropdownTrigger;


    function logout()
    {
        localStorage.setItem('ak-key','');
        localStorage.setItem('ak-data-user','');

        window.location.href="/";   
    }
</script>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active text-first-letter-uppercase" aria-current="page">{ menu_active }</li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-first-letter-uppercase">{ menu_active }</h6>
        </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                
        </div>
        <ul class="navbar-nav  justify-content-end">
        
            <!-- <li class="nav-item d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                    
                </a>
            </li> -->
            <Dropdown triggerElement={dropdownTrigger}>
                <button
                    type="button"
                    class="dropdown-toggle"
                    bind:this={dropdownTrigger}
                    >
                    <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none"><b class="text-first-letter-uppercase">{ ( user ) ? user : 'User' }</b></span>
                </button>
                <div slot="DropdownMenu">
                    <a class="dropdown-item border-radius-md" href="#" on:click={ logout }>
                        <div class="d-flex py-1">
                            <i class="fas fa-power-off text-danger"></i> &nbsp; Logout
                        </div>
                    </a>
                </div>
            </Dropdown>

            <!-- <li class="nav-item dropdown pe-2 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none"><b class="text-first-letter-uppercase">{ ( user ) ? user : 'User' }</b></span>
                </a>
                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">

                        <a class="dropdown-item border-radius-md" href="#" on:click={ logout }>
                            <div class="d-flex py-1">
                                <i class="fas fa-power-off text-danger"></i> &nbsp; Logout
                            </div>
                        </a>
            
                    </li>
                </ul>
            </li> -->



            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>

            
        </ul>
    </div>
</nav>