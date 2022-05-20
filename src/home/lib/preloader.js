import jquery from "jquery";

/**
 * 
 *
 */
const preloader = {
    show : function(){
        jquery("body").prepend(` <div class="preloader">
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
`)
    },
    hide : function(){
        
        jquery(".preloader").remove().fadeOut("slow");
    }
}

export default preloader;