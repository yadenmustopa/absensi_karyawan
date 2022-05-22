<script>
    "use strict";
    import Rest from '../../modul/Request';

    let search;
    let users = [];
    starter();

    function starter(){
        getDataAbsens();
    }

    function getDataAbsens(){

    }
</script>

<div class="row mt-0 d-none page page-dashboard">
    
    <div class="col-lg-4 col-sm-12 mb-lg-0 mb-4 ">
        <div class="card p-3">
            <div>
                <label>Cari : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Cari Nama / alamat..." aria-label="search" aria-describedby="basic-addon1">
              </div>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12 wrap-content">
        <div class="card card-background-mask-info">
            { #each users as user }
                
            { /each }
        </div>
    </div>
    
</div>