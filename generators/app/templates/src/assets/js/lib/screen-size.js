
import { Foundation } from './foundation';

/**
 * Return the reported screen size from Foundation
 *
 * @since   {{VERSION}}
 * @return  string  Screen Size
 */
function getScreenSize() {

    let size = false;

    if ( Foundation.MediaQuery ) {
        
        if ( Foundation.MediaQuery.current.match( '-only' ) ) {
            return true;
        }
        
        if ( window.matchMedia( Foundation.MediaQuery.get( Foundation.MediaQuery.current ) ) ) {
            size = Foundation.MediaQuery.current;
        }
        
    }

    return size;

}

export {
    getScreenSize
}