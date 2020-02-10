<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use frontend\assets\WnlAsset;
use frontend\widgets\SideBoxListWidget;
use yii\widgets\Breadcrumbs;

$this->title = '查询黄历';
$links = [];
$links[] = ['label' => '<li class="active"><span>&gt;</span></li>'];
$links[] = ['label' => $this->title];

WnlAsset::register($this);
$jsBaseUrl = Yii::$app->getAssetManager()->bundles[WnlAsset::class]->baseUrl;

$jsWnlBaseUrl = $jsBaseUrl.'/js/wnl.js';
$jsDataBaseUrl = $jsBaseUrl.'/js/lhl/';//Yii::$app->request->hostInfo.
//echo $jsDataBaseUrl;exit;
?>

<script>var TIME = {_: +new Date},newMinotor=1,So = {"comm":{"abv":"c","domain":"www.haosou.com","guid":"F665C375D00A4D05AEC63EEBE01F3C62.1420510460624","hasTantan":1,"isWarn":0,"isCtrl":0,"pid":"www","pn":1,"q":"\u65e5\u5386","pq":"\u65e5\u5386API","src":"srp","sug":1,"t":1440992461984,"ssurl":"https:\/\/p.ssl.haosou.com\/p\/","user":{"qid":"","imageId":"","showName":""},"monitor":{"ls":"0","qt":"77a2bcdb32614861","rf":"","sid":"8f8eac4c87d4327dda718b433abdc611","version":"1.3.3","cq":"","tg":0}},"web":{},"page":{"reload":[],"unload":[]},"onebox":{},"e":{}};</script>
<script>(function(e,t,n){var r=e.decodeURIComponent,i=e.location,s={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"},o={amp:"&",lt:"<",gt:">",quot:'"',"#039":"'"},u={trim:function(e){return e.replace(/^[\s]+|[\s]+$/,"")},startsWith:function(e,t){return e.indexOf(t)===0},endsWith:function(e,t){return e.lastIndexOf(t)===e.length-t.length},contains:function(e,t){return e.indexOf(t)!==-1},escapeHTML:function(e){return typeof e!="string"?e:e.replace(/([<>'"])/g,function(e,t){return s[t]})},unescapeHTML:function(e){return typeof e!="string"?e:e.replace(/&(amp|lt|gt|quot|#039);/g,function(e,t){return o[t]})},parseQuery:function(e){if(e){var t=e.indexOf("?");t!=-1&&(e=e.substr(t+1))}e=e||i.search.substr(1);var n=e.split("&"),s={};for(var o=n.length-1,u,a,f;o>=0;o--){u=n[o].split("="),a=u[0],f=u[1];try{a=r(a),f=r(f)}catch(l){}s[a]=f}return s}};So.lib=u})(window,document),function(e){e.cookie=function(){function e(e,n){var r={};if(t(e)&&e.length>0){var s=n?o:i,u=e.split(/;\s/g),a,f,l;for(var c=0,h=u.length;c<h;c++){l=u[c].match(/([^=]+)=/i);if(l instanceof Array)try{a=o(l[1]),f=s(u[c].substring(l[1].length+1))}catch(p){}else a=o(u[c]),f="";a&&(r[a]=f)}}return r}function t(e){return typeof e=="string"}function n(e){return t(e)&&e!==""}function r(e){if(!n(e))throw new TypeError("Cookie name must be a non-empty string")}function i(e){return e}var s={},o=decodeURIComponent,u=encodeURIComponent;return s.get=function(t,n){r(t),typeof n=="function"?n={converter:n}:n=n||{};var s=e(document.cookie,!n.raw);return(n.converter||i)(s[t])},s.set=function(e,t,i){r(e),i=i||{};var s=i.expires,o=i.domain,a=i.path;i.raw||(t=u(String(t)));var f=e+"="+t,l=s;return typeof l=="number"&&(l=new Date,l.setTime(l.getTime()+s)),l instanceof Date&&(f+="; expires="+l.toUTCString()),n(o)&&(f+="; domain="+o),n(a)&&(f+="; path="+a),i.secure&&(f+="; secure"),document.cookie=f,f},s.remove=function(e,t){return t=t||{},t.expires=new Date(0),this.set(e,"",t)},s}()}(So.lib),function(e,t,n){function r(t,n,r){var i={pro:"so",pid:So.comm.pid||"",mod:t,abv:So.comm.abv||"",src:So.comm.src||""};if(n)for(prop in n)i[prop]=n[prop];e.monitor&&monitor.setConf("logUrl","//s.qhupdate.com/"+r+".gif").log(i,"log")}var i=e.decodeURIComponent,s=e.location;n.log=function(e,t,n){r(e,t,n||"so/click")},n.disp=function(e,t,n){r(e,t,n||"so/disp")},n.addCss=function(e){if(document.createStyleSheet){var t=document.createStyleSheet();t.cssText=e}else{var n=document.createElement("style");n.type="text/css",n.appendChild(document.createTextNode(e)),document.getElementsByTagName("HEAD")[0].appendChild(n)}},n.template=function(e,t){var n=new Function("obj","var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('"+e.replace(/[\r\t\n]/g," ").split("<%").join("	").replace(/((^|%>)[^\t]*)'/g,"$1\r").replace(/\t=(.*?)%>/g,"',$1,'").split("	").join("');").split("%>").join("p.push('").split("\r").join("\\'")+"');}return p.join('');");return t?n(t):n},n.sslReplace=function(e){return e?s.protocol=="https:"?e.replace(/http:\/\/p\d+\.qhimg\.com\//g,"https://p.ssl.qhimg.com/").replace(/http:\/\/u\.qhimg\.com\//g,"https://u.ssl.qhimg.com/").replace(/http:\/\/u1\.qhimg\.com\//g,"https://u1.ssl.qhimg.com/").replace(/http:\/\/p\d+\.so\.qhimg\.com\//g,"https://ps.ssl.qhimg.com/").replace(/http:\/\/s\d+\.qhimg\.com\//g,"https://s.ssl.qhimg.com/").replace(/http:\/\/quc\.qhimg\.com\//g,"https://quc.ssl.qhimg.com/"):e.replace(/http:\/\/s[02468]\.qhimg\.com\//g,"https://s.ssl.qhimg.com/").replace(/http:\/\/s[13579]\.qhimg\.com\//g,"https://s.ssl.qhimg.com/").replace(/http:\/\/p[02468]\.qhimg\.com\//g,"https://p.ssl.qhimg.com/").replace(/http:\/\/p[13579]\.qhimg\.com\//g,"https://p.ssl.qhimg.com/").replace(/http:\/\/p\d{2}\.qhimg\.com\//g,"https://p.ssl.qhimg.com/"):e},n.soLocalStorage=!1;try{n.soLocalStorage=window.localStorage}catch(o){}n.browser={};var u=t.documentElement.className||"",a=u.match(/\bie(\d+)\b/i);a&&(n.browser={ie:!0,version:a[1]})}(window,document,So.lib),function(win,doc,undefined){window.JSON=window.JSON||function(){var m={"\b":"\\b","	":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},s={"boolean":function(e){return String(e)},number:function(e){return isFinite(e)?String(e):"null"},string:function(e){return/["\\\x00-\x1f]/.test(e)&&(e=e.replace(/([\x00-\x1f\\"])/g,function(e,t){var n=m[t];return n?n:(n=t.charCodeAt(),"\\u00"+Math.floor(n/16).toString(16)+(n%16).toString(16))})),'"'+e+'"'},object:function(e){if(e){var t=[],n,r,i,o,u;if(e instanceof Array){t[0]="[",o=e.length;for(i=0;i<o;i+=1)u=e[i],r=s[typeof u],r&&(u=r(u),typeof u=="string"&&(n&&(t[t.length]=","),t[t.length]=u,n=!0));t[t.length]="]"}else{if(!(e instanceof Object))return;t[0]="{";for(i in e)u=e[i],r=s[typeof u],r&&(u=r(u),typeof u=="string"&&(n&&(t[t.length]=","),t.push(s.string(i),":",u),n=!0));t[t.length]="}"}return t.join("")}return"null"}};return{copyright:"(c)2005 JSON.org",license:"http://www.crockford.com/JSON/license.html",stringify:function(e){var t=s[typeof e];if(t){e=t(e);if(typeof e=="string")return e}return null},parse:function(text){try{return!/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(text.replace(/"(\\.|[^"\\])*"/g,""))&&eval("("+text+")")}catch(e){return!1}}}}()}(window,document),So.lib.md5=function(){function e(e,t){var n=(e&65535)+(t&65535),r=(e>>16)+(t>>16)+(n>>16);return r<<16|n&65535}function t(e,t){return e<<t|e>>>32-t}function n(n,r,i,s,o,u){return e(t(e(e(r,n),e(s,u)),o),i)}function r(e,t,r,i,s,o,u){return n(t&r|~t&i,e,t,s,o,u)}function i(e,t,r,i,s,o,u){return n(t&i|r&~i,e,t,s,o,u)}function s(e,t,r,i,s,o,u){return n(t^r^i,e,t,s,o,u)}function o(e,t,r,i,s,o,u){return n(r^(t|~i),e,t,s,o,u)}function u(t,n){t[n>>5]|=128<<n%32,t[(n+64>>>9<<4)+14]=n;var u,a,f,l,c,h=1732584193,p=-271733879,d=-1732584194,v=271733878;for(u=0;u<t.length;u+=16)a=h,f=p,l=d,c=v,h=r(h,p,d,v,t[u],7,-680876936),v=r(v,h,p,d,t[u+1],12,-389564586),d=r(d,v,h,p,t[u+2],17,606105819),p=r(p,d,v,h,t[u+3],22,-1044525330),h=r(h,p,d,v,t[u+4],7,-176418897),v=r(v,h,p,d,t[u+5],12,1200080426),d=r(d,v,h,p,t[u+6],17,-1473231341),p=r(p,d,v,h,t[u+7],22,-45705983),h=r(h,p,d,v,t[u+8],7,1770035416),v=r(v,h,p,d,t[u+9],12,-1958414417),d=r(d,v,h,p,t[u+10],17,-42063),p=r(p,d,v,h,t[u+11],22,-1990404162),h=r(h,p,d,v,t[u+12],7,1804603682),v=r(v,h,p,d,t[u+13],12,-40341101),d=r(d,v,h,p,t[u+14],17,-1502002290),p=r(p,d,v,h,t[u+15],22,1236535329),h=i(h,p,d,v,t[u+1],5,-165796510),v=i(v,h,p,d,t[u+6],9,-1069501632),d=i(d,v,h,p,t[u+11],14,643717713),p=i(p,d,v,h,t[u],20,-373897302),h=i(h,p,d,v,t[u+5],5,-701558691),v=i(v,h,p,d,t[u+10],9,38016083),d=i(d,v,h,p,t[u+15],14,-660478335),p=i(p,d,v,h,t[u+4],20,-405537848),h=i(h,p,d,v,t[u+9],5,568446438),v=i(v,h,p,d,t[u+14],9,-1019803690),d=i(d,v,h,p,t[u+3],14,-187363961),p=i(p,d,v,h,t[u+8],20,1163531501),h=i(h,p,d,v,t[u+13],5,-1444681467),v=i(v,h,p,d,t[u+2],9,-51403784),d=i(d,v,h,p,t[u+7],14,1735328473),p=i(p,d,v,h,t[u+12],20,-1926607734),h=s(h,p,d,v,t[u+5],4,-378558),v=s(v,h,p,d,t[u+8],11,-2022574463),d=s(d,v,h,p,t[u+11],16,1839030562),p=s(p,d,v,h,t[u+14],23,-35309556),h=s(h,p,d,v,t[u+1],4,-1530992060),v=s(v,h,p,d,t[u+4],11,1272893353),d=s(d,v,h,p,t[u+7],16,-155497632),p=s(p,d,v,h,t[u+10],23,-1094730640),h=s(h,p,d,v,t[u+13],4,681279174),v=s(v,h,p,d,t[u],11,-358537222),d=s(d,v,h,p,t[u+3],16,-722521979),p=s(p,d,v,h,t[u+6],23,76029189),h=s(h,p,d,v,t[u+9],4,-640364487),v=s(v,h,p,d,t[u+12],11,-421815835),d=s(d,v,h,p,t[u+15],16,530742520),p=s(p,d,v,h,t[u+2],23,-995338651),h=o(h,p,d,v,t[u],6,-198630844),v=o(v,h,p,d,t[u+7],10,1126891415),d=o(d,v,h,p,t[u+14],15,-1416354905),p=o(p,d,v,h,t[u+5],21,-57434055),h=o(h,p,d,v,t[u+12],6,1700485571),v=o(v,h,p,d,t[u+3],10,-1894986606),d=o(d,v,h,p,t[u+10],15,-1051523),p=o(p,d,v,h,t[u+1],21,-2054922799),h=o(h,p,d,v,t[u+8],6,1873313359),v=o(v,h,p,d,t[u+15],10,-30611744),d=o(d,v,h,p,t[u+6],15,-1560198380),p=o(p,d,v,h,t[u+13],21,1309151649),h=o(h,p,d,v,t[u+4],6,-145523070),v=o(v,h,p,d,t[u+11],10,-1120210379),d=o(d,v,h,p,t[u+2],15,718787259),p=o(p,d,v,h,t[u+9],21,-343485551),h=e(h,a),p=e(p,f),d=e(d,l),v=e(v,c);return[h,p,d,v]}function a(e){var t,n="";for(t=0;t<e.length*32;t+=8)n+=String.fromCharCode(e[t>>5]>>>t%32&255);return n}function f(e){var t,n=[];n[(e.length>>2)-1]=undefined;for(t=0;t<n.length;t+=1)n[t]=0;for(t=0;t<e.length*8;t+=8)n[t>>5]|=(e.charCodeAt(t/8)&255)<<t%32;return n}function l(e){return a(u(f(e),e.length*8))}function c(e,t){var n,r=f(e),i=[],s=[],o;i[15]=s[15]=undefined,r.length>16&&(r=u(r,e.length*8));for(n=0;n<16;n+=1)i[n]=r[n]^909522486,s[n]=r[n]^1549556828;return o=u(i.concat(f(t)),512+t.length*8),a(u(s.concat(o),640))}function h(e){var t="0123456789abcdef",n="",r,i;for(i=0;i<e.length;i+=1)r=e.charCodeAt(i),n+=t.charAt(r>>>4&15)+t.charAt(r&15);return n}function p(e){return unescape(encodeURIComponent(e))}function d(e){return l(p(e))}function v(e){return h(d(e))}function m(e,t){return c(p(e),p(t))}function g(e,t){return h(m(e,t))}return function(e,t,n){return t?n?m(t,e):g(t,e):n?d(e):v(e)}}();var PageLine={queues:{release:[]},fill:function(e){var t=this;t.save(e)},save:function(e){var t=null,n=this;typeof e!="function"?t=function(){Display.moheLog(e)}:t=e,n.queues.release.push(t),n.isReleased&&n.release("release")},on:function(e,t){var n=this;n.queues[e]||(n.queues[e]=[]),typeof t=="function"&&n.queues[e].push(t)},trigger:function(e,t){var n=this,r=0,i=[];if(!n.queues[e])return!1;i=n.queues[e];while(r<i.length)i[r].call(this,t),r++},release:function(e){function t(){var e=r.shift();e&&typeof e=="function"&&e();if(r.length<=0)return n.isReleased=!0,!1;t()}var n=this,r=n.queues[e];if(!r)return!1;t()}};(function(e){function t(e,t){var n=document,r=n.getElementsByTagName("head")[0]||n.documentElement,i=n.createElement("script"),s=!1;i.src=e,i.onerror=i.onload=i.onreadystatechange=function(){!s&&(!this.readyState||this.readyState=="loaded"||this.readyState=="complete")&&(s=!0,t&&t(),i.onerror=i.onload=i.onreadystatechange=null,r.removeChild(i))},r.insertBefore(i,r.firstChild)}function n(e){var t,n,r,i;for(t=0;t<l.length;t++){r=l[t],i=r.requires;for(n=0;n<i.length;n++)if(i[n]==e)break;i.splice(n,1),i.length===0&&(r.fun(),l.splice(t,1))}}function r(){var e=f.splice(0,1)[0],i=a[e],s=function(){n(e),i.loaded=!0,f.length?r():c=!1};if(!i)return;c=!0,i.loaded||i.checker&&i.checker()?s(e):t(i.url,function(){s(e)})}var i={};e.OB=i,i.Browser=function(){var t=e.navigator,n=t.userAgent.toLowerCase(),r=/(msie|webkit|gecko|presto|opera|safari|firefox|chrome|maxthon|android|ipad|iphone|webos|hpwos)[ \/os]*([\d_.]+)/ig,i={platform:t.platform};n.replace(r,function(e,t,n){var r=t.toLowerCase();i[r]||(i[r]=n)}),i.opera&&n.replace(/opera.*version\/([\d.]+)/,function(e,t){i.opera=t});if(i.msie){i.ie=i.msie;var s=parseInt(i.msie,10);i["ie"+s]=!0}return i}();if(i.Browser.ie)try{document.execCommand("BackgroundImageCache",!1,!0)}catch(s){}var o=i.Browser,u={ready:function(e,t){function n(){clearTimeout(t.__QWDomReadyTimer);if(r.length){var e=r.shift();r.length&&(t.__QWDomReadyTimer=setTimeout(n,0)),e()}}t=t||document;var r=t.__QWDomReadyCbs=t.__QWDomReadyCbs||[];r.push(e),setTimeout(function(){if(/complete/.test(t.readyState))n();else if(t.addEventListener)"interactive"==t.readyState?n():t.addEventListener("DOMContentLoaded",n,!1);else{var e=function(){e=new Function,n()};(function(){try{t.body.doScroll("left")}catch(n){return setTimeout(arguments.callee,1)}e()})(),t.attachEvent("onreadystatechange",function(){"complete"==t.readyState&&e()})}},0)}};i.DomU=u;var a={jquery:{url:"./js/183.js",checker:function(){return!!e.jQuery}},"require.2.1.11":{url:"https://s.ssl.qhimg.com/!5a33324b/require.js",checker:function(){return!!e.require&&!!e.define}}},f=[],l=[],c=!1;e._loader={add:function(e,t,n){a[e]||(a[e]={url:t,checker:n})},use:function(e,t){i.DomU.ready(function(){e=e.split(/\s*,\s*/g),f=f.concat(e),l.push({requires:e,fun:t}),c||r()})},remove:function(e){a[e]&&delete a[e]}}})(window),function(){var e=document.documentElement,t=function(e,t){var n=document.getElementsByTagName("head")[0],r=null;document.createStyleSheet?(r=document.createStyleSheet(),r.addRule(e,t)):(r=document.createElement("style"),r.type="text/css",r.innerHTML=e+"{"+t+"}",n.appendChild(r))},n=1200;e.clientWidth>n&&t("#side","width:410px;left:195px;")}(),window.hd_init=function(){var e=function(e,t,n){var r,i={};t=t||{};for(r in e)i[r]=e[r],t[r]!=null&&(n?e.hasOwnProperty[r]&&(i[r]=t[r]):i[r]=t[r]);return i},t=function(e){return document.getElementById(e)},n=function(e,t,n){e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent?e.attachEvent("on"+t,n):e["on"+t]=n},r=function(e){return e||window.event},i=function(e){return e.target||e.srcElement},s={check:function(){var e=this,t=!1;try{switch(external.smartwiz()*1){case 0:s.render(0);break;case 1:s.render(1,"");break;case 2:s.render(1,"isXdu");break;case 3:s.render(1,"haslogo")}}catch(n){try{var r=external.GetSID(window),i=parseInt(external.GetVersion(r).split(".").join(""),10);external.AppCmd(external.GetSID(window),"","getsearchbarstatus","","",s.render)}catch(n){s.render(0)}return}},render:function(e,t){var n=this,r="",i=null,o=!1,u=document.getElementsByTagName("head")[0];document.cookie.indexOf("ED351A52-EE52-47f8-8616-3355B59424C1")>=0&&(o=!0),e==1||o?(r=document.getElementsByTagName("body")[0].className,r+=t==""?" g-hide-hd":" g-hide-all",document.getElementsByTagName("body")[0].className=r):(s.insertStyle("#g-hd","display:block"),e!=2&&s.insertStyle("#g-hd-searchs","display:block"))},insertStyle:function(e,t){var n=document.getElementsByTagName("head")[0],r=null;document.createStyleSheet?(r=document.createStyleSheet(),r.addRule(e,t)):(r=document.createElement("style"),r.type="text/css",r.innerHTML=e+"{"+t+"}",n.appendChild(r))}};return function(o){o=e({inputId:"keyword",getValue:null},o);var u=t("g-hd"),a=t(o.inputId),f=function(){return typeof o.getValue=="function"?o.getValue():a?a.value.replace(/^\s+|\s+$/g,""):""},l=f();if(u){var c=t("g-hd-more-title"),h=t("g-hd-more-div");if(c&&h){var p=function(e){if(e.relatedTarget)return e.relatedTarget;var t=e.fromElement,n=e.target||e.srcElement,r=t===n?e.toElement:t;return r},d=function(e,t){if(e.contains)return e.contains(t);if(e.compareDocumentPosition)return e.compareDocumentPosition(t)&16;while(t=t.parentNode)if(t==e)return!0;return!1},v=function(e,t){function i(t){t=r(t);var n=p(t);if(!n||n!==e&&!d(e,n))t.type=="mouseover"?s(arguments):o(arguments)}t=t||{};var s=t.enter||function(){},o=t.leave||function(){},u="onmouseenter"in document.createElement("div");if(u){n(e,"mouseenter",s),n(e,"mouseleave",o);return}n(e,"mouseover",i),n(e,"mouseout",i)},m=function(){clearTimeout(g),g=setTimeout(function(){h.style.display=""},300)},g,y=function(){clearTimeout(g),g=setTimeout(function(){h.style.display="none"},300)},b=[c,h];for(var w=0;w<b.length;w++){var E=b[w];v(E,{enter:m,leave:y})}}var S=function(e){try{e=r(e);var t=i(e);if(t&&t.tagName&&t.tagName.toUpperCase()==="A"){var n=t.getAttribute("data-s"),s=f();n&&(a&&(t.getAttribute("data-home")||t.setAttribute("data-home",t.href),s?t.href=n.replace(/%q%/g,encodeURIComponent(s)):t.href=t.getAttribute("data-home")),d(h,t)&&(h.style.display="none"))}}catch(o){}};function x(){var e=u.getElementsByTagName("A"),t=document.getElementById("mod-engs").getElementsByTagName("A"),n=[],r="";for(var i=0,s=e.length;i<s;i++){r=e[i].getAttribute("data-s");if(!r)continue;r=r.replace("%q%",encodeURIComponent(l)),e[i].setAttribute("href",r),n.push(e[i])}for(var i=0,s=t.length;i<s;i++){r=t[i].getAttribute("data-s");if(!r)continue;r=r.replace("%q%",encodeURIComponent(l)),t[i].setAttribute("href",r),n.push(t[i])}}s.check(),x(),n(u,"click",S);var T=t("g-hd-searchs");T&&n(T,"click",S)}}}()</script>

<div class="calendar-index">
    <div class="container">
        <div class="breadcrumb-box clearfix">
            <span class="location"><b>当前位置：</b></span>
            <?= Breadcrumbs::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'pagination clearfix'],
                'tag' => 'ul',
                'homeLink' => null,
                'itemTemplate' => "<li>{link}</li>\n",
                //'activeItemTemplate' => "<li class=\"active\">{link}</li>\n",
                'links' => $links,
            ]) ?>
        </div>

        <div class="turen-box m2s clearfix">
            <div class="midcontent">
                <div class="detail-text card">
                    <div class="detail-title">
                        <h3>吉日查询</h3>
                        <p class="">亚桥租赁，一站式高空作业服务。</p>
                    </div>
                    <div class="detail-content">
                        <div class="wnl-tool">
                            <!-- BEGIN #main -->
                            <div id="main">
                                <div id="so_top"></div>
                                <ul id="m-result" class="result">
                                    <li id="first" class="res-list">
                                        <div id="mohe-rili" class="g-mohe"  data-mohe-type="rili">
                                            <div class="mh-rili-wap mh-rili-only " data-mgd='{"b":"rili-body"}'>
                                                <div class="mh-tips">
                                                    <div class="mh-loading">
                                                        <i class="mh-ico-loading"></i>正在为您努力加载中...
                                                    </div>
                                                    <div class="mh-err-tips">亲，出了点问题~ 您可<a href="#reload" class="mh-js-reload">重试</a></div>
                                                </div>
                                                <div class="mh-rili-widget">
                                                    <div class="mh-doc-bd mh-calendar">
                                                        <div class="mh-hint-bar gclearfix">
                                                            <div class="mh-control-bar">
                                                                <div class="mh-control-module mh-year-control mh-year-bar">
                                                                    <a href="#prev-year" action="prev" class="mh-prev" data-md='{"p":"prev-year"}'></a>
                                                                    <div class="mh-control">
                                                                        <i class="mh-trigger"></i>
                                                                        <div class="mh-field mh-year" val=""></div>
                                                                    </div>
                                                                    <a href="#next-year" action="next" class="mh-next" data-md='{"p":"next-year"}'></a>
                                                                    <ul class="mh-list year-list" style="display:none;" data-md='{"p":"select-year"}'></ul>
                                                                </div>
                                                                <div class="mh-control-module mh-month-control mh-mouth-bar">
                                                                    <a href="#prev-month" action="prev" class="mh-prev" data-md='{"p":"prev-month"}'></a>
                                                                    <div class="mh-control">
                                                                        <i class="mh-trigger"></i>
                                                                        <div class="mh-field mh-month" val=""></div>
                                                                    </div>
                                                                    <a href="#next-month" action="next" class="mh-next" data-md='{"p":"next-month"}'></a>
                                                                    <ul class="mh-list month-list" style="display:none;" data-md='{"p":"select-month"}'></ul>
                                                                </div>
                                                                <div class="mh-control-module mh-holiday-control mh-holiday-bar">
                                                                    <div class="mh-control">
                                                                        <i class="mh-trigger"></i>
                                                                        <div class="mh-field mh-holiday"></div>
                                                                    </div>
                                                                    <ul class="mh-list" style="display:none;" data-md='{"p":"select-holiday"}'></ul>
                                                                </div>
                                                                <div class="mh-btn-today" data-md='{"p":"btn-today"}'>返回今天</div>
                                                            </div>
                                                            <div class="mh-time-panel">
                                                                <dl class="gclearfix">
                                                                    <dt class="mh-time-monitor-title">北京时间:</dt>
                                                                    <dd class="mh-time-monitor"></dd>
                                                                </dl>
                                                            </div>
                                                        </div>
                                                        <div class="mh-cal-main">
                                                            <div class="mh-col-1 mh-dates">
                                                                <ul class="mh-dates-hd gclearfix">
                                                                    <li class="mh-days-title">星期一</li>
                                                                    <li class="mh-days-title">星期二</li>
                                                                    <li class="mh-days-title">星期三</li>
                                                                    <li class="mh-days-title">星期四</li>
                                                                    <li class="mh-days-title">星期五</li>
                                                                    <li class="mh-days-title mh-weekend">星期六</li>
                                                                    <li class="mh-days-title mh-last mh-weekend">星期日</li>
                                                                </ul>
                                                                <ol class="mh-dates-bd gclearfix"></ol>
                                                            </div>
                                                            <div class="mh-col-2 mh-almanac">
                                                                <div class="mh-almanac-base mh-almanac-main"></div>
                                                                <div class="mh-almanac-extra gclearfix" style="display:none;">
                                                                    <div class="mh-suited">
                                                                        <h3 class="mh-st-label">宜</h3>
                                                                        <ul class="mh-st-items gclearfix"></ul>
                                                                    </div>
                                                                    <div class="mh-tapu">
                                                                        <h3 class="mh-st-label">忌</h3>
                                                                        <ul class="mh-st-items gclearfix"></ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span id="mh-date-y" style="display:none;">2019</span>

                                                    <script>
                                                        /* 2015节假日清单，一年一改 */
                                                        (function() {
                                                            window.OB = window.OB || {},
                                                                window.OB.RiLi = window.OB.RiLi || {},
                                                                window.OB.RiLi.dateRest = ["0101", "0102", "0103", "0218", "0219", "0220", "0221", "0222", "0223", "0224", "0404", "0405", "0406", "0501", "0502", "0503", "0620", "0621", "0622", "0903", "0904", "0905", "0926", "0927", "1001", "1002", "1003", "1004", "1005", "1006", "1007"],
                                                                window.OB.RiLi.dateWork = ["0104", "0215", "0228", "0906", "1010"],
                                                                window.OB.RiLi.dateFestival = ["20190101||元旦", "20190205||春节", "20190405||清明节", "20190501||劳动节", "20190607||端午节", "20190903||抗战纪念日", "20190913||中秋节", "20191001||国庆节"],
                                                                window.OB.RiLi.dateAllFestival = ["正月初一|v,春节", "正月十五|v,元宵节", "二月初二|v,龙头节", "五月初五|v,端午节", "七月初七|v,七夕节", "七月十五|v,中元节", "八月十五|v,中秋节", "九月初九|v,重阳节", "十月初一|i,寒衣节", "十月十五|i,下元节", "腊月初八|i,腊八节", "腊月廿三|i,祭灶节", "0202|i,世界湿地日,1996", "0214|v,西洋情人节", "0308|i,国际妇女节,1975", "0315|i,国际消费者权益日,1983", "0422|i,世界地球日,1990", "0501|v,国际劳动节,1889", "0512|i,国际护士节,1912", "0518|i,国际博物馆日,1977", "0605|i,世界环境日,1972", "0623|i,国际奥林匹克日,1948", "0624|i,世界骨质疏松日,1997", "1117|i,世界学生日,1942", "1201|i,世界艾滋病日,1988", "0101|v,元旦", "0312|i,植树节,1979", "0504|i,五四青年节,1939", "0601|v,儿童节,1950", "0701|v,建党节,1941", "0801|v,建军节,1933", "0903|v,抗战胜利纪念日", "0910|v,教师节,1985", "1001|v,国庆节,1949", "1224|v,平安夜", "1225|v,圣诞节", "w:0520|v,母亲节,1913", "w:0630|v,父亲节", "w:1144|v,感恩节(美国)", "w:1021|v,感恩节(加拿大)"];
                                                            /*本地老黄历库在lhl文件夹，此处是官网调用的*/
                                                            var e = "<?= $jsDataBaseUrl ?>";
                                                            //location.protocol == "https:" && (e = "https://s.ssl.qhimg.com/!97be6a4c/data/")
                                                                /*本地老黄历库在lhl文件夹，此处是官网调用的*/
                                                                window.OB.RiLi.hlUrl = {
                                                                    2008 : e + "hl2008.js",
                                                                    2009 : e + "hl2009.js",
                                                                    2010 : e + "hl2010.js",
                                                                    2011 : e + "hl2011.js",
                                                                    2012 : e + "hl2012.js",
                                                                    2013 : e + "hl2013.js",
                                                                    2014 : e + "hl2014.js",
                                                                    2015 : e + "hl2015.js",
                                                                    2016 : e + "hl2016.js",
                                                                    2017 : e + "hl2017.js",
                                                                    2018 : e + "hl2018.js",
                                                                    2019 : e + "hl2019.js",
                                                                    2020 : e + "hl2020.js"
                                                                },
                                                                window.OB.RiLi.dateHuochepiao = ["-20141201||20", "20141201||30", "20141202||36", "20141203||42", "20141204||48", "20141205||54", "+20141205||60", "c20141221-20141228||red"],
                                                                window.OB.RiLi.useLunarTicketDay = {
                                                                    2019 : {
                                                                        "0204": "除夕",
                                                                        "0205": "初一",
                                                                        "0206": "初二",
                                                                        "0207": "初三",
                                                                        "0208": "初四",
                                                                        "0209": "初五",
                                                                        "0210": "初六",
                                                                        "0211": "初七"
                                                                    }
                                                                }
                                                        })()
                                                    </script>
                                                </div>
                                            </div>

                                            <div class="mh-rili-foot"></div>

                                        </div>
                                        <script>
                                            _loader.use("jquery",function(){function l(){t.slideDown(),r.slideDown(),i=="1"&&$.ajax({url:v("https://open.onebox.haosou.com/dataApi"),dataType:"jsonp",data:{query:"日历",url:"日历",type:"rili",user_tpl:"ajax/rili/html",selectorPrefix:s,asynLoading:i,src:"onebox",tpl:"1"},timeout:5e3,success:function(t){t&&t.html?(e.find(".mh-rili-widget").html(t.html),n.hide().addClass("mh-err"),i="0"):d()},error:function(){d()}})}function c(t,n){t=t.replace("\u6e05\u660e","\u6e05\u660e\u8282").replace("\u56fd\u9645\u52b3\u52a8\u8282","\u52b3\u52a8\u8282");var r=new RegExp(u);f=f||e.find("#mh-date-y").html(),u&&n==f&&r.test(t)?a=!0:a=!1,o.val(t).trigger("change")}function h(){$.each(o.find("option"),function(e,t){var n=$(this);n.data("desc")&&n.val()&&(u+=n.val()+"|")}),u=u.substring(0,u.length-2)}function p(){n.hide()}function d(){n.addClass("mh-err")}function v(e){return location.protocol=="https:"?"https://open.onebox.haosou.com/api/proxy?__url__="+encodeURIComponent(e):e}jQuery.curCSS=jQuery.css;var e=$("#mohe-rili"),t=$(".mh-rili-wap",e),n=$(".mh-tips",e),r=$(".mh-rili-foot",e),i="0",s="#mohe-rili .mh-rili-widget",o=e.find(".mh-holiday-data"),u="",a=!1,f=e.find("#mh-date-y").html();h(),e.on("click",".mh-op a",function(e){e.preventDefault();var n=$(this).closest(".mh-op");n.hasClass("mh-op-less")?(t.slideUp(),r.slideUp()):l(),n.toggleClass("mh-op-less")}).on("click",".mh-js-reload",function(e){e.preventDefault(),l()}).on("change",".mh-holiday-data",function(){var e=$(this),t=e.val(),n=e.find("option:selected"),i=n.attr("data-desc")||"",s=n.attr("data-gl")||"";if(!a||t=="0"||i===""&&s==="")r.html("");else{var o='<div class="mh-rili-holiday">[holidayDetail][holidaySug]</div>';i&&(i="<p>"+i+"</p>"),s&&(s="<p><span>\u4f11\u5047\u653b\u7565\uff1a</span>"+s+"</p>"),o=o.replace("[holidayDetail]",i).replace("[holidaySug]",s),r.html(o)}}),window.OB=window.OB||{},window.OB.RiLi=window.OB.RiLi||{},window.OB.RiLi.rootSelector="#mohe-rili ",window.OB.RiLi.CallBack={afterInit:p,holiday:c}})
                                        </script>
                                        <script>
                                            /**
                                             * rili-widget 所包含的JS文件
                                             * 共包含15个JS文件，由于彼此间存在依赖关系，它们的顺序必须依次是：
                                             *		1.jquery-ui-1.10.3.custom
                                             *		2.msg_config	// 配置事件消息
                                             *
                                             *		3.mediator	  //库，基于事件的异步编程
                                             *		4.calendar    //日历类
                                             *		5.lunar       //农历
                                             *
                                             *		6.cachesvc    //window. appdata依赖它
                                             *		7.appdata     //window. 时间矫正
                                             *		8.timesvc     //window.TimeSVC  时间同步服务
                                             *
                                             *		9.huochepiao    //购票（无用）
                                             *
                                             *		10.fakeSelect    //$-ui  年份月份下拉选择器
                                             *		11.speCalendar   //$-ui 日历单元格的特殊内容
                                             *		12.webCalendar   //$-ui 日历单元格
                                             *		13.dayDetail     //$-ui 日历右侧的详情（黄历 忌宜）
                                             *
                                             *		14.xianhao      //注册事件：日历上方的操作工具条：年月日节假日 返回今天
                                             *		15.dispatcher   //提取参数，初始化日历
                                             *
                                             * 最后拼接的顺序是 jquery-ui-1.10.3.custom,msg_config,mediator,calendar,lunar,cachesvc,appdata,timesvc,huochepiao,fakeSelect,speCalendar,webCalendar,dayDetail,xianhao,dispatcher
                                             *
                                             * 代码从导航日历迁移过来，
                                             */
                                            _loader.remove && _loader.remove("rili-widget");
                                            _loader.add("rili-widget", "<?= $jsWnlBaseUrl ?>");//上述JS文件们已让我压缩成wnl.js
                                            _loader.use("jquery, rili-widget", function(){
                                                var RiLi = window.OB.RiLi;
                                                var gMsg = RiLi.msg_config,
                                                    dispatcher = RiLi.Dispatcher,
                                                    mediator = RiLi.mediator;
                                                var root = window.OB.RiLi.rootSelector || '';
                                                // RiLi.AppData(namespace, signature, storeObj) 为了解决"In IE7, keys may not contain special chars"
                                                //'api.hao.360.cn:rili' 仅仅是个 namespace
                                                var timeData = new RiLi.AppData('api.hao.360.cn:rili'),
                                                    gap = timeData.get('timeOffset'),
                                                    dt = new Date(new Date() - (gap || 0));
                                                RiLi.action = "default";
                                                var $detail = $(root+'.mh-almanac .mh-almanac-main');
                                                $detail.dayDetail(dt);
                                                RiLi.today = dt;
                                                var $wbc = $(root+'.mh-calendar');
                                                mediator.subscribe(gMsg.type.actionfestival , function (d){
                                                    var holi = RiLi.dateFestival,
                                                        val = d.val ? decodeURIComponent(d.val) : "",
                                                        holiHash = {},
                                                        el,
                                                        node = {};
                                                    for (var i = 0 ; i < holi.length ; ++i){
                                                        el = holi[i];
                                                        el = $.trim(el).split("||");
                                                        if (el.length == 2){
                                                            node = {};
                                                            node.year = el[0].substr(0 , 4);
                                                            node.month = el[0].substr(4 , 2);
                                                            node.day = el[0].substr(6 , 2);
                                                            holiHash[el[1]] = node;
                                                        }
                                                    };

                                                    RiLi.action = "festival";
                                                    if (holiHash[val]){
                                                        node.year = holiHash[val].year;
                                                        node.month = holiHash[val].month;
                                                        node.day = holiHash[val].day;

                                                        RiLi.needDay = new Date(parseInt(node.year , 10) , parseInt(node.month ,10) - 1 , node.day);
                                                        $wbc.webCalendar({
                                                            time : new Date(parseInt(node.year , 10) , parseInt(node.month ,10) - 1 , node.day),
                                                            onselect: function(d, l){
                                                                $detail.dayDetail('init', d , l);
                                                            }
                                                        });
                                                    }
                                                    else{
                                                        RiLi.action = "default";
                                                    }
                                                });

                                                mediator.subscribe(gMsg.type.actionquery , function (d){
                                                    var strDate;

                                                    if (!d.year || d.year > 2100 || d.year < 1901){
                                                        RiLi.action = "default";
                                                        return 0;
                                                    }
                                                    d.month = parseInt(d.month , 10);
                                                    if (d.month &&  (d.month > 12 || d.month < 1)){
                                                        RiLi.action = "default";
                                                        return 0;
                                                    }
                                                    if (!d.month){
                                                        d.month = 1 ;
                                                    }
                                                    d.day = parseInt(d.day , 10);

                                                    if (!d.day){
                                                        d.day = 1;
                                                    }
                                                    RiLi.action = "query";
                                                    RiLi.needDay = new Date(parseInt(d.year , 10) , parseInt(d.month ,10) - 1 , d.day);
                                                    $wbc.webCalendar({
                                                        time : new Date(parseInt(d.year , 10) , parseInt(d.month ,10) - 1 , d.day),
                                                        onselect: function(d, l){
                                                            $detail.dayDetail('init', d , l);
                                                        }
                                                    });
                                                });

                                                mediator.subscribe(gMsg.type.actiongoupiao, function (d){
                                                    RiLi.action = "goupiao";
                                                    $wbc.webCalendar({
                                                        time : dt,
                                                        onselect: function(d, l){
                                                            $detail.dayDetail('init', d , l);
                                                        }
                                                    });
                                                });

                                                mediator.subscribe(gMsg.type.actiondefault , function (d){
                                                    RiLi.needDay = dt;
                                                    $wbc.webCalendar({
                                                        time : dt,
                                                        onselect: function(d, l){
                                                            $detail.dayDetail('init', d , l);
                                                        }
                                                    });
                                                });

                                                dispatcher.dispatch();
                                                mediator.subscribe(gMsg.type.dch , function (d){
                                                    // if (RiLi.needDay){
                                                    // 	$wbc.webCalendar("initTime" , RiLi.needDay);
                                                    // }
                                                    // else{
                                                    // 	$wbc.webCalendar("initTime" , RiLi.today);
                                                    // }
                                                    $wbc.webCalendar("initTime" , RiLi.needDay||RiLi.today);
                                                });

                                                mediator.publish(gMsg.type.dch ,  dt);
                                                var nowDate = (new Date()).getTime() ;

                                                /* 时间矫正 */
                                                RiLi.TimeSVC.getTime(function(d){
                                                    var trueTime = d.getTime();
                                                    var timeData = new RiLi.AppData('api.hao.360.cn:rili') , isFirst = true;

                                                    if(Math.abs(nowDate - trueTime) > 300000){
                                                        timeData.set('timeOffset', nowDate - trueTime);
                                                    }
                                                    else {
                                                        timeData.remove('timeOffset');
                                                    }

                                                    if (typeof gap == undefined || !isFirst){
                                                        RiLi.today = d;
                                                        mediator.publish(gMsg.type.dch , d);
                                                    }

                                                    isFirst = false;
                                                });
                                                //日历初始完后的回调
                                                if(typeof RiLi.CallBack.afterInit === "function"){
                                                    RiLi.CallBack.afterInit();
                                                }
                                            });
                                        </script>
                                    </li>
                                </ul>
                            </div>
                            <!-- END #main -->
                        </div>
                    </div>
                    <div class="jiri-baike">
                        <h3>风水小百科</h3>
                        <div class="jiri-baike-content">
                            <p>很多朋友都说自己喜欢研究风水，那么风水到底是什么呢？风水是一门以《易经》为基础，研究人类如何和天（宇宙空间）、地 自然环境）和谐相处的自然学科。孔子在《系辞传》中讲：“《易》之为书也,广大悉备：有天道焉，有人道焉，有地道焉……”这说明，几千年前，我们的祖先就开始把人类自身放在宇宙大自然之中进行统一的考察，学习并利用大自然的能力为自身服务</p>
                        　　<p>宇宙中有日月星辰的引力，大地中有无形的磁场力量。人作为一个生物体，现代科学已经证明了——人体也存在着一个生物气场。人类生于天地之间，置身于宇宙引力场（天气）和大地磁力场（地气）之下，那么小小的人体生物场（人气)无时不受着天气和地气的影响，这个影响是对立和统一的关系——好和坏的关系！</p>
                        　　<p>如果“天气”和“地气”对“人气”的影响是向上正向叠加的，那身体就受益——通则不痛嘛，人的精神就会充足，头脑就会清醒，做事就会顺顺利利，事业就会飞黄腾达！“天气”和“地气”对“人气”向上正向叠加的大小，就决定了一个人的成功的大小程度。如果“天气”和“地气”对“人气”的影响是负向叠加的，那身体就会受到负面的影响，人的精神就会不足，头脑就会发木，做事就不会顺利，事业就不可能有成功的可能！</p>
                        　　<p>所以，“风水”的义意就在于发现和调理我们所经常接触的环境空间，寻找和改善对我们人体有用的气场和方位，从而善加利用，趋吉避凶，从而达到我们理想中的彼岸
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebox">
                <?= SideBoxListWidget::widget([
                    'style' => 'tab',
                    'htmlClass' => 'about-us',
                    'columnType' => 'block',
                    'blockId' => Yii::$app->params['config_face_cn_sidebox_contact_us_block_id'],
                ]); ?>

                <?= $this->render('/common/_sidebox_flow') ?>
            </div>
        </div>
    </div>
</div>