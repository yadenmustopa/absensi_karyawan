import jquery from "jquery";
import { restart } from '../store/toggle_restart';

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

    jquery("main .ps__rail-y").animate({ scrollTop: 0 }, "slow");
    jquery("main .ps__rail-y").css("top","0")
}

export default switchPage;