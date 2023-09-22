<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>File Manager Template | PrepBootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<div class="page-header">
    <h1>File Manager <small>A responsive file manager template</small></h1>
</div>

<!-- File Manager - START -->

<div class="container pb-filemng-template">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <nav class="navbar navbar-default pb-filemng-navbar">
                <div class="container-fluid">
                    <!-- Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="pull-left navbar-toggle collapsed treeview-toggle-btn" data-toggle="collapse" data-target="#treeview-toggle" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#options" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="fa fa-gears"></span>
                        </button>

                        <!-- Search button -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#pb-filemng-navigation" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="fa fa-share"></span>
                        </button>
                    </div>

                    <ul class="collapse navbar-collapse nav navbar-nav navbar-right" id="options">
                        <li><a href="#"><span class="fa fa-crosshairs fa-lg"></span></a></li>
                        <li><a href="#"><span class="fa fa-ellipsis-v fa-lg"></span></a></li>
                        <li><a href="#"><span class="fa fa-lg fa-server"></span></a></li>
                        <li><a href="#"><span class="fa fa-lg fa-minus"></span></a></li>
                        <li><a href="#"><span class="fa fa-lg fa-window-maximize"></span></a></li>
                        <li><a href="#"><span class="fa fa-lg fa-times"></span></a></li>
                    </ul>


                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="pb-filemng-navigation">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><span class="fa fa-chevron-left fa-lg"></span></a></li>
                            <li><a href="#"><span class="fa fa-chevron-right fa-lg"></span></a></li>
                            <li class="pb-filemng-active"><a href="#"><span class="fa fa-file fa-lg"></span></a></li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->

                </div>
                <!-- /.container-fluid -->
            </nav>
            <div class="panel panel-default">
                <div class="panel-body pb-filemng-panel-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-4 pb-filemng-template-treeview">
                            <div class="collapse navbar-collapse" id="treeview-toggle">
                                <div id="treeview">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-8 pb-filemng-template-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pb-filemng-template {
	    margin-top: 40px;
	    font-family: 'Sansita', sans-serif;
    }

    .pb-filemng-navbar {
	    margin-bottom: 0;
    }

    .treeview-toggle-btn {
	    margin-left: 15px;
    }

    .pb-filemng-template-btn {
	    background-color: Transparent;
        background-repeat:no-repeat;
        border: none;
        cursor:pointer;
        outline:none;
        color: gray;
        padding: 0px 13px 0px 13px;
    }

    .pb-filemng-active {
	    border-bottom: 2px solid #6d97db;
	    color: #5f6977;
    }

    .pb-filemng-template-btn:hover {
	    color: blue;
    }

    .pb-filemng-body-folders > img:hover {
	    cursor: pointer;
    }

    .btn-align {
	    margin-top: 7px;
    }

    .pb-filemng-template-treeview {
	    border-right: 1px solid gray;
    }

    .pb-filemng-folder {
	    color: orange;
	    padding-bottom: 3px;
    }

    .pb-filemng-paragraphs {
	    margin-top: -20px;
	    text-align: center;
    }

    .img-responsive {
	    margin: 0 auto;
    }

@media screen and (max-width: 767px) {

	.pb-filemng-template-treeview {
		border-right: none;
	}

	#options {
		text-align: center;
	}

	#options > li {
		display: inline-block;
	}

	#pb-filemng-navigation > ul {
		text-align: center;
	}

	#pb-filemng-navigation > ul > li {
		display: inline-block;
	}

}
</style>

<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript" src="http://www.prepbootstrap.com/Content/data/fileManagerData.js"></script>

<script>
    $(function () {
        $("#treeview").shieldTreeView({
            dataSource: dataSrc
        });

        for (var key in folderData) {
            $(".pb-filemng-template-body").append(
                '<div class=\"col-xs-6 col-sm-6 col-md-3 pb-filemng-body-folders\">' +
                folderData[key].icon + '<br />' + 
                '<p class="pb-filemng-paragraphs">' + folderData[key].text + '</p>' + 
                '</div>'
            );
        }
    })
</script>
<!-- File Manager - END -->

</div>

</body>
</html>