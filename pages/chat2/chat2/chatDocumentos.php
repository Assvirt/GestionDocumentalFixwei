<link rel="stylesheet" type="text/css" href="documentos/css/dropzone.css" />
<script type="text/javascript" src="documentos/js/dropzone.js"></script>
<style type="text/css">
.file_upload{
	border: 4px dashed #292929;
	}
</style>

<div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Cargar Archivos</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
        
        
	<div class="file_upload">
		<form action="documentos/file_upload.php" class="dropzone">
		    <input name="idEnvia" value="<?php echo $_GET['idEnvia']; ?>" placeholder="Envia" type="hidden">
		    <input name="idRecibe" value="<?php echo $_GET['idRecibe']; ?>" placeholder="Recibe" type="hidden">
			<div class="dz-message needsclick">
				<strong>Arrastra archivos a cualquier lugar para subirlos.</strong><br /><br />
				<span class="note needsclick">
                <span class="glyphicon glyphicon-open" aria-hidden="true" style="font-size:60px;"></span>
                </span>
			</div>
		</form>		
	</div>
    	
  </div>	
 </div>	
</div>	
   
</div>
<?php include('documentos/footer.php');?>