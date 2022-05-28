<script>
    "use strict";
    import Request from '../../modul/Request';
    import daterangepicker from 'daterangepicker';
    import param_date_picker from '../../settings/param_date_picker';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher, onMount } from 'svelte';
    // import window.jquery from 'window.jquery';
    import DateRangeSelect from 'svelte-date-range-select';
    import { getToday, convertToDate, stringDateToFormat, getFirstOfMonth } from '../../lib/handle-moment';
    import getColorBgStatus from '../../lib/bg_status_absen';
    import Pagination from '../component/pagination.svelte';
    import InfoResult from '../component/info_result.svelte';

    export let user_id;

    let start_date;
    let end_date;
    let role_access;
    let datas = [];
    let page =  1;
    let per_page = "10";
    let offset   = 0;
    let count_all = 0;
    let sort_by = "`absens`.`created_at`:DESC";
    let filter;
    let pagination;

    $:if( user_id ){
        getHistoryById();
    }

    getRoleAccess();

    function getRoleAccess(){
        let data_user = JSON.parse( localStorage.getItem('ak-data-user'));
        role_access   = data_user.role;

        console.log( 'ngaran role accesna '+ role_access );
    }

    defaultRangeDate();
    starter();

    function starter(){
        getHistoryById();
    }

    onMount( () => {
        instanceDatePicker();
    })

        //instanse date range picker
    function instanceDatePicker()
    {
        window.window.jquery('#datepicker-data-history').daterangepicker( param_date_picker, function(start, end, label) {
            changeDate( start, end );
            // console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + label );
        });

        if( role_access === "KARYAWAN" ){
            setDefaultDatePicker( getFirstOfMonth('DD-MM-YYYY') );
        }
    }

       /**
     * 
     * @param start
     * @param end
     */
     function changeDate( start, end ){
        start_date = start.format("YYYY-MM-DD");
        end_date   = end.format("YYYY-MM-DD");

        starter();
    }

    function getHistoryById()
    {
        preloader.show();

        let Rest     = new Request();
        let start    = stringDateToFormat( start_date + ' 00:00:00')/1000; 
        let end      = stringDateToFormat( end_date + ' 23:59:59')/1000;
        
        console.log({ start, end, filter });

        let data     = { start_date : start , end_date : end, sort_by, filter,  page, per_page }
        let request  = Rest.getAbsenById( user_id, data );

        request.then( ( res ) => {
            let body   = res.getBody();
            console.log({ body });

            datas      = body.data;
            pagination = body.pagination;
            count_all  = pagination.count_all;
            offset     = pagination.offset;

            preloader.hide();
        });

    }

    /**
     * 
     * @param { Sting }start date format DD-MM-YYYY
     * @param { String }end date format DD-MM-YYYY
     */
    function setDefaultDatePicker( start , end )
    {
        if( !end ){
            end = getToday('DD-MM-YYYY')
        }

        if( !start ){
            start = getToday('DD-MM-YYYY')
        }

        window.jquery('#datepicker-data-istory').data('daterangepicker').setStartDate( start );
        window.jquery('#datepicker-data-istory').data('daterangepicker').setEndDate( end );
    }


    
    function defaultRangeDate(){
        console.log({ role_access });
        if( role_access === "ADMIN"){
            start_date = getToday('YYYY-MM-DD');
        }else{
            start_date = getFirstOfMonth('YYYY-MM-DD');
        }
        end_date   = getToday('YYYY-MM-DD');
    }

         /**
     * 
     * @param { Object } e
     */
     function changePage( e ){
        let page_to   = e.detail.page_to;
        page = page_to;
        getHistoryById();
    }

        /**
     * 
     * @param { Object } e
     */
     function changePerPage( e ){
        per_page =  e.target.value;
        getHistoryById();
    }

    /**
     * 
     * @param { Object } e
     */
     function changeFilter( e ){
        filter = e.target.value;
        getHistoryById();
    }

    function resetFilter(){
        page   = 1;
        filter = '',
        sort_by = "`id`:DESC" ;
        per_page = "10";
        defaultRangeDate();
        getHistoryById();
    }


    
</script>

<div class="row p-4">
    <div class="col-lg-4 col-md-12 col-sm-4">
        <div class="d-block mb-3">
            <label>Pilih Tanggal :</label><br/>
            <div class="input-group">
                <span class="input-group-text"><i class="icon fas fa-calendar"></i></span>
                <input type="text" class="form-control w-100"  id="datepicker-data-history" />
            </div>

            <div class = "mb-3">
                <label>Per Halaman:</label>
                <select class="form-select" aria-label="select" bind:value= { per_page } on:change = { changePerPage }>
                    <option value=10>10</option>
                    <option value=20>20</option>
                    <option value=50>50</option>
                    <option value=100>100</option>
                </select>
            </div>

            <div class = "mb-3">
                <label>Filter Absen:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { filter } on:change = { changeFilter }>
                    <option value=""> SEMUA </option>
                    <option value="`status`:='MASUK'"> MASUK </option>
                    <option value="`status`:='IZIN'"> IZIN </option>
                    <option value="`status`:='CUTI'"> CUTI </option>
                    <option value="`status`:='TANPA_KETERANGAN'"> TANPA KETERANGAN </option>
                </select>
            </div>

            <div class="mb-3 mt-3 w-100">
                <button type="button" class="btn btn-raised btn-danger w-100" on:click = { resetFilter }>
                    <i class="icon fas fa-history text-white"></i> &nbsp; Reset Filter
                </button>
            </div>
        </div>

        <div class="card p-4">
            <InfoResult result_length = { datas.length } count_all={ count_all } _class="" _label="Info Result :"></InfoResult>
            <Pagination data = { pagination } on:click={ changePage }></Pagination>
        </div>

    </div>

    <div class="col-lg-8 col-md-12 col-sm-8">
        <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                    align="center" width ="10%">No</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                    align="center">Tanggal</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                    align="center">Status</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                    align="center">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            { #each datas as absen, i }
            <tr>
                <td align="left" width ="10%">{ i + ( offset + 1 ) }</td>
                <td align="left">{ convertToDate( absen.created_at, 'DD MMM YYYY - H:m:s' )  }</td>
                <td align="left" class="text-center { getColorBgStatus( absen.status ) }">{ absen.status }</td>
                <td align="center">{ absen.description ?? '...' }</td>
            </tr>
            { :else }
            <td colspan=4>
                <div class="alert alert-danger text-white m-0">Tidak Ada History Absen</div>
            </td>
            {/each}

        </tbody>
    </table>
    </div>
</div>
