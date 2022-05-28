<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { convertToDate } from '../../lib/handle-moment';
    import ModalAdd from '../modal/add_user';
    import ModalUpdate from '../modal/update_user.svelte';
    import ModalUpdatePwd from '../modal/update_password.svelte';
    import { confirm, alertToast } from '../../lib/alert';
    import preloader from '../../lib/preloader';
    import Pagination from '../component/pagination.svelte';
    import InfoResult from '../component/info_result.svelte';
    // import { createEventDispatcher } from 'svelte';

    // const dispatch     = createEventDispatcher();

    let search;
    let users = [];
    let data_selected;
    let role_access;
    let pagination;
    let per_page;
    let page =  1;
    let count_all = 0;
    let offset    = 0;
    let filter;
    let sort_by = "`id`:DESC" ;

    starter();

    $:if( search || ! search ){
        getDataUsers();
    }

    // $:if( restart ){
    //     toggleRestart();
    // }

    function starter(){
        getDataUsers();
        getRoleAccess();
    }


    // function toggleRestart(){
    //     starter();
    // }

    function getDataUsers(){
        let Request = new Rest();
        let data    = { page, per_page, filter, sort_by };

        if( search ){
            Object.assign( data, { search });
        }

        let request = Request.getUsers( data );

        request.then( ( res )=>{
            let body   = res.getBody();
            users      = body.data;
            pagination = body.pagination;
            count_all  = pagination.count_all;
            offset     = pagination.offset;
            console.log({ pagination });
        });
    }

    /**
     * 
     * @param { Object } data
     * @param { String } data.name
     * @param { String } data.user_id
     * @param { String } data.role
     * 
     */
    function changeDataSelected( data ){
        data_selected = data 
    }

    /**
     * 
     * @param { Object } data
     * @param { String } data.role_access
     * @param { String } data.user_id
     * 
     */
    function changeDataSelectedPwd( data ){
        data_selected = data 
    }

    function getRoleAccess(){
        let data_user = localStorage.getItem('ak-data-user');
        data_user     = JSON.parse( data_user );

        role_access   = data_user.role;
    }

    /**
     * 
     * @param { Number } id
     * @param { Name }name
     */
    function deleteUser( id = 0, name = "" ){
        let oke_delete = confirm("Yakin Mau Hapus Akun ", "Hapus");

        oke_delete.then(( res )=>{
            preloader.show();

            let Request = new Rest();
            let request = Request.deleteUsers( id );

            request.then( () => { 
                preloader.hide();
                alertToast("Berhasil", "data berhasil di hapus", "success" , "top-end", 3000 );
                starter();
            })
        });
    }

    function getBGByRole( role = "ADMIN" ){
        return ( role === 'ADMIN' ) ? 'bg-gradient-info' : 'bg-gradient-warning'; 
    }

    /**
     * 
     * @param { Object } e
     */
     function changePage( e ){
        let page_to = e.detail.page_to;
        page        = page_to;
        getDataUsers();
    }

    /**
     * 
     * @param { Object } e
     */
    function changeFilter( e ){
        filter = e.target.value;
        getDataUsers();
    }


    /**
     * 
     * @param { Object } e
     */
    function changeSortBy( e ){
        sort_by = e.target.value;
        getDataUsers();
    }


    /**
     * 
     * @param { Object } e
     */
    function changePerPage( e ){
        per_page =  e.target.value;
        getDataUsers();
    }

    function resetFilter(){
        search = "";
        page   = 1;
        filter = '',
        sort_by = "`id`:DESC" ;
        per_page = 10;
        getDataUsers();
    }

</script>

<div class="row mt-4 d-none page page-user">
   

    <div class="col-lg-4 col-sm-12 col-md-12 mb-lg-0 mb-4 sticky-lg-top">
        <div class="card p-4 mb-4">
            <label>Cari : </label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama / alamat..." aria-label="search" aria-describedby="basic-addon1">
            </div>

            <div class="mb-3">
                <label>Urutkan Berdasarkan:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { sort_by } on:change = { changeSortBy }>
                    <option value="`id`:DESC"> Data Terbaru </option>
                    <option value="`id`:ASC"> Data Terlama </option>
                    <option value="`updated_at`:DESC"> Terbaru Diupdate </option>
                    <option value="`updated_at`:ASC"> Terlama Diupdate </option>
                </select>
            </div>

            <div class = "mb-3">
                <label>Role:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { filter } on:change = { changeFilter }>
                    <option value=""> SEMUA </option>
                    <option value="`role`: = ADMIN">ADMIN</option>
                    <option value="`role`: = KARYAWAN">KARYAWAN</option>
                </select>
            </div>

            <div class = "mb-3">
                <label>Per Halaman:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { per_page } on:change = { changePerPage }>
                    <option value=10>10</option>
                    <option value=20>20</option>
                    <option value=50>50</option>
                    <option value=100>100</option>
                </select>
            </div>

            <div class="mb-3 mt-3 w-100">
                <button type="button" class="btn btn-raised btn-danger w-100" on:click = { resetFilter }>
                    <i class="icon fas fa-history text-white"></i> &nbsp; Reset Filter
                </button>
            </div>
        </div>

        <div class="card sticky p-4 mb-4">
            <InfoResult result_length={ users.length } count_all = { count_all } _class="mb-3" _label="Info Result :"></InfoResult>
            <Pagination data = { pagination } on:click = { changePage } _class="mb-3" _label="Navigation :"></Pagination>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 col-md-12 wrap-content ">
        <div class="card mb-4">
            <div class="col-12 d-flex justify-content-between p-4 pt-0 pb-2">
                <h3 class="mt-4 ms-0">Daftar User</h3>
                <button class="btn bg-gradient-info btn-round btn-icon text-white mt-4 ms-4" data-bs-toggle="modal"
                data-bs-target="#modal-add-user">
                    <i class="icon fas fa-plus"></i>
                </button>
            </div>
            

            <div class="card-body row">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                    align="center" width ="10%">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Username</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                    align="center">Role</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                    align="center">Di buat</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            { #each users as user, i }
                            <tr>
                                <td align="left" width ="10%">{( offset + 1 ) + i }</td>
                                <td align="left">{ user.name }</td>
                                <td align="left">{ user.username }</td>
                                <td align="center" class="text-white { getBGByRole( user.role ) }">{ user.role}</td>
                                <td align="center">{ convertToDate(user.created_at, "DD MMM YYYY") }</td>
                                <td align="right">
                                    <button class="btn btn-danger btn-icon btn-round me-2" on:click={ ()=>{ deleteUser( user.id, user.name ) } } >
                                        <i class="icon fas fa-trash text-white"></i>
                                    </button>
                                    <button class="btn btn-primary btn-icon btn-round me-2" on:click={ () => { changeDataSelectedPwd( { role_access : role_access ,user_id : user.id, name : user.name }) } } data-bs-target="#modal-update-pwd-user" data-bs-toggle="modal">
                                        <i class="icon fas fa-key text-white"></i>
                                    </button>
                                    <button class="btn btn-warning btn-icon btn-round " on:click={ () => { changeDataSelected( { name : user.name, role : user.role, user_id : user.id }) } } data-bs-target="#modal-update-user" data-bs-toggle="modal">
                                        <i class="icon fas fa-edit text-white"></i>
                                    </button>
                                </td>
                            </tr>
                            { :else }
                            <td colspan=6>
                                <div class="alert alert-danger text-white m-0">Data Tidak Di temukan</div>
                            </td>
                            {/each}

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
    
</div>


<ModalAdd on:success={  starter }></ModalAdd>
<ModalUpdate data_selected = { data_selected } on:success={ starter }></ModalUpdate>
<ModalUpdatePwd data_selected = { data_selected } on:success={ starter }></ModalUpdatePwd>