<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/system.php';

function get_domain()
{
    global $configuracion;
    
	if($configuracion['home_url'] != "")
        return $configuracion['home_url'].'/';
    else
        return 'http://'.$_SERVER['SERVER_NAME'].'/';
   	//return $domain;
}


function parse_extras($rule)
{
	if ($rule[0] == "#")
	{
		$id = substr($rule,1,strlen($rule));
		$data = ' id="' . $id . '"';
		return $data;
	}

	if ($rule[0] == ".")
	{
		$class = substr($rule,1,strlen($rule));
		$data = ' class="' . $class . '"';
		return $data;
	}

	if ($rule[0] == "_")
	{
		$data = ' target="' . $rule . '"';
		return $data;
	}
}


function anchor($link, $text, $title='', $extras=null)
{
    if($link[0] == 'h' && $link[1] == 't' && $link[2] == 't' && $link[3] == 'p' && $link[4] == ':' && $link[5] == '/' && $link[6] == '/'){
    
    }
    else{
	$domain = get_domain();
	$link = $domain . $link;
    }
	$data = '<a href="' . $link . '"';

	if ($title)
	{
		$data .= ' title="' . $title . '"';
	}
	else
	{
		$data .= ' title="' . $text . '"';
	}

	if (is_array($extras))
	{
		foreach($extras as $rule)
		{
			$data .= parse_extras($rule);
		}
	}

	if (is_string($extras))
	{
		$data .= parse_extras($extras);
	}

	$data.= '>';

	$data .= $text;
	$data .= "</a>";

	return $data;
}
function html_title($cadena = ""){
    global $configuracion;
    $titulo = "";
	if($configuracion['beta'] == true)
	{
		$titulo = "[BETA] ";
	}
	
	if($cadena == "")
        return $titulo.$configuracion['webtitle'];
    else
        return $titulo.$cadena.' - '.$configuracion['webtitle'];
}
