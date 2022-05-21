<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { convertToDate } from '../../lib/handle-moment';

    let search;
    let users = [];
    starter();

    $:if( search || ! search ){
        getDataUsers();
    }

    function starter(){
        getDataUsers();
    }

    function getDataUsers(){
        let Request = new Rest();
        let data = {};

        if( search ){
            data = { "search" : search }
        }

        let request = Request.getUsers( data );

        request.then( ( res )=>{
            let body = res.getBody();
            users = body.data;
        });
    }
</script>

<div class="row mt-4 d-none page page-user">
    <div class="col-12 d-flex justify-content-end p-4">
        <button class="btn btn-primary btn-round btn-icon text-white" data-bs-toggle="modal"
        data-bs-target="#modal-add-user">
            <i class="icon fas fa-plus"></i>
        </button>
    </div>

    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-4">
        <div class="card h-100 p-4">
            <div>
                <label>Cari : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama / alamat..." aria-label="search" aria-describedby="basic-addon1">
              </div>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 wrap-content ">
        { #each users as user }
            <div class="card p-4">
                <div class="card-title text-bold border-bottom p-4">
                    { user.name }
                </div>
                <div class="card-body row">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align="center">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" align="center">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align="center">Role</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align="center">Di buat</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                { #each users as user, i }
                                    <tr>
                                        <td align="right">{ i + 1 }</td>
                                        <td align="left">{ user.name }</td>
                                        <td align="center">{ user.role}</td>
                                        <td align="center">{ convertToDate(user.created_at, "DD MMM YYYY") }</td>
                                        <td>
                                            <button class="btn btn-warning btn-icon btn-round me-2">
                                                <i class="icon fas fa-edit text-white"></i>
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-round">
                                                <i class="icon fas fa-trash text-white"></i>
                                            </button>
                                        </td>
                                    </tr>
                                { :else }   
                                    <div class="card">
                                        <div class="alert alert-danger text-white">Data Tidak Di temukan</div>
                                    </div>
                                {/each}
                               
                            </tbody>
                        </table>
                    </div>
                </div>
               
            </div>
        { :else }
            <div class="card p-4">
                <div class="alert alert-danger text-white"><i class="icon fas fa-warning"></i> Data tidak di temukan</div>
            </div>
        { /each }
        
    </div>
    
</div>


