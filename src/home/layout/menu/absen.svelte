<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { convertToDate } from '../../lib/handle-moment';
    import ModalAdd from '../modal/add_user';
    import ModalUpdate from '../modal/update_user.svelte';
    import ModalUpdatePwd from '../modal/update_password.svelte';
    import { confirm, alertToast } from '../../lib/alert';
    import preloader from '../../lib/preloader';
    // import { createEventDispatcher } from 'svelte';

    // const dispatch     = createEventDispatcher();

    let search;
    let users = [];
    let data_selected;
    let role_access;

    starter();

    $:if( search || ! search ){
        console.log( { search });
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
        let data = {};

        if( search ){
            data = { "search" : search }
        }

        let request = Request.getUsers( data );

        request.then( ( res )=>{
            let body = res.getBody();
            users    = body.data;
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
            <h2 class="mt-4 ms-4">Daftar Karyawan Belum Absen</h2>

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
                            </tr>
                        </thead>
                        <tbody>
                            { #each users as user, i }
                            <tr>
                                <td align="left" width ="10%">{ i + 1 }</td>
                                <td align="left">{ user.name }</td>
                                <td align="center">{ user.position }</td>
                            </tr>
                            { :else }
                            <div class="card">
                                <div class="alert alert-danger text-white m-0">Data Tidak Di temukan</div>
                            </div>
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