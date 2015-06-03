(function () {
  'use strict';

  // load options
  var options = (typeof cn_options === 'undefined') ? { site: 'https://www.thedailymeal.com', 'jquery': true } : cn_options, jquery_ready;
  if (!options.site) { options.site = 'https://www.thedailymeal.com'; }
  if (!options.jquery) { options.jquery = true; }
  if (!options.type) { options.type = 'default'; }
  if (!options.top) { options.top = 0; }
  if (!options.blog) { options.blog = 'default'; }

  // jquery
  if (options.jquery) {
    tdm_ccn_load('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', 'js');
  }

  tdm_ccn_load('https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js','js');

  // load analytics
  //tdm_ccn_load('http://images.thedailymeal.net/sites/all/themes/thedailymeal/js/tdm_analytics.js', 'js');

  // start checking until jquery is loaded
  jquery_ready = setInterval(function () {
    if (typeof jQuery !== 'undefined') {
      clearInterval(jquery_ready);
      tdm_ccn_start(jQuery, options.site + '/content-network',options);
    }
  }, 200);

})();

/**
 * Function to load the js/css
 *
 * @param path
 * @param type
 */
function tdm_ccn_load(path, type) {
  'use strict';
  var head = document.getElementsByTagName('head')[0],
  script, style;
  switch (type) {
    case 'js' :
      script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = path;
      head.insertBefore(script, head.lastChild);
      break;
    case 'css' :
      style = document.createElement('link');
      style.rel = 'stylesheet';
      style.type = 'text/css';
      style.href = path;
      head.insertBefore(style, head.lastChild);
      break;
  }
}

/**
 *
 */
function tdm_ccn_start($, url, options) {
  'use strict';

  //ajax fallback for IE8+9
  if ( window.XDomainRequest && !$.support.cors ) {
    $.ajaxTransport(function( s ) {
      if ( s.crossDomain && s.async ) {
        if ( s.timeout ) {
          s.xdrTimeout = s.timeout;
          delete s.timeout;
        }
        var xdr;
        return {
          send: function( _, complete ) {
            function callback( status, statusText, responses, responseHeaders ) {
              xdr.onload = xdr.onerror = xdr.ontimeout = xdr.onprogress = $.noop;
              xdr = undefined;
              $.event.trigger( "ajaxStop" );
              complete( status, statusText, responses, responseHeaders );
            }
            xdr = new XDomainRequest();
            xdr.open( s.type, s.url );
            xdr.onload = function() {
              var status = 200,
              message = xdr.responseText,
              r = JSON.parse(xdr.responseText);
              if (r.StatusCode && r.Message) {
                status = r.StatusCode;
                message = r.Message;
              }
              callback( status , message, { text: message }, "Content-Type: " + xdr.contentType );
            };
            xdr.onerror = function() {
              callback( 500, "Unable to Process Data" );
            };
            xdr.onprogress = function() {};
            if ( s.xdrTimeout ) {
              xdr.ontimeout = function() {
                callback( 0, "timeout" );
              };
              xdr.timeout = s.xdrTimeout;
            }
            xdr.send( ( s.hasContent && s.data ) || null );
          },
          abort: function() {
            if ( xdr ) {
              xdr.onerror = $.noop();
              xdr.abort();
            }
          }
        };
      }
    });
  }

  $(document).ready(function(){
    $.ajax({
      type    : 'POST',
      data    : {type:options.type,top:options.top,blog:options.blog},
      dataType: 'json',
      url     : url,
      success : function (response) {
        var i, j;
        if (!response.status) {
          return false;
        }
        // css
        for (i in response.css) {
          tdm_ccn_load(response.css[i], 'css');
        }
        // js
        for (j in response.js) {
          tdm_ccn_load(response.js[j], 'js');
        }
        // on load
        if(options.type == 'default'){
          $('body').prepend('<div class="content-network-widget">' + response.content + '</div>');  
        }else{
          $('body').prepend('<div class="content-network-widget-right">' + response.content + '</div>');  
        }
        $('body').append('<div class="content-network-widget-mobile">' + response.content_bottom + '</div>');  
        
      },
      complete: function () {
        // on complete action
      }
    });
  });
}

