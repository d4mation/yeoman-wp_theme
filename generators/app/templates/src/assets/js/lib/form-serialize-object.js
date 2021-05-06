/**
 * This gives us data from a form in a way that $.ajax can handle a bit better
 *
 * @param   array  serializeArray  Array of Objects from $( form ).serializeArray()
 *
 * @since   {{VERSION}}
 * @return  object                 Object representation of the same data
 */
var formSerializeObject = function( serializeArray ) {

    let data = {};

    for ( var index in serializeArray ) {
        data[ serializeArray[ index ].name ] = serializeArray[ index ].value;
    }

    return data;

}

export {
    formSerializeObject
};