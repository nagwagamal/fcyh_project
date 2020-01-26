<?php /* Smarty version Smarty-3.0.8, created on 2020-01-26 12:48:54
         compiled from "./assets/themes\headinc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:282495e2d6e9600f0f3-30976505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28d2e39e0d1642f636b9277bb4d4c6541b9a39df' => 
    array (
      0 => './assets/themes\\headinc.tpl',
      1 => 1580035484,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '282495e2d6e9600f0f3-30976505',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<!-- page level plugin styles -->
    <link rel="stylesheet" href="./assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- /page level plugin styles -->

    <!-- core styles -->

    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min_<?php echo $_smarty_tpl->getVariable('lang')->value['DEFAULT'];?>
.css">
    <link rel="stylesheet" href="./assets/css/font-awesome.css">
    <link rel="stylesheet" href="./assets/css/themify-icons.css">
    <link rel="stylesheet" href="./assets/css/animate.min.css">
    <link rel="stylesheet" href="./assets/css/jquery.datetimepicker.min.css">
    <!-- /core styles -->

    <!-- template styles -->
    <link rel="stylesheet" href="./assets/css/skins/palette.css" id="skin">
    <link rel="stylesheet" href="./assets/css/fonts/font.css">
    <link rel="stylesheet" href="./assets/css/main_<?php echo $_smarty_tpl->getVariable('lang')->value['DEFAULT'];?>
.css">
    <link rel="stylesheet" href="./assets/dist/summernote-bs4.css">
    <link rel="stylesheet" href="./assets/css/mystyle.css">

    <!-- template styles -->
    <?php echo $_smarty_tpl->getVariable('headCss')->value;?>



    <script src="./assets/plugins/modernizr.js"></script>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/jquery.datetimepicker.full.js"></script>
         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
    <script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.5/umd/popper.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

	<!--  exporter pdt xlxs ---->
  	<link href="./assets/css/export/tableexport.min.css" rel="stylesheet" type="text/css"/>
   	<script type="text/javascript"   src="./assets/js/exporter/pdfmake.min.js"></script>
	<script type="text/javascript"   src="./assets/js/exporter/mirza_fonts.js"></script>
	<script type="text/javascript"   src="./assets/js/exporter/FileSaver.min.js"></script>
	<script type="text/javascript"   src="./assets/js/exporter/jspdf.min.js"></script>
	<script type="text/javascript"   src="./assets/js/exporter/xlsx.core.min.js"></script>
	<script type="text/javascript"   src="./assets/js/exporter/jspdf.plugin.autotable.js"></script>
	<script type="text/javascript"   src="./assets/js/exporter/tableExport.js"></script>
<!--	<script type="text/javascript"   src="./assets/js/exporter/tableexport.min.js"></script>-->


    <?php echo $_smarty_tpl->getVariable('headJs')->value;?>


