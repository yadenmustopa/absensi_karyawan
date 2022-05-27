const jquery = require("jquery");

function scrollTopPage(){
    let main_content = jquery(".main-content");
    let scroll =  jquery("main .ps__rail-y");

    main_content.animate({ scrollTop: 0 }, "slow");
    
}

module.exports = scrollTopPage;