const Swal = require("sweetalert2");

/**
 * 
 * @param { String } title 
 * @param { String } text 
 * @param { "success"|"error"} icon 
 * @param { "center"|"top"|"top-start"|"top-end"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end" } position 
 */
function alert( title = "Success", text="Success!!!" , icon="success" , position ="center"){
    Swal({
        title : title,
        text : text,
        icon : icon,
        position : position
    }).fire();
}

/**
 * 
 * @param { String } title 
 * @param { "success"|"error"} icon 
 * @param { Number } timer 
 * @param { "center"|"top"|"top-start"|"top-end"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end" } position 
 */
function alertToast( title="success", icon = "success", position="top-end", timer = 4000){
    const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: icon,
        title: title
      })
}

module.exports = { alert, alertToast };