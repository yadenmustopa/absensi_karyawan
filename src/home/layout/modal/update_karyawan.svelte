<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    export let data_selected;
    
    let address  = "";
    let position = "ADMIN";
    let salary   = "";

    const dispatch = createEventDispatcher();

    starter();

    $:if( data_selected ){
        assignToData( data_selected );
    }

    function starter(){
        getJabatans();
    }

    function getJabatans(){
        
    }

    function assignToData( data ){
        console.log( { data });
        address  = data.address;
        position = data.position;
        salary   = data.salary;
    }

    function updateUser()
    {
        preloader.show();

        let Rest     = new Request();
        let data     = { name, role }
        let request  = Rest.updateKaryawans( user_id, data );

        request.then( ( res ) => {
            console.log({ res });
            // let body = res.getBody();

            preloader.hide();
            document.querySelector("#modal-update-user .btn-close-modal").click();
            alertToast( "success","Data "+ data_selected.name +"Berhasil Di ubah", "success", "top-end", 2000);
            dispatch('success', true );
        });


    }

</script>


<div class="modal fade" id="modal-update-user" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient text-center">Update Data Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <label>Adress:</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" bind:value = { name }
                                    aria-describedby="email-addon">
                            </div>
                            
                            <select class="form-select" aria-label="Default select example" bind:value= { role }>
                                <option value="ADMIN">ADMIN</option>
                                <option value="KARYAWAN">KARYAWAN</option>
                              </select>

                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" on:click={ updateUser } >Ubah</button>
                                <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal"  data-bs-dismiss="modal" >Batal</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>