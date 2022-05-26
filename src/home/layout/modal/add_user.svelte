<script>
    import Request from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import { alert, alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    let name     = '';
    let username = '';
    let password = '';
    let confirmation_password = '';
    let role     = 'ADMIN';

    const dispatch = createEventDispatcher();

    function addUser()
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


    function reset()
    {
        name     = '';
        username = '';
        password = '';
        confirmation_password = '';
        role     = 'ADMIN';
    }

</script>


<div class="modal fade" id="modal-add-user" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h4 class="font-weight-bolder text-info text-gradient text-center">Tambah User</h4>
                    </div>
                    <div class="card-body">
                        <form role="form text-left">
                            <label>Nama:</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" bind:value = { name }
                                    aria-describedby="email-addon">
                            </div>
                            
                            <label>Username:</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Username" bind:value = { username }
                                    aria-label="username" >
                            </div>

                            <label>Password:</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" bind:value={ password }
                                    aria-label="Password" aria-describedby="password-addon">
                            </div>

                            <label>Konfirmasi Password:</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Ketik Ulang Password" bind:value={ confirmation_password }
                                    aria-label="confirmation_password" aria-describedby="password-addon">
                            </div>

                            <label>Role:</label>
                            <select class="form-select" aria-label="Default select example" bind:value= { role }>
                                <option value="ADMIN">ADMIN</option>
                                <option value="KARYAWAN">KARYAWAN</option>
                              </select>

                            <div class="text-center">
                                <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0" on:click={ addUser } >Simpan</button>
                                <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal" data-bs-dismiss="modal" >Batal</button>
                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>