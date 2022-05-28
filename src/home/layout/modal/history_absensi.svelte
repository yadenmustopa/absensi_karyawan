<script>
    export let data_selected;

    import HistoryAbsensi from '../component/data_history.svelte';

    //end instace
   

    $:if( data_selected ){
        assignToData();
    }

    let name     = '';
    let user_id  = '';
    let position = '';

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
               <HistoryAbsensi user_id={ user_id }></HistoryAbsensi>
            </div>
        </div>
    </div>
</div>