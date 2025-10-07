<script>
var appInformeDashboard = (function() {
   
	var g_procesando_alta = false;
	var g_did = 0;
	var g_quehago = 'nuevo';
	var g_data;

	
	public = {};

    public.Inicializar = function() {
		console.log("appInformeDashboard INI");
		//$("#modalClientes").modal();	
		console.log("appInformeDashboard FIN");		
    };
	
	public.openEdit = function(did){
		//g_did = did;
		//getAjax();
		$(".winapp").css('display','none');
		$("#appInformeDashboard").css('display','block');
	};
	
	public.open = function(){
		//$("#modalClientes").modal('open');
		$(".winapp").css('display','none');
		$("#appInformeDashboard").css('display','block');
	}
	
	public.openView = function(did){
		//g_did = did;
		//getAjax();
		//$("#modalClientes").modal('open');
	}

	public.close = function() {
		$("#modalClientes").modal('close');
		this.resetDataALta();
    };
		
	public.resetDataALta = function() {
		
		$("#atributos_clientes").html("");
		$("#direccion_clientes").html("");
		$("#contactos_clientes").html("");
		g_procesando_alta = false;
		g_did = 0;
		g_quehago = 'nuevo';
		g_data = "";
		g_contactos = [];
		g_direcciones = [];
		g_posicion_direccion = -1;
		$("#cliente_codigo").val("");
		$("#cliente_obs").val("");
		$("#cliente_nombreFantasia").val("");
		$("#cliente_razonSocial").val("");
		$("#cliente_numero_documento").val("");

		$('#btn_cli_alta_tab_1_a')[0].click();

    };
	

	//manejo contactos
	function frenderlistadoContactos(){
		buffer = "";	
		existedefault = false;		
		for(n in g_contactos){
			contacto = g_contactos[n];
			
			if(contacto["tipo"] == 1){
				tipo = "Teléfono";
			}else if(contacto["tipo"] == 2){
				tipo = "Email";
			}else if(contacto["tipo"] == 3){
				tipo = "Celular";
			}else if(contacto["tipo"] == 4){
				tipo = "Web";
			}else if(contacto["tipo"] == 5){
				tipo = "Fax";
			}
			
			defaultC = "";
			if(contacto["default"] == 1){
				defaultC = "checked";
				existedefault = true;
			}
			
			defhyml = "<label><input name='contactcliente' id='linea_contacto_cliente_default_"+n+"' type='radio' disabled onchange='appClientes.setDefault("+n+",this);' "+defaultC+"/><span></span></label>";
			
			buffer += "<tr>";
			buffer += "<td>"+defhyml+"</td>";
			buffer += "<td>"+tipo+"</td>";
			buffer += "<td><input type='text' value='"+contacto["valor"]+"' class='' id='' data-campo='valor' onkeyup='appClientes.editcontacto("+n+",this)'></td>";
			//buffer += "<td><input type='text' value='"+contacto["nombre"]+"' class='' id='' data-campo='nombre' onkeyup='appClientes.editcontacto("+n+",this)'></td>";
			buffer += "</tr>";
		}
		
		$("#contactos_clientes").html(buffer);
		
		if(buffer != ""){
			if(!existedefault){
				$("#linea_contacto_cliente_default_0").prop("checked",true);
				g_contactos[0]["default"] = 1;
			}
		}
	}

	//manejo direcciones	
	public.openDirecciones = function (){
		appDirecciones.open();
		appDirecciones.config(1);
	}
		
	function frenderDirecciones(){
		buffer = "";
		for(n in g_direcciones){
			direccion = g_direcciones[n];
						
			buffer += "<tr>";
			buffer += "<td>"+g_provincias[direccion["provincia"]]+"</td>";
			buffer += "<td>"+direccion["localidad"]+"</td>";
			buffer += "<td>"+direccion["ciudad"]+"</td>";
			buffer += "<td>"+direccion["calle"]+"</td>";
			buffer += "<td>"+direccion["numero"]+"</td>";
			buffer += "<td>"+direccion["cp"]+"</td>";
			buffer += "</tr>";
		}
		
		g_posicion_direccion = -1;
		$("#direccion_clientes").html(buffer);
	}
	
	//VARIOS
	
	function render() {

		header = g_data["header"];		
		$("#cliente_codigo").val(header["codigo"]);
		$("#cliente_nombreFantasia").val(header["nombre_fantasia"]);
		$("#cliente_razonSocial").val(header["razon_social"]);
		$("#cliente_obs").val(header["obs"]);
		$("#cliente_tipo_documento").val(header["doc_tipo"]);
		$("#cliente_numero_documento").val(header["doc_num"]);
		$("#cliente_iva").val(header["tipo_responsable"]);
		$("#cliente_habilitado").prop("checked",(header["habilitado"] == 1)?"checked":"");

		//contactos
		g_contactos2 = g_data["contactos"];			
		for(h in g_contactos2){			
			g_contactos.push({"did":g_contactos2[h]["did"],"tipo":g_contactos2[h]["tipo_contacto"],"valor":g_contactos2[h]["valor"],"nombre":"","default":g_contactos2[h]["defaultc"]});
		}
		frenderlistadoContactos();
				
		//direcciones
		g_direcciones2 = g_data["direcciones"];
		for(h in g_direcciones2){
			g_direcciones.push({"provincia":g_direcciones2[h]["provincia"],"localidad":g_direcciones2[h]["localidad"],"ciudad":g_direcciones2[h]["ciudad"],"calle":g_direcciones2[h]["calle"],"numero":g_direcciones2[h]["numero"],"cp":g_direcciones2[h]["cp"],"did":g_direcciones2[h]["did"]});
		}
		frenderDirecciones();

			
    };
	
	function getAjax() {
		parametros = {"operador":"getCliente","did":g_did};
		$.ajax({
			url : "modules/clientes/alta/controlador.php",
			type: 'POST',
			//dataType: "json",
			data: parametros,
			success : function(result) {
				g_data = JSON.parse(result);
				render();
				g_quehago = 'modificar';
			},
			error : function(xhr, status) {
				swal({title: 'Error al actualizar',icon: 'error'});
			},
			complete : function(xhr, status) {
				//FresetDataCliente();
				//swal({title: 'Actualizado',icon: 'success'});
			}
		});	
    };
	
	public.getAll = function () {
		parametros = {"operador":"getClientes"};
		$.ajax({
			url : "modules/clientes/alta/controlador.php",
			type: 'POST',
			//dataType: "json",
			data: parametros,
			success : function(result) {
				g_clientes = JSON.parse(result);
			},
			error : function(xhr, status) {
				swal({title: 'Error al actualizar',icon: 'error'});
			},
			complete : function(xhr, status) {
				//FresetDataCliente();
				//swal({title: 'Actualizado',icon: 'success'});
			}
		});	
    };
	
    return public;
}());
</script>