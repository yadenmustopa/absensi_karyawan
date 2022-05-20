"use strict";

class Storage
{
    constructor()
    {
        this._api_key            = localStorage.getItem('ak-key');
        this._data_user          = localStorage.getItem('ak-data-user');
    }

    removeStorage()
    {
        localStorage.setItem('ak-key','');
        localStorage.setItem('ak-data-user','');
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
        console.log(api_key);
        localStorage.setItem('ak-key', api_key);
    }

    /**
     * @param { Object } data_users
    */
    set dataUser( data ){
        data = JSON.stringify(data);
        console.log({ data });

        localStorage.setItem('ak-data-user', data);
    }

}

export default Storage;