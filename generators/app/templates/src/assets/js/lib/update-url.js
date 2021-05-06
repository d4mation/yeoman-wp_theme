/**
 * Gets a Value from a Query String by Key
 *
 * @param   string  queryString  Query String
 * @param   string  key          
 *
 * @since   {{VERSION}}
 * @return  string               Query String
 */
function getURLParam( queryString, key ) {

    var vars = queryString.replace( /^\?/, '' ).split( '&' );

    for ( var i = 0; i < vars.length; i++ ) {

        var pair = vars[ i ].split( '=' );

        if ( pair[0] == key ) {
            return pair[1];
        }

    }

    return false;

}

/**
 * Update a URL Query String Param by Key, preserving any Hash
 *
 * @param   string  queryString    URL
 * @param   string  key            Query Stirng Param Key
 * @param   string  value          Query String Param Value
 *
 * @since   {{VERSION}}
 * @return  string                 URL
 */
function updateURLParam( queryString, key, value ) {
    
    // remove the hash part before operating on the url
    var hashIndex = queryString.indexOf( '#' );
    var hash = hashIndex === -1 ? ''  : queryString.substr( hashIndex );
    queryString = hashIndex === -1 ? queryString : queryString.substr( 0, hashIndex );

    var re = new RegExp( "([?&])" + key + "=.*?(&|$)", "i" );
    
    var separator = queryString.indexOf( '?' ) !== -1 ? "&" : "?";
    
    if ( queryString.match( re ) && value !== '' ) {
        queryString = queryString.replace( re, '$1' + key + "=" + value + '$2' );
    }
    else if ( value.length == 0 ) {
        
        let temp = queryString.replace( re, '' );

        if ( temp.length == 0 ) {
            queryString = temp;
        }
        else {
            queryString = '?' + temp;
        }

    }
    else {
        queryString = queryString + separator + key + "=" + value;
    }
    
    return queryString + hash;

}

/**
 * Extracts a Query String from a URL
 *
 * @param   string  url  Full URL
 *
 * @since   {{VERSION}}
 * @return  string       Query String
 */
function getQueryString( url ) {

    let matches = url.match( /(\?.*)$/ );

    if ( matches == null ) return '';

    return matches[1];

}

export {
    getURLParam,
    updateURLParam,
    getQueryString
}