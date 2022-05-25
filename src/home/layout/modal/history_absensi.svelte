<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher, onMount } from 'svelte';
    // import jquery from 'jquery';
    import DateRangeSelect from 'svelte-date-range-select';
    import { getToday, convertToDate, stringDateToFormat } from '../../lib/handle-moment';

    export let data_selected;

    let start_date;
    let end_date;
    let date;
    let datas = [];

    
    //instance of datepicker svelte
    const startDateId = 'start_date_id' 
    const endDateId = 'end_date_id' 

    const name_datepicker    = 'crated_date';
    const heading_datepicker = 'Jarank Tanggal :' 
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


    //end instace
   

    $:if( data_selected ){
        assignToData();
        starter();
    }

    onMount( ()=>{
        // instanceDatepicker();
    });

    let name     = '';
    let user_id  = '';
    let position = '';

    default_range_date();


    function starter(){
        getHistoryById();
    }

    function default_range_date(){
        start_date = getToday('YYYY-MM-DD');
        end_date   = getToday('YYYY-MM-DD');
    }

    function getHistoryById()
    {
        preloader.show();

        let Rest     = new Request();

        console.log({ start_date, end_date });
        let start    = stringDateToFormat( start_date + ' 00:00:00')/1000; 
        let end      = stringDateToFormat( end_date + ' 23:59:59')/1000; 
        let data     = { start_date : start , end_date : end }
        console.log({ data });
        let request  = Rest.getAbsenById( user_id, data );

        request.then( ( res ) => {
            let body = res.getBody();
            datas    = body.data;

            preloader.hide();
        });

    }

    function handleApplyDateRange(data){

        let value  = data.detail;
        start_date = value.startDate;
        end_date   = value.endDate;

        getHistoryById();
        // e.g. will return an object  
        // {
        //  startDate: 2000-12-01,
        //  endDate: 2020-04-06,
        //  name: createdDate
        // }
    }

    /**
     * 
     * @param status
     */
    function getColorBgStatus( status = "MASUK"){
        if( status === 'MASUK' ){
            return 'bg-gradient-info text-white';   
        }else if( status === 'IZIN' ){
            return 'bg-gradient-warning text-white'   
        }else if( status === 'CUTI'){
            return 'bg-gradient-primary text-white'
        }else{
            return 'bg-gradient-danger text-white'
        }
    }

    function assignToData()
    {
        name     = data_selected.name;
        position = data_selected.position;
        user_id  = data_selected.user_id;
    }

</script>

<!-- Full screen modal -->
<div class="modal fade" id="modal-history-absen" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b>{ name }</b>{ '(' + position + ')'}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="icon fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body p-0">
               <!-- <HistoryAbsensi user_id={ user_id }></HistoryAbsensi> -->
               <div class="row p-4">
                    <div class="col-lg-4 col-md-12 col-sm-4">
                        <div class="card p-4">
                            <h3>Filter</h3>
                            <div class="d-block">
                                <label>Pilih Tanggal :</label><br/>
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
                                <td align="left" width ="10%">{ i + 1 }</td>
                                <td align="left">{ convertToDate( absen.created_at, 'DD MMM YYYY H:m:s' )  }</td>
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
            </div>
        </div>
    </div>
</div>