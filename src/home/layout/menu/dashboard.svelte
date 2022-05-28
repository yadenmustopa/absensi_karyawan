<script>
    //TODO Dashboard
    "use strict";
    import Rest from '../../modul/Request';
    import { getToday, stringDateToFormat } from '../../lib/handle-moment';

    export let data_user;

    let search;
    let count_all_karyawan;
    let users      = [];
    let start_date;
    let end_date;
    let role_access;

    $:if( data_user ){
        console.log({ data_user });
    }

    starter();

    function starter(){
        defaultRangeDate();
        getCountAllKaryawan();
    }

    function defaultRangeDate(){
     
    }

    function getCountAllKaryawan(){
        let Request = new Rest();

        let request = Request.getKaryawan();

        request.then( ( res )=>{
            let body = res.getBody();
            count_all_karyawan = body.count_all_result;

            console.log( { body, count_all_karyawan });
        });
    }

    function getNotAbsened(){
        let Request = new Rest();

        start = stringDateToFormat( start_date + ' 00:00:00' );
        end   = stringDateToFormat( end_date + ' 23:59:59' );
        let data    = { has_absen : "N", start_date : start, end_date : end }
        let request = Request.getAbsens( data );
        

        request.then( ( res )=>{
            let body = res.getBody();
            // count_all_karyawan = body.count_all_result;
            console.log( { body });
        });
    }



</script>

<div class="row mt-0 d-none page page-dashboard">
    
    <div class="col-lg-4 col-sm-12 mb-lg-3 mb-12 ">
        <div class="card p-3">
            
        </div>
    </div>
    
</div>