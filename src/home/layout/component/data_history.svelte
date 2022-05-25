<script>
    "use strict";
    import Request from '../../modul/Request';
    // import jquery from 'jquery';
    // import daterangepicker from 'daterangepicker';
    // import { onMount } from 'svelte';

    export let user_id;

    let start_date;
    let end_date;
    let date;
    let datas = [];

    $:if( $user_id ){
        getHistoryById();
    }

    // onMount( ()=>{
    //     // instanceDatepicker();
    // });


    // function instanceDatepicker(){
    //     jquery('input#history-date').daterangepicker({
    //         opens: 'left'
    //     }, function(start, end, label) {
    //         console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    //     });
    // }

    function getHistoryById()
    {
        let Rest = new Request();
        let data = { start_date, end_date }
        let request = Rest.getAbsenById( user_id, data );

        request.then( ( res )=> {
            body  = res.getBody();
            datas = body.data;
            console.log({ datas });
        } )
    }

    
</script>

<div class="row">
    <div class="col-lg-4 col-md-12 col-sm-4">
        <div class="card p-4">
            <div>
                <label>Dari - Sampai Tgl : </label>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                <input type="text" id="history-date" class="form-control" placeholder= "tanggal" >
              </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 col-sm-4">

    </div>
</div>