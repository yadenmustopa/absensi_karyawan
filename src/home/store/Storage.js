"use strict";

class Storage
{
    constructor()
    {
        this._api_key            = localStorage.getItem('ak_key');
        this._data_user          = localStorage.getItem('ak_data_user');
    }

    removeStorage()
    {
        localStorage.setItem('ak_key','');
        localStorage.setItem('ak_data_user','');
    }

    /**
     * @return { String }
    */
    get apiKey(){
        let api_key = this._api_key;

        return api_key;
    }

    /**
     * @return { Object }
    */
    get dataUser(){
        let data_user = this._data_user;
        
        if ( data_user ){
            data_user = JSON.parse(data_user);
        }

        return(data_user);
    }

    /**
     * @param { string } api_key
    */
        set apiKey(api_key){ 
        localStorage.setItem('key', api_key);
    }

    /**
     * @param { Object } data_users
    */
    set dataUser( data ){
        data = JSON.stringify(data);

        localStorage.setItem('data_user', data);
    }

}

export default Storage;