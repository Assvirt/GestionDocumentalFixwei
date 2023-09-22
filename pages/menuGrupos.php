<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
    
require_once 'conexion/bd.php';
$rootAdministadirMenu=$_SESSION['session_root'];
///// formularios
    //// Congi
    $formularioUsuario = 'usuarios';
    $formularioGrupos='gruposDis';
    $formularioCentroCosto='centroCostos';
    $formularioCargos='cargos';
    $formularioCentroTrabajo='centroTrabajo';
    $formularioProcesos='procesos';
    $formularioMacroproceso='macroprocesos';
    $formularioDeficiones='definicion';
    $formularioCodificacion='codificacion';
    $formularioNormativa='normativa';
    $formularioTipoDocumenmto='tipoDocumento';
    //// END
    //// gestionDoc
    $formularioListadoMaestro='listadoMaestro';
    $formularioSolicitudDocuimentos='solicitudDocumentos';
    $formularioCreacionDoc='creacionDoc';
    $formularioDocumentoEx='documentoEx';
    $formularioDocumentosOBS='documentosObs';
    $formularioRepositorio='repositorio';
    $formularioRevisionDoc='revisionDoc';
    //// END
    //// indicadores
    $formularioIndicadores='indicadores';
    //// END
    //// actas
    $formularioActas='actas';
    //// END
    //// compras
    $formularioPoliticas='politicas';
    $formularioProveedores='proveedores';
    $formularioSolicitudCompra='solicitudCom';
    $formularioOrdenCompra='ordenCom';
    $formularioPresupuesto='presupuesto';
    $formularioAprobacionOC='aprobacionOC';
    $formularioEntradasSalidas='entradasSalidas';
    //// END
//// end

$menuDocumento = $_SESSION["session_username"];

$menuQueryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$menuDocumento'");
while($row = $menuQueryGrupos->fetch_assoc()){
       $idGrupoMenu = $row['idGrupo'].'<br>';
    /////// Config
        $menuusuarios = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioUsuario'");
        $menupermisoUsuario = $menuusuarios->fetch_array(MYSQLI_ASSOC);
        if($menupermisoUsuario['listar'] == TRUE){
            $menuPermisoListarUsuarios = $menupermisoUsuario['listar'];    
        }
        $menuGruposDist = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioGrupos'");
        $menupermisoGrupo = $menuGruposDist->fetch_array(MYSQLI_ASSOC);
        if($menupermisoGrupo['listar'] == TRUE){
            $menuPermisoListarGruposD = $menupermisoGrupo['listar'];    
        }
        $menuCentroCosto = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioCentroCosto'");
        $menupermisoCentroCosto = $menuCentroCosto->fetch_array(MYSQLI_ASSOC);
        if($menupermisoCentroCosto['listar'] == TRUE){
            $menuPermisoListarCentroCosto = $menupermisoCentroCosto['listar'];    
        }
        $menuGruposCargos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioCargos'");
        $menupermisoCargo = $menuGruposCargos->fetch_array(MYSQLI_ASSOC);
        if($menupermisoCargo['listar'] == TRUE){
            $menuPermisoListarCargo = $menupermisoCargo['listar'];    
        }
        $menuGruposCentroTrabajo = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioCentroTrabajo'");
        $menupermisoCentroTrabajo = $menuGruposCentroTrabajo->fetch_array(MYSQLI_ASSOC);
        if($menupermisoCentroTrabajo['listar'] == TRUE){
            $menuPermisoListarCentroTrabajo = $menupermisoCentroTrabajo['listar'];    
        }
        $menuGruposProcesos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioProcesos'");
        $menupermisoProcesos = $menuGruposProcesos->fetch_array(MYSQLI_ASSOC);
        if($menupermisoProcesos['listar'] == TRUE){
            $menuPermisoListarProcesos = $menupermisoProcesos['listar'];    
        }
        $menuGruposMacroprocesos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioMacroproceso'");
        $menupermisoMacroprocesos = $menuGruposMacroprocesos->fetch_array(MYSQLI_ASSOC);
        if($menupermisoMacroprocesos['listar'] == TRUE){
            $menuPermisoListarMacroprocesos = $menupermisoMacroprocesos['listar'];    
        }
        $menuGruposDefiniciones = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioDeficiones'");
        $menupermisoDefiniciones = $menuGruposDefiniciones->fetch_array(MYSQLI_ASSOC);
        if($menupermisoDefiniciones['listar'] == TRUE){
            $menuPermisoListarDefiniciones = $menupermisoDefiniciones['listar'];    
        }
        $menuGruposCodificacion = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioCodificacion'");
        $menupermisoCodificacion = $menuGruposCodificacion->fetch_array(MYSQLI_ASSOC);
        if($menupermisoCodificacion['listar'] == TRUE){
            $menuPermisoListarCodificacion = $menupermisoCodificacion['listar'];    
        }
        $menuGruposNormativa = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioNormativa'");
        $menupermisoNormativa = $menuGruposNormativa->fetch_array(MYSQLI_ASSOC);
        if($menupermisoNormativa['listar'] == TRUE){
            $menuPermisoListarNormativa = $menupermisoNormativa['listar'];    
        }
        $menuGruposTipoDocumento = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioTipoDocumenmto'");
        $menupermisoTipoDocumento = $menuGruposTipoDocumento->fetch_array(MYSQLI_ASSOC);
        if($menupermisoTipoDocumento['listar'] == TRUE){
            $menuPermisoListarTipoDocumento = $menupermisoTipoDocumento['listar'];    
        }
    /////// END
    ////// gestionDoc
        $menuGruposListadoMaestro = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioListadoMaestro'");
        $menupermisoListadoMaestro = $menuGruposListadoMaestro->fetch_array(MYSQLI_ASSOC);
        if($menupermisoListadoMaestro['listar'] == TRUE){
            $menuPermisoListarListadoMaestro = $menupermisoListadoMaestro['listar'];    
        }
        $menuGruposSolicitudDocumentos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioSolicitudDocuimentos'");
        $menupermisoSolicitudDocumentos = $menuGruposSolicitudDocumentos->fetch_array(MYSQLI_ASSOC);
        if($menupermisoSolicitudDocumentos['listar'] == TRUE){
            $menuPermisoListarSolicitudDocumentos = $menupermisoSolicitudDocumentos['listar']; 
            $menuPermisoListarSolicitudDocumentosPendientes = $menupermisoSolicitudDocumentos['crear']; 
        }else{
            
        }
        $menuGruposCreacionDocumental = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioCreacionDoc'");
        $menupermisoCreacionDocumental = $menuGruposCreacionDocumental->fetch_array(MYSQLI_ASSOC);
        if($menupermisoCreacionDocumental['listar'] == TRUE){
            $menuPermisoListarCreacionDocumental = $menupermisoCreacionDocumental['listar'];
            $menuPermisoListarCreacionDocumentalPendientes = $menupermisoCreacionDocumental['crear'];
        }
        $menuGruposDocumentoExterno = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioDocumentoEx'");
        $menupermisoDocumentoExterno = $menuGruposDocumentoExterno->fetch_array(MYSQLI_ASSOC);
        if($menupermisoDocumentoExterno['listar'] == TRUE){
            $menuPermisoListarDocumentoExterno = $menupermisoDocumentoExterno['listar'];    
        }
        $menuGruposDocumentoObsoleto = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioDocumentosOBS'");
        $menupermisoDocumentoObsoleto = $menuGruposDocumentoObsoleto->fetch_array(MYSQLI_ASSOC);
        if($menupermisoDocumentoObsoleto['listar'] == TRUE){
            $menuPermisoListarDocumentoObsoleto = $menupermisoDocumentoObsoleto['listar'];    
        }
        $menuGruposRepositorio = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioRepositorio'");
        $menupermisoRepositorio = $menuGruposRepositorio->fetch_array(MYSQLI_ASSOC);
        if($menupermisoRepositorio['listar'] == TRUE){
            $menuPermisoListarRepositorio = $menupermisoRepositorio['listar'];    
        }
        $menuGruposRevisionDocumental = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioRevisionDoc'");
        $menupermisoRevisionDocumental = $menuGruposRevisionDocumental->fetch_array(MYSQLI_ASSOC);
        if($menupermisoRevisionDocumental['listar'] == TRUE){
            $menuPermisoListarRevisionDocumental = $menupermisoRevisionDocumental['listar'];    
        }
    ////// END
    ////// indicadores
        $menuGruposIndicadores = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioIndicadores'");
        $menupermisoIndicadores = $menuGruposIndicadores->fetch_array(MYSQLI_ASSOC);
        if($menupermisoIndicadores['listar'] == TRUE){
            $menuPermisoListarIndicadores = $menupermisoIndicadores['listar'];    
        }
    ///// END
    ///// actas
        $menuGruposActas = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioActas'");
        $menupermisoActas = $menuGruposActas->fetch_array(MYSQLI_ASSOC);
        if($menupermisoActas['listar'] == TRUE){
            $menuPermisoListarActas = $menupermisoActas['listar'];    
        }
    //// END
    //// compras
        $menuGruposPoliticas = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioPoliticas'");
        $menupermisoPoliticas = $menuGruposPoliticas->fetch_array(MYSQLI_ASSOC);
        if($menupermisoPoliticas['listar'] == TRUE){
            $menuPermisoListarPoliticas = $menupermisoPoliticas['listar'];    
        }
        $menuGruposProveedores = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioProveedores'");
        $menupermisoProveedores = $menuGruposProveedores->fetch_array(MYSQLI_ASSOC);
        if($menupermisoProveedores['listar'] == TRUE){
            $menuPermisoListarProveedores = $menupermisoProveedores['listar'];    
        }
        $menuGruposSolicitudCompras = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioSolicitudCompra'");
        $menupermisoSolicitudCompras = $menuGruposSolicitudCompras->fetch_array(MYSQLI_ASSOC);
        if($menupermisoSolicitudCompras['listar'] == TRUE){
            $menuPermisoListarSolicitudCompras = $menupermisoSolicitudCompras['listar'];    
        }
        $menuGruposOrdenCompra = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioOrdenCompra'");
        $menupermisoOrdenCompra = $menuGruposOrdenCompra->fetch_array(MYSQLI_ASSOC);
        if($menupermisoOrdenCompra['listar'] == TRUE){
            $menuPermisoListarOrdenCompra = $menupermisoOrdenCompra['listar'];    
        }
        $menuGruposPresupuesto = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioPresupuesto'");
        $menupermisoPresupuesto = $menuGruposPresupuesto->fetch_array(MYSQLI_ASSOC);
        if($menupermisoPresupuesto['listar'] == TRUE){
            $menuPermisoListarPresupuesto = $menupermisoPresupuesto['listar'];    
        }
        $menuGruposVerificacionOC = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioAprobacionOC'");
        $menupermisoVerificacionOC = $menuGruposVerificacionOC->fetch_array(MYSQLI_ASSOC);
        if($menupermisoVerificacionOC['listar'] == TRUE){
            $menuPermisoListarVerificacionOC = $menupermisoVerificacionOC['listar'];    
        }
        $menuGruposVerificacionEntradasSalidas = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupoMenu' AND formulario = '$formularioEntradasSalidas'");
        $menupermisoVerificacionEntradasSalidas = $menuGruposVerificacionEntradasSalidas->fetch_array(MYSQLI_ASSOC);
        if($menupermisoVerificacionEntradasSalidas['listar'] == TRUE){
            $menuPermisoListarVerificacionEntradasSalidas = $menupermisoVerificacionEntradasSalidas['listar'];    
        }
        
    //// END
}
if($rootAdministadirMenu == 1){
    $menuPermisoListarUsuarios=TRUE;
    $menuPermisoListarGruposD=TRUE;
    $menuPermisoListarCentroCosto=TRUE;
    $menuPermisoListarCargo=TRUE;
    $menuPermisoListarCentroTrabajo=TRUE;
    $menuPermisoListarProcesos=TRUE;
    $menuPermisoListarMacroprocesos=TRUE;
    $menuPermisoListarDefiniciones=TRUE;
    $menuPermisoListarCodificacion=TRUE;
    $menuPermisoListarNormativa=TRUE;
    $menuPermisoListarTipoDocumento=TRUE;
    
    $menuPermisoListarListadoMaestro=TRUE;
    $menuPermisoListarSolicitudDocumentos=TRUE;
    $menuPermisoListarCreacionDocumental=TRUE;
    $menuPermisoListarDocumentoExterno=TRUE;
    $menuPermisoListarDocumentoObsoleto=TRUE;
    $menuPermisoListarRevisionDocumental=TRUE;
    
    $menuPermisoListarRepositorio=TRUE;
    
    $menuPermisoListarIndicadores =TRUE;
    
    $menuPermisoListarActas=TRUE;
    
    $menuPermisoListarPoliticas=TRUE;
    $menuPermisoListarProveedores=TRUE;
    $menuPermisoListarSolicitudCompras=TRUE;
    $menuPermisoListarOrdenCompra=TRUE;
    $menuPermisoListarPresupuesto=TRUE;
    $menuPermisoListarVerificacionOC=TRUE;
    $menuPermisoListarVerificacionEntradasSalidas=TRUE;
}
}
?>
