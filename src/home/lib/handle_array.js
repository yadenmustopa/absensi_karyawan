"use strict";

/**
 * @description cek Exists in other array
 * @param { [ ] }arr
 * @param { [] }target
 * @param { string } if arr object[]
 * @returns { Boolean }
 */
function cekExistsAllArray( arr = [], target = [], property="" ){

	if( ! arr ) return;

	if( property ){
		arr = arr.map( item => item[ property ]);
	}

	target.every( v => {
		if( property ){
			return arr.includes( v );
		}else{
			return arr.includes( v );
		}
	});
}


/**
 * @description if cek Exist with value of object in arr
 * @param { Any[] } arr
 * @param { String } property of Object
 * @param { String } value of property
 * @return { boolean }
 */
function cekExistObjectInArray( arr = [], property = "", value = "" ){
	if( arr.filter( e => e[property] === value ).length > 0 ){
		return true;
	}else{
		return false;
	}
}


/**
 *
 * @param {[]} arr
 * @param {[]} target
 * @param { String }property
 * @returns { Boolean }
 */
function foundInContentArray( arr = [] , target = [], property="" ){
	if( ! arr ) return;

	if( property ){
		arr = arr.map( item => item[ property ]);
	}

	console.log({ arr });

	return arr.some(r => {
		if( property ){
			return target.indexOf( r ) >= 0
		}else{
			return target.lastIndexOf( r ) >= 0
		}
	});
}


/**
 * @description If inside array not object
 * @param { Any[] } arr
 * @param { String | Number }target
 * @returns {boolean}
 */
function cekExistInArray( arr= [], target= "" ){
	if( arr.indexOf( target ) !== -1 ){
		return true;
	} else{
		return false;
	}
}

/**
 *
 * @param { Object }obj
 * @param { bool} Use Bracket
 * @return {{}[]}
 */
function convertObjectToArray( obj = {}, useBracket = false ){
	let result = Object.keys( obj ).map(function (key) {
		let value = obj[key] || "";

		if( useBracket ){
			return { [key] : value } ;
		}else{
			return [key] +":"+ value ;
		}
	});

	return result;
}


/**
 *
 * @param array
 * @return { boolean }
 */
function isEmptyArr( array ){

	if( ! array || array.length === 0){
		return true;
	}
	return false;
}


/**
 *
 * @param { Array } array
 * @param { Number } n
 * @return { Any }
 */
function lastIndexArray( array, n){
	if (array == null) return void 0;

	if (n == null) return array[array.length - 1];

	return array.slice(Math.max(array.length - n, 0));
}


/**
 *
 * @param { { MyNumber : Number, MyString : String , myArray : Array , MyObj : Object }[] } array
 * @param { String } delimiter
 * @param { String } prefix
 * @return { string }
 */
function mergeArrayToString( array = "", delimiter="", prefix = "" ){
	let last_index = lastIndexArray( array );

	let generate = "";

	array.forEach( ( item, index ) => {
		generate += ( item.toString() );

		if( item === last_index ) return ;

		generate += delimiter;
	} );

	return ( prefix ) ? ( prefix + generate ) : generate;
}


/**
 *
 * @param { [] } arr
 * @param { Number } index
 * @param { Number } range
 * @return { Number }
 */
function getOffset(arr, index= 0, range= 1 ) {
	return arr[(((index + range) % arr.length) + arr.length) % arr.length];
}


/**
 *
 * @param { [] } arr
 * @param { Number } range
 * @param { Step } Number
 * @return {[]}
 */
function getArrayOffsets( arr, range, step = 1 ){

	let offset   = ( step-1 ) * range;
	let to_index = step * (range - 1 );

	let collections = [];

	arr.map( ( item , i ) => {
		let index = Math.ceil( offset/range );

		if ( i >= offset && i >= to_index ){
			offset     = to_index;
			to_index   = to_index + range;
		}

		if( ! collections[index] ){
			collections[index] = [];
		}

		collections[index].unshift( item );
	});

	console.log({ collections });

	return collections;

}

/**
 *
 * @param { [] }a
 * @param { [] }b
 * @param { String } prop
 * @return {[]}
 */
function mergeArrayOfObject(a, b, prop){
	var reduced =  a.filter( aitem => ! b.find ( bitem => aitem[prop] === bitem[prop]) )
	return reduced.concat(b);
}


/**
 *
 * @param { String | Number } query
 * @param { Object[] } data
 * @return { [] }
 */
const filterItems = ( query, data , key_value = "nama") => {
	if( ! query ){
		return data;
	}

	query = query.toLowerCase();
	return data.filter(item => item[key_value].toLowerCase().indexOf(query) >= 0);
}


/**
 *
 * @param a1
 * @param a2
 * @return {*}
 */
const mergeById = (a1, a2) =>
a1.map(itm => ({
	...a2.find((item) => (item.id === itm.id) && item),
	...itm
}));




module.exports = {
	cekExistsAllArray,
	foundInContentArray,
	cekExistInArray,
	cekExistObjectInArray,
	convertObjectToArray,
	isEmptyArr,
	lastIndexArray,
	mergeArrayToString,
	mergeArrayOfObject,
	getArrayOffsets,
	filterItems,
	mergeById,
};
