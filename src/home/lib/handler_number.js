/**
 *
 * @param angka
 * @return {string}
 */
 function formatIDR( angka = 0 )
 {
     if( ! angka ) return 0;
     
     var reverse = angka.toString().split('').reverse().join(''),
     ribuan 		= reverse.match(/\d{1,3}/g);
     ribuan 		= ribuan.join('.').split('').reverse().join('');
 
     return ribuan;
 }
 /**
  * Usage example:
  * alert(convertToRupiah(10000000)); -> "Rp. 10.000.000"
  * @param { String } rupiah
  */
 function IDRToNumber(rupiah)
 {
     return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
 }

 module.exports = { formatIDR, IDRToNumber }