<script>
    "use strict";
	import { createEventDispatcher, onMount } from 'svelte';
	import Nav 		 from './nav.svelte';
	import Dashboard from './menu/dashboard.svelte';
	import User 	 from './menu/user.svelte';
	import Absen 	 from './menu/absen.svelte';
	import Karyawan 	 from './menu/karyawan.svelte';
	import redirect  from '../lib/redirect-page';

	const dispatch = createEventDispatcher();

    export let menu_active = "dashboard";

	let data_user;
	let user;
	let role;

    $:if( menu_active ){
		console.log({ menu_active });
		redirect( menu_active );
    }

	onMount( ()=>{
		redirect( menu_active );
	});

	starter();

	function starter(){
		data_user = JSON.parse( localStorage.getItem('ak-data-user') ); 
		user      = data_user.name;

		role      = data_user.role;
		
		console.log({ role });
	}


</script>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
	<Nav user={ user } menu_active={ menu_active }></Nav>


	<!-- End Navbar -->
	<div class="container-fluid py-4">

		<Dashboard data_user={ data_user }></Dashboard>

		{ #if role === 'ADMIN' }
			<User></User>
			<Absen></Absen>
			<Karyawan></Karyawan>
		{ /if }

	</div>
</main>