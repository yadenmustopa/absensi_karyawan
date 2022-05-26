import {Rest} from "@keyos/api-sdk";
import Swal from 'sweetalert2'
import preloader from '../lib/preloader';
import axios from 'axios';

class KeyOSApi {

    constructor(base_url = "") {
        
        this.base_url = base_url ? base_url :
            window.config.base_url ? window.config.base_url : ""

        this.api_key = ""
    }

    setApiKey(api_key)
    {
        this.api_key = api_key
        return this
    }


    /**
     * Make Request to the API
     * @param path {String}
     * @param method {'GET'|'POST'|'PATCH'|'PUT'|'DELETE'}
     * @param query_param {object|null}
     * @param body {object|null}
     * @param headers {object|null}
     * @return Promise<object>
     */
    makeRequest(path = "", method = "GET", query_param = null, body = null, headers = null) {
        let request = new Rest.ApiRequest();
        let RestApi = new Rest.Api();

        request.setBaseURL(this.base_url).setMethod(method).setPath(path)

        headers.key = headers.key ? headers.key : this.api_key

        if(headers) request.setHeaders(headers)
        if(body) request.setRequestBody(body)
        if(query_param) request.setRequestQuery(query_param)

        return RestApi.call(request).catch((err) => {
            let body = err.getBody();

            console.log( { err, body });

            let code = body.code;
            let message = body.message;

            // if( code === 500 && message ==="Call to a member function getGet() on null"){
            //     localStorage.setItem('ak-key','');
            //     localStorage.setItem('ak-data-user','');
            //     window.location.href = "/";
            // }

            
            
            preloader.hide();

            //open Sweet alert when errord detected

            Swal.fire({
                icon: 'error',
                title: 'Eroor',
                text: body.message
            })
        })
    }

            /**
     * 
     * @param  path { string }
     * @param  method { 'GET'|'POST'|'PUT'|'PATCH'|'DELETE' }
     * @param  param { Object}
     * @param  body { Object }
     * @param  header { Object }
     * @returns 
     */
    requestAxios( path = "/", method="POST" , param = null, body = null, header = null ){
        return new Promise( ( resolve, reject ) =>{

            axios({
                method: method,
                url: window.config.base_url + path,
                data:body,
                headers : header
            }).then( ( res ) => {
                let data  = res.data;
                let success = data.success;

                console.log({ data });
                if( success ){
                    resolve( data );
                }else{
                    reject( data );
                }

            }).catch( ( err ) => {
                // let body = err.getBody();
            
                preloader.hide();
    
                //open Sweet alert when errord detected
    
                Swal.fire({
                    icon: 'error',
                    title: 'Eroor',
                    text: body.message
                })
            })
        } )
    }
}

export default KeyOSApi