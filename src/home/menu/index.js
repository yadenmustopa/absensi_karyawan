const admin = [
    {
        icon : 'fas fa-chart-line',
        name : 'DASHBOARD',
        href : 'dashboard'
    },
    {
        icon : 'fas fa-user',
        name : 'DATA USER',
        href  : 'user',
    },
    {
        icon : 'fas fa-check',
        name : 'ABSENSI',
        href : 'absen'
    }
];

const karyawan = [
    {
        icon : 'fas fa-chart-line',
        name : 'DASHBOARD',
        href : 'dashboard'
    },
];

/**
 * 
 * @param { String } status 
 * @returns 
 */
function getMenu( status = 'admin' ){

    status = status.toLowerCase();

    console.log({ status });
    if( status === 'admin' ){
        return admin;
    }else{
        return karyawan;
    }
}

export default getMenu;