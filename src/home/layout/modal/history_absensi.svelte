<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher, onMount } from 'svelte';
    // import jquery from 'jquery';
    import DateRangeSelect from 'svelte-date-range-select';

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
    }

    onMount( ()=>{
        // instanceDatepicker();
    });

    let name     = '';
    let user_id  = '';
    let position = '';

    function getHistoryById()
    {
        preloader.show();

        let Rest     = new Request();
        let data     = { name, username, password, role, confirmation_password }
        let request  = Rest.addUsers( data )

        request.then( ( res ) => {
            let body = res.getBody();

            preloader.hide();
            reset();
            document.querySelector("#modal-add-user .btn-close-modal").click();
            alertToast( "success","Data Berhasil Di tambahkan", "success", "top-end", 2000);
            dispatch('success', true );
        });


    }

    function handleApplyDateRange(data){
        console.log(data.detail)
        // e.g. will return an object  
        // {
        //  startDate: 2000-12-01,
        //  endDate: 2020-04-06,
        //  name: createdDate
        // }
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
                            <div class="d-block">
                                <label>Pilih Tanggal :</label><br/>
                                <DateRangeSelect
                                    {startDateMin}
                                    {endDateMax}
                                    name    = { name_datepicker }
                                    heading = { heading_datepicker }
                                    {labels}
                                    {startDateId}
                                    {endDateId}
                                    on:onApplyDateRange = {handleApplyDateRange} 
                                />
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-4 col-md-12 col-sm-4">
                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>