import jquery from "jquery";

/**
 * 
 * @param { "dashboard"|"user"|"absen" } to 
 */
function switchPage( to = "dashboard" ){
    jquery(".page" ).addClass('d-none');
    jquery(".page.page-"+ to ).removeClass('d-none');
    
}

export default switchPage;