<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { onMount } from 'svelte';
    import { convertToDate, getToday,stringDateToFormat } from '../../lib/handle-moment';
    import ModalAdd from '../modal/add_absen.svelte';
    import ModalUpdate from '../modal/update_absen.svelte';
    import { confirm, alertToast } from '../../lib/alert';
    import preloader from '../../lib/preloader';
    import { restart }  from '../../store/toggle_restart';
    import { isEmptyArr }     from '../../lib/handle_array';
    import DateRangeSelect    from 'svelte-date-range-select';
    import getColorBgStatus   from '../../lib/bg_status_absen';
    import PaginationNoAbsen  from '../component/pagination.svelte';
    import PaginationHasAbsen from '../component/pagination.svelte';
    import InfoResultHasAbsen from '../component/info_result.svelte';
    import InfoResultNoAbsen  from '../component/info_result.svelte';
    import daterangepicker    from 'daterangepicker';
    import param_date_picker  from '../../settings/param_date_picker';
    // import { createEventDispatcher } from 'svelte';

    // const dispatch     = createEventDispatcher();

    let search;
    let users_has_absened = [];
    let users_no_absened = [];
    let data_selected_has_absen;
    let data_selected_no_absen;
    let start_date;
    let end_date;
    let pagination_no_absen;
    let pagination_has_absen;

    let page_no_absen = 1;
    let page_has_absen = 1;
    let count_all_no_absen = 0;
    let count_all_has_absen = 0;
    let per_page = "10";
    let filter;
    let sort_by_has_absense = "`absens`.`id`:DESC";
    let sort_by_no_absense = "`users`.`name`:ASC";

    let offset_no_absen = 0;
    let offset_has_absen = 0;

    const labels = {
        notSet: 'not set',
        greaterThan: 'greater than',
        lessThan: 'less than',
        range: 'range',
        day: 'day',
        days: 'days',
        apply: 'ok'
    }

    
    
    restart.subscribe( ( start )=> {
        console.log( { start });
        if( start ){
            "oke starter";
            starter();
        }
    });

    defaultRangeDate();
    starter();

    $:if( search || ! search ){
        console.log( { search });
        getUserHasAbsened();
        getUserNoAbsened();
    }

    onMount( () => {
        instanceDatePicker();
    })

    // $:if( restart ){
    //     toggleRestart();
    // }
    function defaultRangeDate(){
        start_date = getToday('YYYY-MM-DD');
        end_date   = getToday('YYYY-MM-DD');

    }

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
        let Request  = new Rest();
        let start    = stringDateToFormat( start_date + ' 00:00:00')/1000; 
        let end      = stringDateToFormat( end_date + ' 23:59:59')/1000; 
        let data     = { "has_absen" : has_absen,"start_date" : start, "end_date" : end };

        if( has_absen === "Y"){
            data.page            = page_has_absen;
            data.filter          = filter;
            data.sort_by         = sort_by_has_absense;
        }else{
            data.page            = page_no_absen;
            data.sort_by         = sort_by_no_absense;
        }

        if( search ){
            Object.assign( data, { search })
        }

        let request = Request.getAbsens( data );

        request.then( ( res )=>{
            let body = res.getBody();

            if( has_absen === "Y" ){
                users_has_absened    = body.data;
                pagination_has_absen = body.pagination;
                count_all_has_absen  = pagination_has_absen.count_all;
                offset_has_absen     = pagination_has_absen.offset;
            }else{
                users_no_absened     = body.data;
                pagination_no_absen  = body.pagination;
                count_all_no_absen   = pagination_no_absen.count_all;
                offset_no_absen      = pagination_no_absen.offset;
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

    /**
     * 
     * @param { "MASUK", "TANPA_KETERANGAN"} status
     */
    function absenAllNotEntry(status){
        let yes = confirm( 'Yakin?', "Oke Absen Semua", status + ' semua' )

        yes.then( ()=>{
            let data = [];
            users_no_absened.forEach( ( item )=>{
                let user_id = item.user_id;
                let status  = status;
                data.push({ user_id, status });

                starter();
            });
            
            data = JSON.stringify( data );
            insertMultipleAbsen( status, data );
        });
    }


    function insertMultipleAbsen( status, data ){
        let Request = new Rest();
        data        ={ absens : data  };
        let request = Request.addAbsensMultiple( data );

        request.then( ( res )=>{
            alertToast( 'Berhasil','Berhasil mengabsen semua ke status '+ status );
        })
    }

    // function handleApplyDateRange(data){

    //     let value  = data.detail;
    //     start_date = value.startDate;
    //     end_date   = value.endDate;

    //     starter();
    // }

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

    function resetFilter(){
        search   = "";
        filter   = "";
        page     = 1;
        per_page = "10";
        sort_by_has_absense = "`absens`.`id`:DESC";
        sort_by_no_absense  = "`users`.`name`:ASC";

        setDefaultDatePicker();
        defaultRangeDate();
        starter();
    }


    function setDefaultDatePicker()
    {
        jquery('input[name="datetimes"]').data('daterangepicker').setStartDate( getToday('DD-MM-YYYY') );
        jquery('input[name="datetimes"]').data('daterangepicker').setEndDate( getToday('DD-MM-YYYY') );
    }

    /**
     * 
     * @param { Object } e event
     */
    function changeSortByNoAbsen( e ){
        let value = e.target.value;
        sort_by_no_absense = value;
        getUserNoAbsened();
    }

    /**
     * 
     * @param { Object } e event
     */
    function changeSortByHasAbsen( e ){
        let value = e.target.value;
        sort_by_has_absense = value;
        getUserHasAbsened();
    }

        /**
     * 
     * @param { Object } e
     */
     function changePageHasAbsen( e ){
        let page_to = e.detail.page_to;
        page_has_absen = page_to;
        getUserHasAbsened();
    }


        /**
     * 
     * @param { Object } e
     */
     function changePageNoAbsen( e ){
        let page_to   = e.detail.page_to;
        page_no_absen = page_to;
        getUserNoAbsened();
    }

        /**
     * 
     * @param { Object } e
     */
     function changePerPage( e ){
        per_page =  e.target.value;
        getUserNoAbsened();
        getUserHasAbsened();
    }



    //instanse date range picker
    function instanceDatePicker()
    {
        console.log({ param_date_picker });
        window.jquery('input[name="datetimes"]').daterangepicker( param_date_picker, function(start, end, label) {
            changeDate( start, end );
            // console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + label );
        });
    }


</script>

<div class="row mt-4 d-none page page-absen">

    <div class="col-lg-4 col-sm-12 col-md-12 mb-lg-0 mb-4 sticky-lg-top">
        <div class="card p-4">
            <h4>Filter</h4>

            <div class="mb-3">
                <label>Cari Nama Karyawan : </label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama" aria-label="search" aria-describedby="basic-addon1">
                </div>
            </div>

            <div class="d-block mb-3">
                <label>Pilih Tanggal :</label><br/>
                <div class="input-group">
                    <span class="input-group-text"><i class="icon fas fa-calendar"></i></span>
                    <input type="text" class="form-control w-100"  name="datetimes" />
                </div>
            </div>

            <div class = "mb-3">
                <label>Per Halaman:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { per_page } on:change = { changePerPage }>
                    <option value=10>10</option>
                    <option value=20>20</option>
                    <option value=50>50</option>
                    <option value=100>100</option>
                </select>
            </div>

        </div>
      
        <div class="card p-4 mt-4">
            <div class="mb-3">
                <label>Urutkan Berdasarkan:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { sort_by_no_absense } on:change = { changeSortByNoAbsen }>
                    <option value="`users`.`name`:ASC"> Urutan Nama </option>
                    <option value="`users`.`id`:DESC"> Data Terbaru </option>
                    <option value="`users`.`id`:ASC"> Data Terlama </option>
                    <option value="`users`.`updated_at`:DESC"> Terbaru Diupdate </option>
                    <option value="`users`.`updated_at`:ASC"> Terlama Diupdate </option>
                </select>
            </div>

            <InfoResultNoAbsen result_length={ users_no_absened.length } count_all={ count_all_no_absen } _class="mb-3" _label="Info Belum Absen"></InfoResultNoAbsen>
            <PaginationNoAbsen data = { pagination_has_absen } on:click = { changePageNoAbsen } _label="Navigation :"></PaginationNoAbsen>
        </div>

        <div class="card p-4 mt-4">
            <div class="mb-3">
                <label>Urutkan Berdasarkan:</label>
                <select class="form-select" aria-label="Default select example" bind:value= { sort_by_has_absense } on:change = { changeSortByHasAbsen }>
                    <option value="`absens`.`id`:DESC"> Data Terbaru </option>
                    <option value="`absens`.`id`:ASC"> Data Terlama </option>
                    <option value="`absens`.`updated_at`:DESC"> Terbaru Diupdate </option>
                    <option value="`absens`.`updated_at`:ASC"> Terlama Diupdate </option>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Filter Status Absen :</label>
                <select class="form-select" aria-label="Default select example" bind:value= { filter } on:change = { changePerPage }>
                    <option value="">SEMUA</option>
                    <option value="`absens`.`status`: = 'MASUK' ">MASUK</option>
                    <option value="`absens`.`status`: = 'CUTI' ">CUTI</option>
                    <option value="`absens`.`status`: = 'IZIN' ">IZIN</option>
                    <option value="`absens`.`status`: = 'TANPA_KETERANGAN' ">TANPA KETERANGAN</option>
                </select>
            </div>

            <InfoResultHasAbsen result_length={ users_has_absened.length } count_all={ count_all_has_absen } _class="mb-3" _label="Info Sudah Absen"></InfoResultHasAbsen>

            <PaginationHasAbsen data = { pagination_has_absen } on:click = { changePageHasAbsen } _label="Navigation :"></PaginationHasAbsen>
        </div>

        <div class="card p-4 mt-4">
            <div class="d-flex justify-content-end mt-sm-4 mt-md-4 w-100">
                <button type="button" class="btn bg-gradient-danger w-100" on:click={ resetFilter }>
                    <i class="fas fa-history text-white"></i> &nbsp; Reset Filter
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 col-md-12 wrap-content ">
        <div class="card mb-4">
                <h3 class="mt-4 ms-4">Belum Absen</h3>
                { #if ( ! isEmptyArr( users_no_absened ))}
                    <div class="d-lg-flex justify-content-lg-end pe-4 mt-2">
                        <div class="ms-sm-4 ms-lg-0 ms-md-4">
                            <button class="btn btn-danger text-white " on:click = { () => { absenAllNotEntry( "TANPA_KETERANGAN") } }>
                                <i class="icon fas fa-minus text-white"></i> Semua Absen ( TANPA KETERANGAN )
                            </button>
                        </div>
                        <div class="ms-4 mt-sm-2 mt-lg-0 mt-md-0">
                            <button class="btn btn-info text-white " on:click = { () => { absenAllNotEntry( 'MASUK') } }>
                                <i class="icon fas fa-plus text-white"></i> Semua Absen ( MASUK )
                            </button>
                        </div>
                    </div>
                { /if }

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
                                    <td align="left" width ="10%">{ i + (  offset_no_absen + 1 )}</td>
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
            <h3 class="mt-4 ms-4">Sudah Di Absen<h3>
    
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
                                <th class="text-uppercase  text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2"
                                    align="center">Tanggal</th>
                                <th align="center"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            { #each users_has_absened as user, i }
                                <tr>
                                    <td align="left" width ="10%">{ i + ( offset_has_absen + 1 ) }</td>
                                    <td align="left">{ user.name }</td>
                                    <td align="center">{ user.position }</td>
                                    <td align="center" class={ getColorBgStatus( user.status) }>{ ( user.status === "TANPA_KETERANGAN" ? 'TANPA KETERANGAN' : user.status )  }</td>
                                    <td align="center">{ (user.description) ? user.description : '...' }</td>
                                    <td align="center">{ convertToDate( user.created_at, 'DD MMM YYYY' )}</td>
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
                                <td colspan="7">
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