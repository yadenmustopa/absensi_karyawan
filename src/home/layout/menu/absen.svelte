<script>
    "use strict";
    import Rest from '../../modul/Request';
    import { convertToDate, getToday,stringDateToFormat } from '../../lib/handle-moment';
    import ModalAdd from '../modal/add_absen.svelte';
    import ModalUpdate from '../modal/update_absen.svelte';
    import { confirm, alertToast } from '../../lib/alert';
    import preloader from '../../lib/preloader';
    import { restart }  from '../../store/toggle_restart';
    import { isEmptyArr } from '../../lib/handle_array';
    import DateRangeSelect from 'svelte-date-range-select';
    import getColorBgStatus from '../../lib/bg_status_absen';
    import PaginationNoABsen from '../component/pagination.svelte';
    import PaginationHasABsen from '../component/pagination.svelte';
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
    let per_page

    //instance of datepicker svelte
    const startDateId = 'start_date_id' 
    const endDateId = 'end_date_id' 

    const name_datepicker    = 'crated_date';
    const heading_datepicker = 'Jarak Tanggal :' 
        // this limits the HTML5 date picker end date - e.g. today is used here 
    const endDateMax = new Date();

    // this limits the HTML5 date picker's start date - e.g. 3 years is select here
    const startDateMin = new Date(
    new Date().setFullYear(endDateMax.getFullYear(), endDateMax.getMonth() - 36)
    );

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
            data.page = page_has_absen;
        }else{
            data.page = page_no_absen;
        }

        if( search ){
            Object.assign( data, { search })
        }

        let request = Request.getAbsens( data );

        request.then( ( res )=>{
            let body = res.getBody();

            if( has_absen === "Y" ){
                users_has_absened = body.data;
                pagination_has_absen = body.pagination;
                console.log({ users_has_absened })
            }else{
                users_no_absened = body.data;
                pagination_no_absen = body.pagination;
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

    function handleApplyDateRange(data){

        let value  = data.detail;
        start_date = value.startDate;
        end_date   = value.endDate;

        starter();
    }

    function resetFilter(){
        console.log('reset filter');
        search = "";
        defaultRangeDate();
        starter();
    }

        /**
     * 
     * @param { Object } e
     */
     function changePageHasAbsen( e ){
        let page_to = e.detail.page_to;
        page        = page_to;
        getAbsen();
    }


</script>

<div class="row mt-4 d-none page page-absen">
    <div class="col-12 d-flex justify-content-end p-4 pt-0 pb-2">
    </div>

    <div class="col-lg-4 col-sm-12 col-md-12 mb-lg-0 mb-4">
        <div class="card p-4">
            <h4>Filter</h4>
            <div>
                <label>Cari Nama Karyawan : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" bind:value = { search } placeholder= "Cari Nama" aria-label="search" aria-describedby="basic-addon1">
            </div>
            <div class="d-flex-lg justify-content-lg-between">

                <div class="d-block">
                    <label>Pilih Tanggal :</label><br/>
                    <div class="wrap-date-range">
                        <DateRangeSelect
                            name    = { name_datepicker }
                            heading = { heading_datepicker }
                            {startDateMin}
                            {endDateMax}
                            {labels}
                            {startDateId}
                            {endDateId}
                            on:onApplyDateRange = {handleApplyDateRange} 
                        />
                    </div>
                </div>
    
                <div class="d-flex justify-content-end mt-sm-4 mt-md-4">
                    <button type="button" class="btn bg-gradient-danger" on:click={ resetFilter }>
                        <i class="fas fa-history text-white"></i> &nbsp; Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="card p-4 mt-4">
            <label>Navigation : </label>
            <Pagination data = { pagination_has_absen } on:click = { changePageHasAbsen }></Pagination>
        </div>
    </div>

    <div class="col-lg-8 col-sm-12 col-md-12 wrap-content ">
        <div class="card mb-4">
                <h3 class="mt-4 ms-4">:: Belum Absen ::</h3>
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
                                    <td align="left" width ="10%">{ i + 1 }</td>
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
            <h3 class="mt-4 ms-4">:: Sudah Di Absen ::</h3>
    
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
                                    <td align="left" width ="10%">{ i + 1 }</td>
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