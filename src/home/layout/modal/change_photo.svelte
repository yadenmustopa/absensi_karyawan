<script>
    'use strict';
    import Croppie from 'croppie';
    import Request from '../../modul/request';  
    import preloader from '../../lib/preloader';
    import { alertToast } from '../../lib/alert';
    import { createEventDispatcher } from 'svelte';

    const dispatch = createEventDispatcher();
    let karyawan_id;
    let name;
    let path;
    let result_photo;
    let upload_crop = null;
    let base_url = window.config.base_url;
   
    export let data_selected_photo;

    $:if( data_selected_photo ){
        assignToData();
        result_photo = '';
        instance();
    }

    $:if( result_photo ){
    toUpload();
    }

    function assignToData()
    {

        console.log({ data_selected_photo });
        karyawan_id  = data_selected_photo.karyawan_id;
        path         = data_selected_photo.path;
        name         = data_selected_photo.name;
    }

    function toUpload(){
        preloader.show();

        let Rest = new Request();
        let request = Rest.uploadPhotoKaryawan( karyawan_id, { photo : result_photo });

        request.then( ( res )=>{
            preloader.hide();
            alertToast( 'Berhasil', 'Photo Berhasil diubah', "success" );

            dispatch('success', true );
        }).catch( ( err ) => {
            result_photo = null;
        })
    }

    function instance(){
        let preview_container = window.jquery(".wrap-photo-preview");

        preview_container.on("change", "#photo-preview", (elm) => {
            console.log({ elm });
            if (elm.target.files && elm.target.files[0]) {

                let FR = new FileReader();

                FR.addEventListener("load", function(e) {
                    // document.getElementById("photo-karyawan-preview").src = e.target.result;
                    // document.getElementById("b64").innerHTML = e.target.result;
                    window.jquery("#photo-karyawan-preview").hide();
                    window.jquery("#btn-remove-photo,#btn-apply-photo").removeClass('d-none');
                    window.jquery("#btn-add-photo").addClass('d-none');
                    if(!upload_crop) {
                        upload_crop = new Croppie( document.getElementById('photo-cropper'),{
                                    // enableExif: true,
                            url : e.target.result,
                            viewport: {
                                width: 256,
                                height: 256,
                                type: 'circle'
                            },
                            boundary: {
                                width: 300,
                                height: 300
                            }
                        })
                        // upload_crop = window.jquery('#photo-cropper').croppie({
                        //     // enableExif: true,
                        //     url : e.target.result,
                        //     viewport: {
                        //         width: 256,
                        //         height: 256,
                        //         type: 'circle'
                        //     },
                        //     boundary: {
                        //         width: 300,
                        //         height: 300
                        //     }
                        // });
                    }
                    else {
                        // upload_crop.croppie('bind', {
                        //     url : e.target.result
                        // });
                        upload_crop.bind({
                            url : e.target.result
                        })
                    }


                });

                FR.readAsDataURL( elm.target.files[0] );
            }
        });

        preview_container.on("click", "#btn-add-photo", () => {
            document.getElementById('photo-preview').click();
        });

        preview_container.on("click","#btn-remove-photo", () => {
            window.jquery("#btn-remove-photo,#btn-apply-photo").addClass('d-none');
            window.jquery("#btn-add-photo").removeClass('d-none');
            window.jquery("#photo-karyawan-preview").show();
            // upload_crop.croppie('destroy');
            destroy();
            upload_crop = null;
        });

        preview_container.on("click","#btn-apply-photo", () => {
            window.jquery("#photo-karyawan-preview").show();
            upload_crop.result(
                {
                type : 'base64',
                format : 'webp',
                circle : true,
            }).then((result) => {
                window.jquery("#photo-karyawan-preview").attr('src', result);
                result_photo = result;
                destroy();
                closeModal();
                console.log( { result_photo });
            });
            // upload_crop.croppie('result', {
            //     type : 'base64',
            //     format : 'webp',
            //     circle : true,
            // }).then((result) => {
            //     window.jquery("#photo-karyawan-preview").attr('src', result);
            //     result_photo = result;
            //     destroy();
            //     closeModal();
            //     console.log( { result_photo });
            // });

            window.jquery("#btn-remove-photo").click();
        });

    }

    function closeModal()
    {
        window.jquery(".modal-change-photo .btn-close-modal").click();
    }


    function destroy(){
        if( upload_crop ){
            // upload_crop.croppie('destroy');
            upload_crop.destroy();
        }
    }
</script>

<div class="modal fade modal-change-photo" id="modal-change-photo" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4><b>{ name }</b></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" on:click={ destroy } >
                    <i class="icon fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body p-0">
                <div class="row wrap-photo-preview">
                    <div class="card p-4">
                        <div class="img-wrap d-flex justify-content-center">
                            { #if ( result_photo ) }
                                <img src = { result_photo } id="photo-karyawan-preview" class="mb-3">
                            { :else }
                                <img src = { base_url +'/'+ path } id="photo-karyawan-preview" class="mb-3">
                            { /if }
                        </div>
                        <div id="photo-cropper"></div>
                        <input type="file" class="d-none" name="photo" value="" id="photo-preview" accept="image/jpeg,image/png"/>
                        <div class="text-center">
                            <button class="btn btn-primary" id="btn-add-photo">
                                <i class="fa fa-camera"></i>
                                Upload Foto
                            </button>
                            <button class="btn btn-primary d-none" id="btn-apply-photo">
                                <i class="fa fa-check"></i>
                                Gunakan Foto
                            </button>
                            <button class="btn btn-danger d-none" id="btn-remove-photo">
                                <i class="fa fa-trash"></i>
                                Hapus Foto
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end text-center p-4">
                    <button type="button" class="btn btn-round bg-gradient-danger btn-lg w-100 mt-4 mb-0 btn-close-modal" data-bs-dismiss="modal" on:click={ destroy } >Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>