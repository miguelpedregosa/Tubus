var popup_necesaria = false;
var popup_desplegada = false;

function cargar_popup()
{
var cookie = $.cookie('userciudad');
if(cookie == null)
{
	var popup_html = '<div id="popup" style="display:none; background-color: white; z-index:150; width:94%; "><div id="titulo_popup"></div>';
	var url = 'ajax/popup.php';
	
		$.ajax({
                    url: url,
                    cache: false,
                    success: function(data) {
						popup_html = popup_html + data + '</div>';
						$('body').prepend(popup_html);
						popup_necesaria = true;
						mostrar_popup();
                    }
                });
                

	
}

}
function center_popup(){

var windowWidth = document.documentElement.clientWidth;
var windowHeight = document.documentElement.clientHeight;
var popupHeight = $("#popup").height();
var popupWidth = $("#popup").width();


$("#popup").css({
"position": "absolute",
"top": "50px",
"left": "3%",
"right": "3%"
});


//only need force for IE6
/*
$("#backgroundPopup").css({
"height": windowHeight
});
*/
}


function mostrar_popup()
{
	
	if(popup_necesaria && popup_desplegada == false )
	{
		center_popup();
		generar_oscuridad('oscuridad', '#000000', 20);
		$("#popup").fadeIn("slow"); 
		popup_desplegada = true;
		
	}
}

function ocultar_popup()
{
	if(popup_desplegada)
	{
	$("#popup").fadeOut("slow"); 
	jQuery('#oscuridad').remove();
	popup_desplegada = true;
	}
}


