function initiate_geolocation_menu(){navigator.geolocation?navigator.geolocation.getCurrentPosition(handle_geolocation_query_menu,handle_errors_menu,{enableHighAccuracy:!0}):(gl=google.gears.factory.create("beta.geolocation"),gl!=null&&gl.getCurrentPosition(handle_geolocation_query_menu,handle_errors_menu,{enableHighAccuracy:!0}))}
function handle_errors_menu(b){switch(b.code){case b.PERMISSION_DENIED:alert("Debes dar permiso para acceder a tu localizacion ");break;case b.POSITION_UNAVAILABLE:alert("No se ha podido detectar tu posicion actual");break;case b.TIMEOUT:alert("Tiempo de espera agotado");break;default:alert("Error desconocido")}}function handle_geolocation_query_menu(b){milat=b.coords.latitude;milong=b.coords.longitude;jQuery("#menulat").val(milat);jQuery("#menulong").val(milong);jQuery("#geomenu").submit()}
function generateCoverDiv(b,d,e){var c=1;navigator.userAgent.indexOf("MSIE")>=0&&(c=0);var a=document.createElement("div");a.id=b;a.style.width=document.body.offsetWidth+"px";a.style.height=document.body.offsetHeight+"px";a.style.backgroundColor=d;a.style.position="absolute";a.style.top=0;a.style.left=0;a.style.zIndex=10;c==0?a.style.filter="alpha(opacity="+e+")":a.style.opacity=e/100;document.body.appendChild(a)}
function generar_oscuridad(b,d,e){var c=1;if(navigator.userAgent.indexOf("MSIE")>=0)c=0;else if(navigator.userAgent.indexOf("BlackBerry")>=0&&(navigator.userAgent.indexOf("5.")>=0||navigator.userAgent.indexOf("4.")>=0))c=2;var a=document.createElement("div");a.id=b;a.style.width=document.body.offsetWidth+"px";a.style.height=document.body.offsetHeight+"px";c!=2?a.style.backgroundColor=d:(a.style.backgroundColor="transparent",a.style.backgroundImage="url(style/blackberry_fondo.png)",a.style.backgroundRepeat=
"repeat");a.style.position="absolute";a.style.top=0;a.style.left=0;a.style.zIndex=10;if(c==0)a.style.filter="alpha(opacity="+e+")";else if(c==1)a.style.opacity=e/100;document.body.appendChild(a)}
function toggle_menu(){var b=!1;jQuery("#desplegador").click(function(d){d.preventDefault();jQuery("#menu").slideToggle();b==!1?(b=!0,generar_oscuridad("oscuridad","#000000",20),jQuery("#mennu").attr("class","desplegador-si")):(b=!1,jQuery("#oscuridad").remove(),jQuery("#mennu").attr("class","desplegador-no"))});jQuery("#geomenubtn").click(function(b){b.preventDefault();initiate_geolocation_menu()})}
function toggle_geobutton(){jQuery("#geomenubtn").click(function(b){b.preventDefault();initiate_geolocation_menu()})};