import jquery from "jquery";
import { restart } from '../store/toggle_restart';
import scrollTopPage from './scroll_top_page';

/**
 * 
 * @param { "dashboard"|"user"|"absen" } to 
 */
function switchPage( to = "dashboard" ){
    console.log({ to });

    jquery(".page" ).addClass('d-none');
    jquery(".page.page-"+ to ).removeClass('d-none');
    restart.set( false );
    
    setTimeout( () => {
        console.log({ restart });
        restart.set( true );
    },200);

    scrollTopPage();
}

export default switchPage;