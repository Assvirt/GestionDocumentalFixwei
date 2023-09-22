<?php 
include('header.php');?>
<title></title>
<link rel="stylesheet" type="text/css" href="css/dropzone.css" />
<script type="text/javascript" src="js/dropzone.js"></script>
<style type="text/css">
.file_upload{
	border: 4px dashed #292929;
	}
</style>

<?php //include('container.php');?>
<div class="container">
	<h2></h2>	
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Cargar Archivos</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
        
        
	<div class="file_upload">
		<form action="file_upload.php" class="dropzone">
			<input name="idCarpeta" value="1" type="hidden">
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
    <!--	
	<div style="margin:10px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="https://www.baulphp.com/subir-archivos-arrastrar-y-soltar-con-php/" title="">Retornar al Tutorial</a>			
	</div>		
-->
</div>
<?php //include('footer.php');?>