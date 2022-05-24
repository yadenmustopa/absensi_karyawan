<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    export let data_selected = {};

    let absen_id     = '';
    let name         = '';
    let status       = '';
    let description  = '';

    const dispatch = createEventDispatcher();

    $:if( data_selected ){
        assignToData();
    }

    function addAbsen()
    {
        preloader.show();

        let Rest     = new Request();
        let data     = { user_id, status, description }
        let request  = Rest.updateAbsens( absen_id , data );

        request.then( ( res ) => {
            // let body = res.getBody();

            preloader.hide();
            reset();
            document.querySelector("#modal-update-absen .btn-close-modal").click();
            alertToast( "success",name + " Data Berhasil Di Absen", "success", "top-end", 2000);
            dispatch('success', true );
        });


    }


    function assignToData()
    {
        absen_id      = data_selected.absen_id;
        name          = data_selected.name;
        status        = data_selected.status;
        description   = data_selected.description;
    }

    function reset()
    {
        absen_id     = '';
        status       = '';
        description  = '';
    }

</script>


<div class="modal fade" id="modal-update-absen" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient text-center">Tambah User</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <label>Nama :</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="Nama" bind:value = { name }  disabled>
                            </div>

                            <label>Status Absen:</label>
                            <select class="form-select" aria-label="Default select example" bind:value= { status }>
                                <option value="MASUK">MASUK</option>
                                <option value="TANPA_KETERANGAN">TANPA KETERANGAN</option>
                                <option value="CUTI">CUTI</option>
                                <option value="IZIN">IZIN</option>
                            </select>


                            <label>Ketrangan :</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Keterangan" aria-label="Nama" bind:value = { description } >
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" on:click={ addAbsen } >Simpan</button>
                                <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal" data-bs-dismiss="modal" >Batal</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>