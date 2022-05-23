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
 * @param { String } text 
 * @param { "success"|"error"} icon 
 * @param { Number } timer 
 * @param { "center"|"top"|"top-start"|"top-end"|"center-start"|"center-end"|"bottom"|"bottom-start"|"bottom-end" } position 
 */
function alertToast(title = "success", text = "success menambakan", icon = "success", position = "top-end", timer = 4000) {
	const Toast = Swal.mixin({
		toast: true,
		position: position,
		showConfirmButton: false,
		text: text,
		timer: timer,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	Toast.fire({
		icon: icon,
		title: title
	})
}

/**
 * 
 * @param { String } title 
 * @param { String } text_button 
 * @returns { Promise{ bool } } 
 */
function confirm( title= "Yakin!!!", text_button = "Oke" ){
	return new Promise( ( resolve, reject ) => {
		Swal.fire({
			title: title,
			showCancelButton: true,
			confirmButtonText: 'Oke',
		}).then((result) => {
			console.log({ result });
			if (result.isConfirmed) {

				resolve(true); 
				return;
			}
	
			reject(false);
		})
	})
	
}

module.exports = { alert, alertToast, confirm };