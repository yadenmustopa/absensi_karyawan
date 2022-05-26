<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { getToday, stringDateToFormat } from '../../lib/handle-moment';

    let search;
    let count_all_karyawan;
    let users      = [];
    let start_date = getToday('YYYY-MM-DD');
    let end_date   = getToday('YYYY-MM-DD');
    starter();

    function starter(){
        defaultRangeDate();
        getCountAllKaryawan();
    }

    function defaultRangeDate(){
        start_date = stringDateToFormat( start_date + ' 00:00:00' );
        end_date   = stringDateToFormat( start_date + ' 00:00:00' );
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
        let data    = { has_absen : "N", start_date, end_date }
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