<?php /* Smarty version Smarty-3.0.8, created on 2020-01-16 18:00:50
         compiled from "./assets/themes\footinc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2625e2088b27ad862-01667558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18000d6225ce9ea4a2fd693cc021f496b66b0692' => 
    array (
      0 => './assets/themes\\footinc.tpl',
      1 => 1568645084,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2625e2088b27ad862-01667558',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<!-- core scripts -->
<!--    <script src="./assets/plugins/jquery-1.11.1.min.js"></script>-->
    <script src="./assets/bootstrap/js/bootstrap.js"></script>
    <script src="./assets/plugins/jquery.slimscroll.min.js"></script>
    <script src="./assets/plugins/jquery.easing.min.js"></script>
    <script src="./assets/plugins/appear/jquery.appear.js"></script>
    <script src="./assets/plugins/jquery.placeholder.js"></script>
    <script src="./assets/plugins/fastclick.js"></script>
    <!-- /core scripts -->

    <!-- page level scripts -->
    <script src="./assets/plugins/jquery.blockUI.js"></script>
    <script src="./assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="./assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="./assets/plugins/jquery.sparkline.js"></script>
    <script src="./assets/plugins/flot/jquery.flot.js"></script>
    <script src="./assets/plugins/flot/jquery.flot.resize.js"></script>
    <script src="./assets/plugins/count-to/jquery.countTo.js"></script>

    <!-- /page level scripts -->

    <!-- page script -->
	<?php if (is_array($_smarty_tpl->getVariable('footJs')->value)){?>
	<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('footJs')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
?><script type="text/javascript" src="./assets/js/<?php echo $_smarty_tpl->getVariable('c')->value;?>
?v=<?php echo $_smarty_tpl->getVariable('pagetime')->value;?>
"></script>
	<?php }} ?>
	<?php }else{ ?>
		<?php echo $_smarty_tpl->getVariable('footJs')->value;?>

	<?php }?>
    <!-- /page script -->

    <!-- template scripts -->
    <script src="./assets/js/offscreen.js"></script>

    <script src="./assets/js/main.js"></script>
    <!-- /template scripts -->
