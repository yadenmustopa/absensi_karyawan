<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { convertToDate } from '../../lib/handle-moment';
    import ModalAdd from '../modal/add_jabatan';
    import ModalUpdate from '../modal/update_jabatan.svelte';
    import { confirm, alertToast } from '../../lib/alert';
    import preloader from '../../lib/preloader';
    import Pagination from '../component/pagination.svelte';
    import InfoResult from '../component/info_result.svelte';
    // import { createEventDispatcher } from 'svelte';

    // const dispatch     = createEventDispatcher();

    let search;
    let jabatans = [];
    let per_page = "10";
    let page     = 1;
    let data_selected;
    let pagination;
    let offset;
    let count_all;
    let sort_by = "`id`:DESC";
    starter();

    $:if( search || ! search ){
        getDatajabatans();
    }

    // $:if( restart ){
    //     toggleRestart();
    // }

    function starter(){
        getDatajabatans();
    }


    // function toggleRestart(){
    //     starter();
    // }

    function getDatajabatans(){
        let Request = new Rest();
        let data = { page, per_page };

        if( search ){
            Object.assign( data, { search });
        }

        let request = Request.getJabatans( data );

        request.then( ( res )=>{
            let body    = res.getBody();
            jabatans    = body.data;
            pagination  = body.pagination;
            offset      = pagination.offset;
            count_all   = pagination.count_all;
        });
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
     * @param { Object } data
     * @param { String } data.name
     * @param { String } data.jabatan_id
     * @param { String } data.role
     * 
     */
    function changeDataSelected( data ){
        data_selected = data 
    }

    /**
     * 
     * @param { Number } id
     * @param { Name }name
     */
    function deletejabatan( id = 0, name = "" ){
        let oke_delete = confirm("Yakin Mau Hapus Akun ", "Hapus");

        oke_delete.then(( res )=>{
            preloader.show();

            let Request = new Rest();
            let request = Request.deleteJabatans( id );

            request.then( () => { 
                preloader.hide();
                alertToast("Berhasil", "data berhasil di hapus", "success" , "top-end", 3000 );
                starter();
            })
        });
    }

    /**
     * 
     * @param { Object } e
     */
    function changePage( e ){
        let page_to = e.detail.page_to;
        page        = page_to;
        getDatajabatans();
    }

    
    function resetFilter(){
        search = "";
        page   = 1;
        filter = '',
        sort_by = "`id`:DESC" ;
        per_page = 10;
        getJabatans();
    }

        /**
     * 
     * @param { Object } e
     */
     function changePerPage( e ){
        per_page =  e.target.value;
        getJabatans();
    }



</script>

<div class="row mt-4 d-none page page-jabatan">
    <div class="col-lg-4 col-sm-12 col-md-12 mb-lg-0 mb-4">
        <div class="card p-4">
            <div>
                <label>Cari : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama Jabatan/Bagian..." aria-label="search" aria-describedby="basic-addon1">
            </div>
            
            <div class="mb-3">
                <label>Urutkan Berdasarkan:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { sort_by } on:change = { changeSortBy }>
                    <option value="`id`:DESC"> Data Terbaru </option>
                    <option value="`id`:ASC"> Data Terlama </option>
                    <option value="`updated_at`:DESC"> Terbaru Diupdate </option>
                    <option value="`updated_at`:ASC"> Terlama Diupdate </option>
                    <option value="`name`:ASC"> Urutkan Nama </option>
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

        <div class="card p-4">
            <InfoResult result_length = { jabatans.length } count_all = { count_all } _class="mb-3" _label="Info Result"></InfoResult> 
            <Pagination data={ pagination } on:click = { changePage } _class ="mb-3" _label="Navigation :"></Pagination>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 col-md-12 wrap-content ">
        <div class="card mb-4">
            <div class="col-12 d-flex justify-content-between p-4 pt-0 pb-2">
                <h3 class="mt-4 ms-0">Daftar List Jabatan</h3>
                <div class="btn-title d-flex align-items-center mt-4">
                    <button class="btn bg-gradient-info btn-round btn-icon text-white" data-bs-toggle="modal" data-bs-target="#modal-add-jabatan">
                        <i class="icon fas fa-plus"></i>
                    </button>
                </div>
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
                                    align="center">description</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            { #each jabatans as jabatan, i }
                            <tr>
                                <td align="left" width ="10%">{ i + ( offset + 1) }</td>
                                <td align="center">{ jabatan.name }</td>
                                <td align="left">{ jabatan.description }</td>
                                <td align="right">
                                    <button class="btn btn-danger btn-icon btn-round me-2" on:click={ ()=>{ deletejabatan( jabatan.id, jabatan.name ) } } >
                                        <i class="icon fas fa-trash text-white"></i>
                                    </button>
                                    <button class="btn btn-warning btn-icon btn-round me-2" on:click={ () => { changeDataSelected( { name : jabatan.name, id : jabatan.id, description:jabatan.description  }) } } data-bs-target="#modal-update-jabatan" data-bs-toggle="modal">
                                        <i class="icon fas fa-edit text-white"></i>
                                    </button>
                                </td>
                               
                            </tr>
                            { :else }   
                            <td colspan=4>
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