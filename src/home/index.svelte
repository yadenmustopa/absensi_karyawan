<script>
    import { createEventDispatcher } from 'svelte';

    const dispatch = createEventDispatcher();

    function logout()
    {
        localStorage.setItem('ak-key','');
        localStorage.setItem('ak-data-user','');

        dispatch('logout',{ logout : true });

    }
</script>

<h1>Selamat datang di Dashboard</h1>
<button class="btn btn-danger" on:click={ logout }></button>