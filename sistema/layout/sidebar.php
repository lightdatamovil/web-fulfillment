<?php

$buffer = "<ul class='menu-inner py-1'>";
//$Amenu = json_decode(file_get_contents("sistema/configMenu/menuDefault.json"),true);
$strmenu = file_get_contents("sistema/configMenu/menuDefault.json");

function filtrarMenuPorPerfil($perfil, $menuJsonPath = "sistema/configMenu/menuDefault.json")
{
	// Cargar el menú original
	$Amenu = json_decode(file_get_contents($menuJsonPath), true);

	// Función recursiva que filtra por permisos
	$filtrar = function ($items) use (&$filtrar, $perfil) {
		$result = [];
		foreach ($items as $item) {
			if (!isset($item['permisos'][$perfil]) || $item['permisos'][$perfil] != 1) {
				continue; // No tiene permiso, no se incluye
			}

			// Si tiene hijos, los filtramos también
			if (isset($item['hijos']) && is_array($item['hijos'])) {
				$item['hijos'] = $filtrar($item['hijos']); // Recursivo
			}

			$result[] = $item; // Incluir el ítem (con hijos filtrados o vacíos)
		}
		return $result;
	};

	// Aplicar el filtro al menú completo
	$menuFiltrado = $filtrar($Amenu);

	return $menuFiltrado;
}


$perfil = "adm";
$Amenu = filtrarMenuPorPerfil($perfil);
//echo json_encode($menu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

foreach ($Amenu as $menu) {

	$menname = $menu["nombre"];
	$menicono = $menu["icono"];
	$menaccion = $menu["accion"];
	$Amenhijos = $menu["hijos"];

	$onclick = "";
	if (!is_null($menaccion)) {
		$onclick = "onclick='{$menaccion}'";
	}

	$buffer .= "<li class='menu-item' >";

	$buffer .= "<a href='javascript:void(0);' class='menu-link menu-toggle' >";
	$buffer .= "<i class='menu-icon tf-icons $menicono'></i>";
	$buffer .= "<div data-i18n='$menname' $onclick>$menname</div>";
	//<div class='badge bg-danger rounded-pill ms-auto'>5</div>
	$buffer .= "</a>";

	if (sizeof($Amenhijos) > 0) {
		$buffer .= "<ul class='menu-sub'>";
		foreach ($Amenhijos as $smenu) {

			$menname = $smenu["nombre"];
			$menicono = $smenu["icono"];
			$menaccion = $smenu["accion"];
			$menruta = $smenu["ruta"];
			$Amenhijos = $smenu["hijos"];

			// $onclick = "";
			// if (!is_null($menaccion)) {
			// 	$onclick = "onclick='{$menaccion}'";
			// }

			$href = "";
			$route = "";
			if (!is_null($menaccion)) {
				$href = "href='/{$menruta}'";
				$route = "data-route='{$menruta}'";
			}

			$buffer .= "<li class='menu-item'>";
			$buffer .= "<a  class='menu-link' $href $route>";
			$buffer .= "<div data-i18n='$menname'>$menname</div>";
			$buffer .= "</a>";
			$buffer .= "</li>";
		}
		$buffer .= "</ul>";
	}
	$buffer .= "</li>";
}

$buffer .= "</ul>";
echo $buffer;
