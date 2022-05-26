/**
     * 
     * @param status
     */
 function getColorBgStatus( status = "MASUK"){
    if( status === 'MASUK' ){
        return 'bg-gradient-info text-white';   
    }else if( status === 'IZIN' ){
        return 'bg-gradient-warning text-white'   
    }else if( status === 'CUTI'){
        return 'bg-gradient-primary text-white'
    }else{
        return 'bg-gradient-danger text-white'
    }
}

module.exports = getColorBgStatus;