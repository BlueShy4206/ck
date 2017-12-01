
if (p.length > 0)
{
    'use strict';
    !function(d, init){
        if( !self.seajs ){

            var script = d.createElement('script')

            script.src = '//img.scupio.com/ec/Image/gadt/sea.js';
            script.id = 'seajsnode';

            d.getElementsByTagName('head')[0].appendChild( script );
    
            if( script.readyState ){

                script.onreadystatechange = function(){ 
        
                    if ( /^(loaded|complete)$/.test( script.readyState.toLowerCase() ) ) { 
                        script.onreadystatechange = null; 
                        init(); 
                    } 
                }

            }else{
                script.onload = init;
            }
    
        }else{
            init();
        }
  
    }(document, function(){  

        define("scupio_rec_products", function(require, exports, module) {
            for (var i = 0 ; i < p[0].length ; i ++)
                p[0][i].clickurl = option == '' ? p[0][i].clickurl : option + escape(p[0][i].clickurl);

            var products = p;
            var logoUrl = mo.LogoClickURL;
            var bannerUrl = mo.BannerClickURL;
            module.exports.p=products[0];            
            module.exports.logoUrl = logoUrl;
            module.exports.bannerUrl = bannerUrl;
            module.exports.d = "000";
            
        });        

        seajs
          .config({
              preload : [
                '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'
              ]
          })
          .use('//img.scupio.com/ec/mallimg/RTBMallBanner/JSBanner/MallJS_' + p[0][0].itemMallid + '/300X250/main')
    });
}