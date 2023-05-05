function filter_posts( category, base, themeVars ){
    jQuery(function($){
        $('.loading-container').addClass('loading');
        insertParam( 'category', category );

        $.ajax({
            url: themeVars.ajax.url,
            type: 'POST',
            data: {
                action: 'post_filter',
                nonce: themeVars.ajax.nonce,
                category: category,
                base: base,
            },
            dataType: 'json',
            success: function(res) {
                var result = res.data;
                //console.log(result);
                $('.posts-container').html(result.results);
                $('.paginate').html(result.paginate);
            }
        });
    });
}

function insertParam(key,value) {
    if (history.pushState) {
        var newUrl;
        if( value !== '' ) {
            newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname.split('/').slice(0,2).join('/') + '/?' + key + '=' + value;
        } else {
            newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname.split('/').slice(0,2).join('/') + '/';
        }
        window.history.replaceState({path:newUrl},'',newUrl);
    }
  }

(function($, themeVars) {

    $('body.blog .filter-container select').on( 'change', function(e){
        var category = $(this).val();
        var base = $(this).data('base');
        filter_posts( category, base, themeVars );
    });

})( jQuery, adapt_dev );