"use strict";

const moment = require("moment");

moment.locale('id');

/**
 *
 * @param time_stamp
 * @return {DateFormat}
 */
function convertToDate( time_stamp, format = "DD MM yyyy" ){
	return dateFormat( time_stamp * 1000, format );
}

/**
 *
 * @return {number}
 */
function getTimeStamp(){
	return new Date().getTime()/1000;
}

/**
 *
 * @param string
 * @param format
 * @return {string}
 */
function stringDateToFormat( string, format = "x"){
	let date = new Date(string)
	return moment(date).format(format);
}

/**
 *
 * @param { String } format
 * @return { String }
 */
function getToday( format ){
	return moment().format(format);
}


/**
 *
 * @param { Timestamp } time
 */
function longTimePassed( time ){
	return moment(time).fromNow();
}


/**
 *
 * @param timestamp_or_date
 * @param format
 * @param formatTimestamp DD MMM YYYY
 * @return {string}
 */
function dateFormat( timestamp_or_date, format = "DD MM YYYY", formatTimestamp = ""  ){

	if( formatTimestamp ){
		return moment(timestamp_or_date, formatTimestamp ).format( format );
	}

	return moment(timestamp_or_date).format( format );
}

function countToExpire( fromTime,longTime ){
	longTime           = longTime.split(/(\s+)/);
	let number_of_time = longTime[0];
	let range_time     = longTime[2];

	if(number_of_time == "a") number_of_time = "1";
	number_of_time = parseInt(number_of_time);


	let until_time = untilTime(fromTime,number_of_time,range_time);
	let from_now   = longTimePassed(until_time);

	return from_now;
}


function untilTime(from_time,number,range){
	return moment(from_time).add(number,range);
}

/**
 *
 * @param { String } this_date
 * @param { String } from_date
 * @param { String } to_date
 * @return { Boolean }
 * @example
 * isBetween("2020-08-01", "2020-06-03", "2020-09-03")
 */
function isBetween( this_date, from_date, to_date ){
	return moment( this_date ).isBetween( from_date, to_date );
}


function convertDDMYYYY( date_string =  "" , format = "YYYY-MM-DD"){
	moment.updateLocale('ina',{
		monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
	});

	let date = moment(date_string, "DD MMM YYYY", "ina" );

	return date.format('YYYY-MM-DD');

}

/**
 *
 * @param format
 * @return {{start: string, end: string}}
 */
function rangeDateThisMonth( format = "x" ){
	let startOfMonth = moment().clone().startOf('month').format( format ) ;
	let endOfMonth   = moment().clone().endOf('month').format(format );

	if( format === "x" ){
		startOfMonth = startOfMonth / 1000;
		endOfMonth	 = endOfMonth / 1000;
	}

	return { start : startOfMonth , end : endOfMonth }
}


/**
 *
 * @param separator
 * @param string_date
 * @return { Object }
 */
function split_date_range( separator = "-", string_date = "" ){

	if( ! string_date ){
		return {}
	}

	let dates = string_date.split( separator );

	let from  = dates[0].trim();

	from = convertDDMYYYY( from );

	let to = "";

	if( dates[1] ){
		to = dates[1].trim();
		to = convertDDMYYYY( to );
	}

	return { from, to };
}


module.exports = {
	split_date_range,
	convertToDate,
	getTimeStamp,
	isBetween,
	countToExpire,
	stringDateToFormat,
	rangeDateThisMonth,
	getToday,
	dateFormat,
	untilTime,
	longTimePassed,
}