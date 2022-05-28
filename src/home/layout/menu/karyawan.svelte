<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { formatIDR } from '../../lib/handler_number';
    import { restart }  from '../../store/toggle_restart';
    import ModalUpdate from '../modal/update_karyawan.svelte';
    import ModalHistory from '../modal/history_absensi.svelte';
    import ModalChangePhoto  from '../modal/change_photo.svelte';
    import Pagination from '../component/pagination.svelte';
    import InfoResult from '../component/info_result.svelte';
   

    let search;
    let users = [];
    let data_selected;
    let data_selected_photo;
    let pagination;
    let filter;
    let page         = 1;
    let per_page     = "10";
    let count_all    = 0;
    let sort_by      = "`users`.`id`:DESC";

    restart.subscribe( ( start )=> {
        console.log( { start });
        if( start ){
            "oke starter";
            starter();
        }
    });

    starter();

    $:if( search || ! search ){
        getDataUsers();
    }

    // $:if( starter ){
    //     toggleRestart();
    // }

    function starter()
    {
        getDataUsers();
    }

    // function toggleRestart()
    // {
    //     starter();
    // }

    function getDataUsers()
    {

        let Request = new Rest();
        let data = {  "with_identity" : "Y", page, per_page, filter, sort_by };

        if( search ){
            data.search = search;
        }

        let request = Request.getUsers( data );

        request.then( ( res )=>{
            let body   = res.getBody();
            users      = body.data;
            pagination = body.pagination;
            count_all  = pagination.count_all;
        });
    }

    /**
     * 
     * @param { Object } data
     */
    function changeDataSelected( data )
    {
        data_selected = data;
    }

    /**
     * 
     * @param { Number } karyawan_id
     * @param { String } name
     * @param { String }path
     */
    function changeSelectedPhoto( karyawan_id = 0, name = "", path = "" )
    {
        data_selected_photo = { karyawan_id, path, name  }
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
        sort_by = "`users`.`id`:DESC" ;
        per_page = "10";
        getDataUsers();
    }


</script>
<div class="row mt-4 d-none page page-karyawan">
    <!-- <div class="col-12 d-flex justify-content-end p-lg-4 p-sm-0">
        <button class="btn btn-primary bg-gradient-info btn-round btn-icon text-white">
            <i class="icon fas fa-plus"></i>
        </button>
    </div> -->

    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-4 p-0 pe-lg-4 sticky-top sticky-lg-top">
        <div class="card p-4 mb-4">
            <div>
                <label>Cari : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama / alamat..." aria-label="search" aria-describedby="basic-addon1">
            </div>

            
            <div class="mb-3">
                <label>Urutkan Berdasarkan:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { sort_by } on:change = { changeSortBy }>
                    <option value="`users`.`id`:DESC"> Data Terbaru </option>
                    <option value="`users`.`id`:ASC"> Data Terlama </option>
                    <option value="`users`.`name`:ASC"> Berdasarkan Nama</option>
                    <option value="`karyawans`.`updated_at`:DESC"> Terbaru Diupdate </option>
                    <option value="`karyawans`.`updated_at`:ASC"> Terlama Diupdate </option>
                </select>
            </div>

            <div class = "mb-3">
                <label>Filter:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { filter } on:change = { changeFilter }>
                    <option value=""> SEMUA </option>
                    <option value="`karyawans`.`address`: IS NOT NULL;`karyawans`.`no_hp`: IS NOT NULL;`karyawans`.`salary`: IS NOT NULL">SUDAH DI SETTING</option>
                    <option value="`karyawans`.`address`: IS NULL;`karyawans`.`no_hp`: IS NULL;`karyawans`.`salary`: IS NULL">BELUM DI SETTING</option>
                </select>
            </div>

            <div class = "mb-3">
                <label>Per Halaman:</label>
                <select class="form-select" aria-label="select" bind:value= { per_page } on:change = { changePerPage }>
                    <option value=10 >10</option>
                    <option value=20 >20</option>
                    <option value=50 >50</option>
                    <option value=100 >100</option>
                </select>
            </div>
            
            <div class="mb-3 mt-3 w-100">
                <button type="button" class="btn btn-raised btn-danger w-100" on:click = { resetFilter }>
                    <i class="icon fas fa-history text-white"></i> &nbsp; Reset Filter
                </button>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <InfoResult result_length = { users.length } count_all={ count_all } _label ="Info Result : "></InfoResult>
            <Pagination data = { pagination } on:click={ changePage } _class="mt-4" _label="Navigation : "></Pagination>
        </div>
            
    </div>


    <div class="col-lg-8  col-sm-12  col-md-12 wrap-content">
        { #each users as user }
            <div class="card p-4 border-1 mb-4 { ( !user.address || !user.no_hp || !user.salary || ! user.position  ) ? 'bg-gradient-danger' : '' }">
                <div class="d-flex justify-content-between">
                    <h3 class="">{ user.name }</h3>
                    <div>
                        <button 
                            class            = "btn btn-round btn-icon bg-gradient-warning text-white"
                            data-bs-toggle   = "modal" 
                            data-bs-target   = "#modal-history-absen" 
                            on:click         = { () => changeDataSelected( { address: user.address, position : user.position, no_hp : user.no_hp, salary : user.salary, karyawan_id : user.karyawan_id, name : user.name, user_id : user.user_id  }) } 
                        >
                            <i class="icon fas fa-address-book"></i>
                        </button>
                        <button 
                            class            = "btn btn-round btn-icon bg-gradient-info text-white" 
                            data-bs-toggle   = "modal" 
                            data-bs-target   = "#modal-update-karyawan" 
                            on:click         = { () => changeDataSelected( { address: user.address, position : user.position, no_hp : user.no_hp, salary : user.salary, karyawan_id : user.karyawan_id, name : user.name, user_id : user.user_id  }) } 
                        >
                            <i class="icon fas fa-edit"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-lg-3 col-sm-12 col-md-4  wrap-image">
                        <div class="d-flex justify-content-lg-end justify-content-sm-center justify-content-md-end">
                            <div class="list-wrap-image">
                                <img src={ window.config.base_url + '/' + user.photo } alt={ "photo-" + user.name }>
                            </div>
                            
                            <div class="wrap-update-photo">
                                <button type="button" class="btn btn-round btn-icon bg-gradient-dark text-white" data-bs-toggle="modal" data-bs-target="#modal-change-photo" on:click={ changeSelectedPhoto( user.karyawan_id,user.name, user.photo  ) }>
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-12 col-md-8 wrap info p-2 f-flex justify-content-lg-start justify-content-center justify-content-sm-center justify-content-md-start">
                        <table>
                            <tr class={ ( user.address && user.no_hp && user.salary && user.position  ) ? '' : 'text-white' }>
                                <td>Alamat</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td>{ ( user.address ) ? user.address : 'belum di setting' }</td>                        
                            </tr>
                            <tr class={ ( user.address && user.no_hp && user.salary && user.position  ) ? '' : 'text-white' }>
                                <td>No Hp</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td>{ ( user.no_hp ) ? user.no_hp : 'belum di setting' }</td>                        
                            </tr>
                            <tr class={ ( user.address && user.no_hp && user.salary && user.position  ) ? '' : 'text-white' }>
                                <td>Jabatan/Bag : </td>
                                <td>&nbsp; : &nbsp;</td>
                                <td>{ ( user.position ) ? user.position : 'belum di setting' }</td>                        
                            </tr>
                            <tr class={ ( user.address && user.no_hp && user.salary && user.position  ) ? '' : 'text-white' }>
                                <td>Gaji</td>
                                <td>&nbsp; : &nbsp; </td>
                                <td>Rp.{ formatIDR( user.salary ) }</td>                        
                            </tr>
                        </table>
                    </div>
                </div>
            
            </div>
        { :else }
            <div class="card p-4">
                <div class="alert alert-danger text-white m-0"><i class="icon fas fa-warning"></i> Data tidak di temukan</div>
            </div>
        { /each }

        
    </div>
    
</div>

<ModalUpdate data_selected = { data_selected } on:success = { starter }></ModalUpdate>
<ModalHistory data_selected = { data_selected }></ModalHistory>
<ModalChangePhoto data_selected_photo = { data_selected_photo } on:success = { starter }></ModalChangePhoto>