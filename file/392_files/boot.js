var DARLA,$sf,$yac;!function(){function t(t,e,r){var n=t||"",i=/\-min\.js$/gi,o=/\.html$/gi;return n&&(e&&-1!=n[M](oe)&&(n=n[I](oe,e)),r&&(-1!=n[M](i)?n=n[I](i,"-debug.js"):-1!=n[M](o)&&(n=n[I](o,"-debug.html")))),n}function e(e){var r=j,n;if(e){e[S]||(e[S]=Se),e[G]||(e[G]=Ge),e[Y]||(e[Y]=Ye),r=e.debug,n=e.lib_ver||"";try{n=n.match(oe)[0]}catch(i){n=""}e[S]=t(e[S],n,r),e[Y]=t(e[Y],n,r),e[G]=t(e[G],n,r)}}function r(t){var e=D,r,n;try{if(t&&typeof t==C)for(r in t){e=j;break}}catch(n){e=D}return e}function n(){de[k]={},de.firstPos=T,de.meta={},de[L]={},he={},ue={}}function i(){var t,e,r,n=0,i,o,a,c,s,h,u,d;for(t=g();e=t[n++];)if(r=e.id||"",r||(r="sf_tag_"+(new Date).getTime()+"_"+Math.round(100*Math.random()),e.id=r),!he[r]){try{e.setAttribute("type",x+"-processed")}catch(y){}if(he[r]=r,a=e.text||e.innerHTML||e.innerText||""){try{a=a[I](ne,"")[I](ie,""),c=new se("return "+a),a=c()}catch(o){c=a=T;continue}if(c=T,a)if(h=a[k]){for(i=0;s=h[i++];)u=s.id,u&&(ue[u]||(ue[u]=1,de[k][u]=s,de[k][u].dataTagID=r,de.firstPos||(de.firstPos=s)));a[L]&&(de[L]=f(de[L],a[L])),a.meta&&(de.meta=f(de.meta,a.meta))}else{if(u=a.id,!u)continue;if(ue[u])continue;d=a.html||a.src||"",d&&"string"==typeof d&&(ue[u]=1,de[k][u]=a,de[k][u].dataTagID=r,de.firstPos||(de.firstPos=a),a.baseConf&&(de[L]=f(de[L],a.baseConf)))}}}}function o(){var t;try{le&&!pe&&$sf.host.boot($e)}catch(t){s(531,t[H])}}function a(){try{$sf.host.onReady()}catch(t){}}function c(){var t=T,e,r,n;try{ae=window,t=Ae&&Ae.host,e=t&&t.boot,Ae=ae&&ae.$sf,Ae&&(_e=Ae.lib,t=le?t?t:Ae.host:T),_e&&(je=_e.lang,De=_e.dom,je&&(Te=je.cstr,xe=je.cnum,Pe=je.cbool)),le&&t&&(Le=t.Config,Re=t.PosConfig,Fe=t.PosMeta,qe=t.Position)}catch(n){r=j}return r!==j&&Ae&&_e&&t&&je&&De&&Te&&xe&&Le&&Re&&Fe&&qe?t&&e&&!t.boot&&(t.boot=_):Le=Re=Fe=qe=T,t}function s(t,e){try{_e&&_e.log&&_e.logger.note(t,e)}catch(r){}}function f(t,e,r){var n,i,o,a;if(t||(t={}),!e||typeof e!=C||e instanceof fe==j)return t;if(e.nodeType)return t;for(i in e)try{if(n=e[i],o=typeof n,o==C&&n&&(n=typeof t[i]==C&&t[i]?f(t[i],n,r):f({},n,r)),r&&i in t)continue;t[i]=n}catch(a){continue}return t}function h(){var t={},e,n,o,a,s,h;c();try{e=Ae&&Ae.host}catch(h){e=T}try{a=e&&e[L]}catch(h){a=T}try{s=e&&Le()}catch(h){s=T}try{n=ae.DARLA_CONFIG}catch(h){n=T}try{o=ae.$YAC_CONF}catch(h){o=T}return t=a?f(t,a,D):t,t=n?f(t,n,D):t,t=o?f(t,o,D):t,t=s?f(t,s,D):t,i(),t=f(t,de[L],D),r(t)&&(t=T),t}function u(t,e){var r=["<",te," type='text/java",te,"' src='",t,"'","","","","></",te,">"];return e&&(r[7]="id='",r[8]=e,r[9]="'"),r.join("")}function d(){}function y(t,e){var r=document;t=t||0,t&&s(t),le||(r.open("text/html","replace"),r.write("<!-- sf err (",t||0,") ",e||""," -->"),r.close()),r=T}function l(t){return t&&t.tagName&&t.tagName.toLowerCase()||""}function m(t){return t&&ce&&ce.getElementById(t)||T}function p(t){return t&&ce&&ce.getElementsByTagName(t)||[]}function g(){var t=T,e="querySelectorAll",r=0,n,i,o;if(ge===T)try{ge=e in document}catch(o){ge=j}if(ge)try{t=ce[e](te+"[type='"+x+"']")}catch(o){t=T}if(!t)for(n=p(te),t=[];i=n[r++];)i.type==x&&t.push(i);return t||[]}function v(){var t=m(re),e;if(t)try{b.call(t)}catch(e){s(532,e[H])}else s(533)}function b(){var t=this,e=j,r;l(t)!=te&&(t=m(re)),t&&(r=t.readyState,t[P]?("loaded"==r||"complete"==r)&&(e=D,t[P]=T):(e=D,t.onload=T),e&&(t=T,c(),Ae&&_e&&je&&De?(b=d,a(),_($e)):s(534)))}function w(){var t,r,n,i,a,f,u;if(!pe&&le)if(r=c(),u=!!Le,Ae||(ae.$sf=Ae={}),r||($sf.host=r={}),r.boot){if(De&&!be)try{be=D,De.wait(o)}catch(d){s(539,d[H])}}else if(r.boot=_,t=h()||{},e(t),n=t[S],u)_($e);else if(f=N in t&&t[N]===j||E in t&&t[E]===j?j:D,f=f&&!!n&&!ve,f&&(a=m(re),a&&l(a)==te&&a.src==n&&(f=j,ve=D)),f&&!ve)try{i=p("head")[0],a=ce.createElement(te),a.id=re,a.type="text/java"+te,a.className="sf_lib",ae.ActiveXObject?a[P]=b:a.onload=b,a.src=n,ve=D,setTimeout(v,J),i.appendChild(a)}catch(d){s(535,d[H])}}function $(t,e){var r=j,n=["hasError","hasErr","err","error"],i=0,o,a;if(t&&Pe){for(;o=n[i++];)if(o in t&&Pe(t[o])){r=D;break}r||e||(a=t.meta,a&&(r=$(a,D)))}return r}function A(t){var e=T,n=Ae&&Ae.ext,i,o,a,c,h,d,l,p,g,v,b;if(t)if(le){if(a=t.id){if(c=Re.item(a),c.id=a,c.pos=a,h=t[L],r(h)||(c=f(c,h,D),c.dest||(c.dest=h.dest||""),c.w||(c.w=h.w||0),c.h||(c.h=h.h||0),c=Re(c)),c&&(p=Te(c.dest),p||(p=de[k][a].dataTagID,p&&(c=Re(c,p)))),r(c))return void s(429,a);if(!p)return void s(430,a);if(d=m(p),!d)return void s(431,a);l=t.meta,l=r(l)?T:new Fe(l),o=new qe(t,T,l,c),e=o}}else{try{v=top.document}catch(g){v=T}if(i=t[B]||"",i=i||u(t.src),v||i&&!$(t))if(v||!me||ye)v?setTimeout(function(){y(514)},100):setTimeout(function(){y(537)},100);else{ye=D;try{$sf.host=T,delete $sf.host,qe=Re=Le=Fe=T}catch(g){}try{ce.write(i)}catch(g){}}else{if(n&&n.msg)try{n.msg("noad")}catch(g){}else try{v=document.referrer,v&&-1!=v[F]("http")?(b=v[F]("/",9),b=-1==b?v.length:b,v=v.substring(0,b)):v="",v.length>8&&top[X]("noad=1&id="+(t.id||t.pos||"unknown"),v)}catch(g){}setTimeout(function(){y(539)},100)}}else s(432);return e}function _(t){var n,a,c,f,u,d,y,l,p;if(!(!le||Ae&&je&&De))return s(542),j;if(pe)return s(538),j;if(le){if(d=h(),r(de[k])&&!be){be=D;try{De.wait(o)}catch(p){s(542,p[H])}return}d||(d={}),e(d),pe=D;try{d&&(d[U]||d[z]||(d[z]=He),d=Le(d))}catch(g){d=T}if(r(d)||!d[S])return d=T,pe=j,s(543),j;if(t===$e&&d&&(d[O]===j||d[N]===j))return void(pe=j);try{u=new DARLA.Response("prefetched",de.meta)}catch(p){return s(545,p[H]),void(pe=j)}f=de[k];for(a in f)if(n=f[a],c=A(n),c&&t===$e&&d[O]!==j&&d[N]!==j){try{u.add(c),n.r=1}catch(p){}if(l=m(n.dataTagID))try{l.setAttribute("type",x+"-booted")}catch(p){}}try{y=u.length()}catch(p){y=0,s(433,p[H])}if(y){try{Ae.host[R](u)}catch(p){s(540,p[H])}return D}if(we)return;if(we=d.init,we&&ae.DARLA&&(d[U]||d[z]))try{DARLA.event("sf_init",we)}catch(p){s(541,p[H])}}else i(),pe=D,A(de.firstPos);return D}var j=!1,D=!0,T=null,x="text/x-safeframe",P="onreadystatechange",C="object",L="conf",R="render",F="indexOf",q="position",I="replace",M="search",N="auto",E=N+"_lib",O=N+"_"+R,k=q+"s",B="html",S="hostFile",Y=R+"File",G="msgFile",H="message",U="servicePath",X="postMessage",z="x"+U,J=3e4,K="http://l.yimg.com/rq/darla",Q="https://s.yimg.com/rq/darla",V="2-9-2",W="http://l.yimg.com/rq/darla/2-9-2/js/g-r-min.js",Z="http://fc.yahoo.com/sdarla/php/fc.php",te="script",ee="sf_auto_"+function(){var t=new Date;return[t.getDay(),"-",t.getDate(),"-",t.getMonth(),"-",t.getFullYear()].join("")}(),re="sf_host_lib_"+ee,ne=/^\s\s*/,ie=/\s\s*$/,oe=/(\d+\-\d+\-\d+)|(9999)/,ae=window,ce=ae&&ae.document,se=Function,fe=Object,he={},ue={},de={},ye=j,le=j,me=j,pe=j,ge=T,ve=j,be=j,we=T,$e={},Ae,_e,je,De,Te,xe,Pe,Ce,Le,Re,Fe,qe,Ie,Me,Ne,Ee,Oe,ke,Be,Se,Ye,Ge,He;try{if(Me=ae.$sf&&$sf.host&&$sf.host.boot||T,Me&&"function"==typeof Me&&Me!=_)return void(ae[ee]=D);if(ee in ae)return;ae[ee]=D}catch(Ie){return void s(541)}Ne=K,Ee=Q,Be=V,Se=W,He=Z,Ne&&0==Ne[F]("http:")||(Ne="http://l.yimg.com/rq/darla/"),Ee&&0==Ee[F]("https:")||(Ee="https://s.yimg.com/rq/darla/"),Be&&-1!=Be[M](oe)||(Be="2-8-4"),He&&-1!=He[F]("http")||(He="http://fc.yahoo.com/sdarla/php/fc.php");try{Ce=ce.URL||location.href}catch(Ie){Ce=""}0==Ce[F]("https:")&&(Ne=Ee,He=He[I](/^http\:/i,"https:")),Oe=Ne+"/"+Be,ke=Oe+"/"+B,Se&&-1!=Se[F](".js")||(Se=Oe+"/js/g-r-min.js");try{le=!(ae!=top)}catch(Ie){le=j}if(Ye=ke+"/r-sf."+B,Ge=ke+"/msg."+B,le===j)try{me=!(ae.parent!=top)}catch(Ie){me=j}n(),le?(c(),w()):me?(c(),_()):s(541)}();