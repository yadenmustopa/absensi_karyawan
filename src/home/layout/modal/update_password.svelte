<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    export let data_selected;
    
    let role_access  = "";
    let user_id      = "";
    let password     = "";
    let old_password = "";

    const dispatch = createEventDispatcher();

    starter();

    $:if( data_selected ){
       
        assignToData( data_selected );
    }

    function starter(){
        // getJabatans();
    }

    // function getJabatans(){
    //     let Rest     = new Request();
    //     let request  = Rest.getJabatans();

    //     request.then( ( res ) => {
    //         let body  = res.getBody();

    //         console.log({ body })
    //         jabatans = body.data;

            
    //     })
    // }

    function assignToData( data ){
        console.log( { data } );

        role_access  = data.role_access;
        user_id      = data.user_id;
    }

    function updatePassword()
    {
        preloader.show();

        let Rest     = new Request();
        let data     = { role_access, user_id, password, old_password }
        let request  = Rest.changePassword( data );

        request.then( ( res ) => {
            console.log({ res });
            // let body = res.getBody();

            preloader.hide();
            document.querySelector("#modal-update-pwd-user .btn-close-modal").click();
            alertToast( "success","Data "+ "Password "+ data_selected.name +" Berhasil Di ubah", "success", "top-end", 2000);
            reset();
            dispatch('success', true );
        });


    }

    function reset(){
        role_access  = "";
        user_id      = "";
        password     = "";
        old_password = "";
    }

</script>


<div class="modal fade" id="modal-update-pwd-user" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient text-center">Ubah Password</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <label>Password:</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Password" aria-label="Password" bind:value = { password }
                                    aria-describedby="email-addon">
                            </div>
                            
                            { #if role_access === "KARYAWAN"}
                                <label>Old Password</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Password Sebelumnya" aria-label="OldPassword" bind:value = { old_password } >
                                </div>
                            { /if}

                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" on:click={ updatePassword } >Ubah</button>
                                <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal"  data-bs-dismiss="modal" >Batal</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>