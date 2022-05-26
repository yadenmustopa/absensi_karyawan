<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    let name         = '';
    let description  = '';

    const dispatch = createEventDispatcher();

    function addJabatan()
    {
        preloader.show();

        let Rest     = new Request();
        let data     = { name, description }
        let request  = Rest.addJabatans( data )

        request.then( ( res ) => {
            // let body = res.getBody();

            preloader.hide();
            reset();
            document.querySelector("#modal-add-jabatan .btn-close-modal").click();
            alertToast( "success","Data Berhasil Di tambahkan", "success", "top-end", 2000);
            dispatch('success', true );
        });


    }

    function reset()
    {
        name     = '';
        description = '';
    }

</script>


<div class="modal fade" id="modal-add-jabatan" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient text-center">Tambah Jabatan</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <label>Nama:</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama Jabatan/Bag" aria-label="Nama-Jabatan" bind:value = { name }>
                            </div>
                            
                            <label>Description:</label>
                            <div class="input-group mb-3">
                                <textarea type="text" class="form-control" placeholder="Keterangan" bind:value = { description }
                                    aria-label="description" ></textarea>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" on:click={ addJabatan } >Simpan</button>
                                <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal" data-bs-dismiss="modal" >Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>