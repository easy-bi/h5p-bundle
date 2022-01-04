(function ($) {
    $(document).ready(function() {
        if(H5P.$window[0]) {
            setTimeout(function(){
                (function interval() {
                    window.parent.postMessage({
                        height: H5P.$window[0].frames[0].innerHeight,
                        location: window.location.href,
                    }, "*");
                    setTimeout(interval, 40);
                })();
            }, 1000);
        }

        H5PIntegration.saveFreq = true;
    });
})(H5P.jQuery);