<script>

    "use strict";

    import Rest from '../../modul/Request';
    import preloader from '../../lib/preloader';
    import Storage from '../../store/Storage';
    import { createEventDispatcher } from 'svelte';

    const dispatch = createEventDispatcher();

    let username;
    let password;

    function login()
    {
        let Req      = new Rest();
        let data     = { username, password }
        let request  = Req.auth( data );

        preloader.show();

        request.then( ( res ) => {
            let body  = res.getBody();
            setToStore( body );
            preloader.hide();
        } )
        
        
    }

    /**
     * 
     * @param { Object } data
     */
    function setToStore( body = {} ){
        let api_key = body.api_key;
        let data    = body.data;

        let Store = new Storage();
        // Store._api_key   = api_key;
        // Store._data_user = data;

        localStorage.setItem('ak-key', api_key);
        localStorage.setItem('ak-data-user', data );
        
        dispatch( 'auth', { data : data } );
    }

</script>
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient text-center">Welcome</h3>
                            </div>

                            <div class="card-body pt-0">
                                <form role="form">
                                    <label>Username</label>
                                    <div class="mb-3">
                                        <input type="username" bind:value={ username } class="form-control" placeholder="Masukan Username" aria-label="Username" aria-describedby="username-addon" >
                                    </div>

                                    <label>Password</label>
                                    <div class="mb-3">
                                        <input type="password" bind:value={ password } class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                    </div>

                                    <div class="text-center">
                                        <button type="button" class="btn bg-gradient-info w-100 mt-4 mb-0" on:click={ login }>Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>