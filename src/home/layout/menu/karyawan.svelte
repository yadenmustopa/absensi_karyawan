<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { formatIDR } from '../../lib/handler_number';
    import { restart }  from '../../store/toggle_restart';

    let search;
    let users = [];

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

    function toggleRestart()
    {
        starter();
    }

    function getDataUsers()
    {
        let Request = new Rest();
        let data = {  "with_identity" : "Y" };

        if( search ){
            data.search = search;
        }

        let request = Request.getUsers( data );

        request.then( ( res )=>{
            let body = res.getBody();
            users = body.data;

            console.log({ users });
        });
    }
</script>
<div class="row mt-4 d-none page page-karyawan">
    <!-- <div class="col-12 d-flex justify-content-end p-lg-4 p-sm-0">
        <button class="btn btn-primary bg-gradient-info btn-round btn-icon text-white">
            <i class="icon fas fa-plus"></i>
        </button>
    </div> -->

    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-4 p-0 pe-lg-4">
        <div class="card p-4 ">
            <div>
                <label>Cari : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama / alamat..." aria-label="search" aria-describedby="basic-addon1">
              </div>
        </div>
    </div>

    <div class="col-lg-8  col-sm-12 wrap-content">
            { #each users as user }
                <div class="card p-4 border-1 mb-4 { ( ! user.address || ! user.no_hp || ! user.salary  ) ? 'bg-gradient-danger' : '' }">
                    <div class="d-flex justify-content-between">
                        <h3 class="">{ user.name }</h3>
                        <div>
                            <button class="btn btn-round btn-icon bg-gradient-warning text-white">
                                <i class="icon fas fa-address-book"></i>
                            </button>
                            <button class="btn btn-round btn-icon bg-gradient-info text-white">
                                <i class="icon fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-3 col-sm-12  wrap-image">
                            <div class="d-flex justify-content-center">
                                <img src={ window.config.base_url + '/' + user.photo } alt={ "photo-" + user.name }>
                                <div class="wrap-update-photo">
                                    <button type="button" class="btn btn-round btn-icon bg-gradient-dark text-white">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 wrap info p-2">
                            <table>
                                <tr class={ ( user.address && user.no_hp && user.salary  ) ? '' : 'text-white' }>
                                    <td>Alamat</td>
                                    <td>&nbsp; : &nbsp;</td>
                                    <td>{ ( user.address ) ? user.adress : 'belum di setting' }</td>                        
                                </tr>
                                <tr class={ ( user.address && user.no_hp && user.salary  ) ? '' : 'text-white' }>
                                    <td>No Hp</td>
                                    <td>&nbsp; : &nbsp;</td>
                                    <td>{ ( user.no_hp ) ? user.no_hp : 'belum di setting' }</td>                        
                                </tr>
                                <tr class={ ( user.address && user.no_hp && user.salary  ) ? '' : 'text-white' }>
                                    <td>Jabatan/Bag : </td>
                                    <td>&nbsp; : &nbsp;</td>
                                    <td>{ ( user.position ) ? user.position : 'belum di setting' }</td>                        
                                </tr>
                                <tr class={ ( user.address && user.no_hp && user.salary  ) ? '' : 'text-white' }>
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