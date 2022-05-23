import jquery from "jquery";
import { restart } from '../store/toggle_restart';

/**
 * 
 * @param { "dashboard"|"user"|"absen" } to 
 */
function switchPage( to = "dashboard" ){
    jquery(".page" ).addClass('d-none');
    jquery(".page.page-"+ to ).removeClass('d-none');
    restart.set( false );
    
    setTimeout( () => {
        console.log({ restart });
        restart.set( true );
    },200);
}

export default switchPage;