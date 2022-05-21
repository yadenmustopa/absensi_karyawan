import jquery from "jquery";

/**
 * 
 * @param { "dashboard"|"user"|"absen" } to 
 */
function switchPage( to = "dashboard" ){
    jquery( ".container" ).addClass("d-none");

    
    let cek = jquery(".container page-" + to).removeClass("d-none");
}

export default switchPage;