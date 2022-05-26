<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    export let data_selected;
    
    let name        = "";
    let description = "";
    let id          = "";

    const dispatch = createEventDispatcher();

    $:if( data_selected ){
        console.log({ data_selected });
        assignToData( data_selected );
    }

    function assignToData( data ){
        console.log( { data });
        name         = data.name;
        description  = data.description;
        id           = data.id;
    }

    function updateJabatan()
    {
        preloader.show();

        let Rest     = new Request();
        let data     = { name, description }
        let request  = Rest.updateJabatans( id, data );

        request.then( ( res ) => {
            console.log({ res });
            // let body = res.getBody();

            preloader.hide();
            document.querySelector("#modal-update-jabatan .btn-close-modal").click();
            alertToast( "success","Data "+ data_selected.name +"Berhasil Di ubah", "success", "top-end", 2000);
            dispatch('success', true );
        });


    }

</script>


<div class="modal fade" id="modal-update-jabatan" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient text-center">Update User</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <label>Nama:</label>
                            <div class="input-group mb-3">
                                <input type="nama" class="form-control" placeholder="Nama" aria-label="Nama" bind:value = { name }
                                    aria-describedby="email-addon">
                            </div>
                            
                            <label>Description:</label>
                            <div class="input-group mb-3">
                                <textarea type="text" class="form-control" placeholder="Keterangan" bind:value = { description }
                                    aria-label="description" ></textarea>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" on:click={ updateJabatan } >Ubah</button>
                                <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal"  data-bs-dismiss="modal" >Batal</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>