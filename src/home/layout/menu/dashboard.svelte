<script>
    //TODO Dashboard
    "use strict";
    import Rest from '../../modul/Request';
    import { getToday, stringDateToFormat, getFirstOfMonth } from '../../lib/handle-moment';
    import { restart }  from '../../store/toggle_restart';
    import HistoryAbsen from '../component/data_history.svelte';

    export let data_user;

    let search;
    let count_all_karyawan;
    let count_no_absen           = 0;
    // let count_has_absen          = 0;
    let count_hadir              = 0;
    let count_izin               = 0;
    let count_cuti               = 0;
    let count_tanpa_keterangan   = 0;
    let users                    = [];
    let start_date;
    let end_date;
    let role_access;
    let user_id;

    restart.subscribe( ( start )=> {
        console.log( { start });
        if( start ){
            starter();
        }
    });

    $:if( data_user ){
        assignToData();
        starter();
    }

    function starter(){
        defaultRangeDate();
        getCountAllKaryawan();
        if( role_access === "ADMIN" ){
            getAbsen("N");
            getAbsen("Y", "`absens`.`status`: = 'MASUK'", "MASUK");
            getAbsen("Y", "`absens`.`status`: = 'CUTI'", "CUTI");
            getAbsen("Y", "`absens`.`status`: = 'IZIN'", "IZIN");
            getAbsen("Y", "`absens`.`status`: = 'TANPA_KETERANGAN'", "TANPA_KETERANGAN");
        }else{
            getHistoryById("`status`: = 'MASUK'", "MASUK");
            getHistoryById("`status`: = 'CUTI'", "CUTI");
            getHistoryById("`status`: = 'IZIN'", "IZIN");
            getHistoryById("`status`: = 'TANPA_KETERANGAN'", "TANPA_KETERANGAN");
        }
    }


    function assignToData()
    {
        role_access = data_user.role;
        user_id     = data_user.id;
        console.log("ieu user idna "+ user_id );
    }

    function defaultRangeDate(){
        if( role_access === "ADMIN"){
            start_date = getToday('YYYY-MM-DD');
        }else{
            start_date = getFirstOfMonth('YYYY-MM-DD');
        }
        end_date   = getToday('YYYY-MM-DD');
    }

    function getCountAllKaryawan(){
        let Request = new Rest();

        let request = Request.getKaryawan();

        request.then( ( res )=>{
            let body = res.getBody();
            count_all_karyawan = body.count_all;

            console.log( { body, count_all_karyawan });
        });
    }

    /**
     * 
     * @param { String } has_absen
     * @param { String } filter filter if condition for has_absen === Y
     * @param { String } status filter if condition for has_absen === Y
     */
    function getAbsen( has_absen = "Y", filter, status = "MASUK" ){
        let Request = new Rest();

        let start = stringDateToFormat( start_date + ' 00:00:00' ) / 1000;
        let end   = stringDateToFormat( end_date + ' 23:59:59' ) / 1000;
        let data    = { has_absen : has_absen, start_date : start, end_date : end, filter  }
        let request = Request.getAbsens( data );
        

        request.then( ( res )=>{
            let body = res.getBody();
            if( has_absen === "Y"){
                // count_has_absen = body.pagination.count_all;
                // assignToCount( status, count_has_absen  );

            }else{
                count_no_absen  = body.pagination.count_all;
            }
            console.log( { body });
        });
    }

    /**
     * 
     * @param { String }filter
     * @param { Status } status
     */
    function getHistoryById( filter, status = "MASUK" )
    {

        let Request     = new Rest();
        let start    = stringDateToFormat( start_date + ' 00:00:00')/1000; 
        let end      = stringDateToFormat( end_date + ' 23:59:59')/1000;
        
        console.log({ start, end, filter });

        let data     = { start_date : start , end_date : end,  filter,}
        let request  = Request.getAbsenById( user_id, data );

        request.then( ( res ) => {
            let body        = res.getBody();
            let count_absen = body.pagination.count_all;
            assignToCount( status, count_absen  );
        });

    }

    /**
     * 
     * @param { "MASUK","CUTI","IZIN","TANPA_KETERANGAN"} status
     * @param { Number } count
     */
    function assignToCount( status, count )
    {
        console.log({ status , count });

        if( status === "MASUK"){
            count_hadir = count;
        }else if( status === "CUTI"){
            count_cuti = count;
        }else if( status === "IZIN"){
            count_izin = count;
        }else{
            count_tanpa_keterangan = count;
        }
    }



</script>

<div class="row mt-0 d-none page page-dashboard">
    
    { #if role_access === "ADMIN"}
        <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
            <div class="card p-3 d-flex justify-content-center text-center">
                <div class="fs-1">{ count_all_karyawan }</div>
                <div class=""> Jumlah Karyawan</div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
            <div class="card p-3 d-flex justify-content-center text-center">
                <div class="fs-1">{ count_no_absen }</div>
                <div class=""> Belum Di Absen</div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
            <div class="card p-3 d-flex justify-content-center text-center">
                <div class="fs-1">{ ( count_all_karyawan - count_no_absen  ) }</div>
                <div class=""> SUdah Di Absen</div>
            </div>
        </div>
    { /if }
        
    <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
        <div class="card p-3 d-flex justify-content-center text-center">
            <div class="fs-1">{ count_hadir }</div>
            <div class=""> Hadir</div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
        <div class="card p-3 d-flex justify-content-center text-center">
            <div class="fs-1">{ count_cuti }</div>
            <div class=""> Cuti</div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
        <div class="card p-3 d-flex justify-content-center text-center">
            <div class="fs-1">{ count_izin }</div>
            <div class=""> Izin </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-3 mb-lg-3 mb-12 col-xs-12 mb-sm-3">
        <div class="card p-3 d-flex justify-content-center text-center">
            <div class="fs-1">{ count_tanpa_keterangan }</div>
            <div class=""> TIdak Masuk </div>
        </div>
    </div>
    { #if role_access === "KARYAWAN"}
        <HistoryAbsen user_id = { user_id }></HistoryAbsen>
    { /if }
    
</div>