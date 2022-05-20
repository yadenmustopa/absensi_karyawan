"use strict";
import RestApi from './Rest';
class Request
{


    constructor(){
        this.api_key = localStorage.getItem('ak-api-key') || "";
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
    request( path = "/", method="POST" , param = null, body = null, header = null ){
        let Rest = new RestApi();

        if( ! header ){
            header = {"no-strict-version": "yes"}
        }else{
            Object.assign( header, {"no-strict-version": "yes"} );
        }

        return Rest.makeRequest( path, method, param, body, header );
    }
    
    /**
     * 
     * @param { Object } data 
     * @param { String } data.username
     * @param { String } data.password
     * 
     * @returns { Promise }
     */
    auth( data = { } )
    {
        return this.request('/auth','POST',null, data )
    }

    /**
     * 
     * @returns { Promise[{}] }
     */
    getKaryawan(){
        return this.request('/karyawans', "GET", null, null, { "key" : this.api_key } );
    }

    /**
     * 
     * @param karyawan_id { Number }
     * @param data 
     * @param data.photo { multipartform-data  }
     * @param 
     * @returns { Promise[{}] }
     */
    uploadPhotoKaryawan( karyawan_id = 0, data = { } ){
        return this.request('/karyawans/' + karyawan_id, "POST", null, data = {} , { "key" : this.api_key, "content-type":"multipart/form-data" }  )
    }

    /**
     * 
     * @param { Object } data 
     * @param { Number } data.user_id
     * @param { String } data.address
     * @param { String } data.position
     * @param { Number } data.salary
     * @returns { Promise[{}] }
     */
    addKaryawans( data = {} ){
        return this.request('/karyawans','POST',null, data , { "key": this.api_key });
    }


       /**
     * 
     * @param { Number } karyawan_id
     * @param { Object } data 
     * @param { String } data.address
     * @param { String } data.position
     * @param { Number } data.salary
     * @returns { Promise[{}] }
     */
    updateKaryawans( karyawan_id = 0 , data = {} ){
        return this.request('/karyawans/' + karyawan_id , 'PUT', null, data, { "key" : this.api_key });
    }


    /**
     * 
     * @param { Object } data 
     * @param { string } data.search
     * @returns { Promise[{}] }
     */
    getUsers( data = {} ){
        return this.request('/users', "GET", data , null, { "key" : this.api_key });
    }


    /**
     * 
     * @param { Object } data 
     * @param { string } data.name 
     * @param { string } data.username
     * @param { string } data.password
     * @param { status } data.status
     * @returns { Promise [{}]}
     */
    addUsers( data = {} ){
        return this.request('/user', "POST", null, data , { "key" : this.api_key });
    }

    /**
     * 
     * @param { Object } data 
     * @param { Number } data.user_id 
     * @param { String } data.password 
     * @param { String } data.old_password 
     * @returns { Promise[{}] }
     */
    changePassword( data= {} ){
        return this.request('/change_pwd', "PATCH", null, data, { "key" : this.api_key });
    }


    /**
     * 
     * @param { Number } user_id 
     * @param { Object } data 
     * @returns 
     */
    updateUsers( user_id = 0 , data = {} ){
        return this.request('/users/' + user_id , "PUT", null, data, { "key" : this.api_key });
    }


    /**
     * 
     * @param { Number } user_id 
     */
    deleteUsers( user_id = 0 ){
        return this.request('/users/' + user_id, "DELETE", null, null, { "key" : this.api_key } );
    }


    /**
     * 
     * @param { Object } data 
     * @param { string } data.search 
     * @param { string } data.start_date
     * @param { string } data.end_date
     * @returns 
     */
    getAbsense( data = {} ){
        return this.request( '/absens', "GET", data , null, { "key" : this.api_key } );
    }


    /**
     * 
     * @param { Object } data 
     * @param { Number } data.user_id
     * @param { String } data.status
     * @param { string } data.description
     * @returns 
     */
    addAbsens( data ){
        return this.request('/absens', "POST", null, data, { "key" : this.api_key});
    }

    /**
     * 
     * @param { Number } $absen_id 
     * @param { Object } data 
     * @param { String } data.status
     * @param { String } data.description
     * @returns 
     */
    updateAbsens( $absen_id = 0, data = {} ){
        return this.request('/absens/' + $absen_id, "PUT", null , data, { "key" : this.api_key });
    }

}


export default Request;