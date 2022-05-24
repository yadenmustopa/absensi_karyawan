<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { convertToDate } from '../../lib/handle-moment';
    import ModalAdd from '../modal/add_absen.svelte';
    import ModalUpdate from '../modal/update_absen.svelte';
    import { confirm, alertToast } from '../../lib/alert';
    import preloader from '../../lib/preloader';
    import { restart }  from '../../store/toggle_restart';
    // import { createEventDispatcher } from 'svelte';

    // const dispatch     = createEventDispatcher();

    let search;
    let users_has_absened = [];
    let users_no_absened = [];
    let data_selected_has_absen;
    let data_selected_no_absen;
    
    
    restart.subscribe( ( start )=> {
        console.log( { start });
        if( start ){
            "oke starter";
            starter();
        }
    });

    starter();

    $:if( search || ! search ){
        console.log( { search });
        getUserHasAbsened();
        getUserNoAbsened();
    }

    // $:if( restart ){
    //     toggleRestart();
    // }

    function starter(){
        console.log("absen starter");
        getUserHasAbsened();
        getUserNoAbsened();
        // getRoleAccess();
    }


    function getUserHasAbsened(){
        getAbsen("Y");
    }


    function getUserNoAbsened()
    {
        getAbsen("N");
    }


    /**
     * 
     * @param { "Y"|"N"} has_absen
     */
    function getAbsen( has_absen = "Y" )
    {
        let Request = new Rest();
        let data = { "has_absen" : has_absen };

        if( search ){
            data = { "search" : search }
        }

        let request = Request.getAbsense( data );

        request.then( ( res )=>{
            let body = res.getBody();

            if( has_absen === "Y" ){
                users_has_absened = body.data;
                console.log({ users_has_absened })
            }else{
                users_no_absened = body.data;
            }
        });
    }

    /**
     * 
     * @param absen_id
     * @param name
     * @param status
     * @param description
     */
    function changeSelectedHasAbsen( absen_id="", name="", status="", description="" ){
        data_selected_has_absen = { absen_id, name, status, description } 
    }


    /**
     * 
     * @param { Object } data
     * @param { String } data.name
     * @param { String } data.user_id
     * @param { String } data.role
     * 
     */
    function changeSelectedNoAbsen( data ){
        console.log({ data });
        data_selected_no_absen = data 
    }




</script>

<div class="row mt-4 d-none page page-absen">
    <div class="col-12 d-flex justify-content-end p-4 pt-0 pb-2">
    </div>

    <div class="col-lg-4 col-sm-12 col-md-12 mb-lg-0 mb-4">
        <div class="card p-4">
            <div>
                <label>Cari Nama Karyawan : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama" aria-label="search" aria-describedby="basic-addon1">
              </div>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 col-md-12 wrap-content ">
        <div class="card mb-4">
                <h3 class="mt-4 ms-4">:: Belum Absen ::</h3>
                <div class="d-flex justify-content-end pe-4">
                    <button class="btn btn-danger text-white">
                        <i class="icon fas fa-plus"></i> Semua Absen Tanpa Keterangan
                    </button>
                </div>

            <div class="card-body row">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7"
                                    align="center" width ="10%">No</th>
                                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Nama</th>
                                <th class="text-uppercase  text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Jabatan/Bag</th>
                             

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            { #each users_no_absened as user, i }
                                <tr>
                                    <td align="left" width ="10%">{ i + 1 }</td>
                                    <td align="left">{ user.name }</td>
                                    <td align="center">{ user.position }</td>
                                 
                                    <td align="right">
                                        <button 
                                            type   = "button" 
                                            class  = "btn  btn-icon bg-gradient-info" 
                                            data-bs-target = "#modal-add-absen" 
                                            data-bs-toggle ="modal" 
                                            on:click       = { ()=> { changeSelectedNoAbsen({ user_id : user.user_id, name : user.name }) } }    
                                        >
                                            <i class="fas fa-plus">Masukan Ke Absen</i>
                                        </button>
                                    </td>
                                </tr>
                            { :else }
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-danger text-white m-0">Data Tidak Di temukan</div>
                                    </td>
                                </tr>
                            {/each}

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
        <div class="card mb-4">
            <h3 class="mt-4 ms-4">:: Sudah Di Absen ::</h3>
    
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
                                    align="center">Jabatan/Bag</th>
                                <th class="text-uppercase  text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Status</th>
                                <th class="text-uppercase  text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            { #each users_has_absened as user, i }
                                <tr>
                                    <td align="left" width ="10%">{ i + 1 }</td>
                                    <td align="left">{ user.name }</td>
                                    <td align="center">{ user.position }</td>
                                    <td align="left">{ user.status }</td>
                                    <td align="center">{ (user.description) ? user.description : '...' }</td>
                                    <td align="right">
                                        <button 
                                            type  = "button" 
                                            class = "btn btn-icon bg-gradient-warning" 
                                            data-bs-target = "#modal-update-absen" 
                                            data-bs-toggle="modal" 
                                            on:click       = { ()=> { changeSelectedHasAbsen( user.absen_id, user.name, user.status, user.description ) } }     
                                        >
                                            <i class="fas fa-edit">Ubah data Absen</i>
                                        </button>
                                    </td>
                                </tr>
                            { :else }
                                <td colspan="4">
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


<ModalAdd on:success={ starter } data_selected = { data_selected_no_absen }></ModalAdd>
<ModalUpdate on:success={ starter } data_selected = { data_selected_has_absen } ></ModalUpdate>