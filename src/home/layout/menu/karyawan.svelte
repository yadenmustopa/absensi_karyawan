<script>
    "use strict";
    import Rest from '../../modul/Request';

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
    <div class="col-12 d-flex justify-content-end p-4">
        <button class="btn btn-primary btn-round btn-icon text-white">
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
                    <div class="col-lg-4 col-sm-12  wrap-image">
                        
                        <img src={ window.config.base_url + '/' + user.photo } alt={ "photo-" + user.name }>
                    </div>
                    <div class="col-lg-8 col-sm-12 wrap info p-2">
                        <div>{ user.address }</div>                        
                        <div>{ user.no_hp }</div>                        
                        <div>{ user.salary }</div>                        
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