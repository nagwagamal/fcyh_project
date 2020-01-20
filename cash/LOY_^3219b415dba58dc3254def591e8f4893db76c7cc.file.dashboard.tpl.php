<?php /* Smarty version Smarty-3.0.8, created on 2020-01-16 18:00:50
         compiled from "./assets/themes\internal/dashboard.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40655e2088b22307c5-44035618%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3219b415dba58dc3254def591e8f4893db76c7cc' => 
    array (
      0 => './assets/themes\\internal/dashboard.tpl',
      1 => 1574262488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40655e2088b22307c5-44035618',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
   <?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
	<input type="hidden" value="location" id="page">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['product'];?>
" id="lang_name">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['location'];?>
" id="sheet">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['delete_alarm_massage_in_men'];?>
" id="lang_del">
	<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['status_alarm_massage_in_men'];?>
" id="lang_status">
   
	<ol class="breadcrumb">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
		</li>
		<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
	</ol>
	<div class="row mt">
		<div class="col-md-12">
			<section class=""><?php echo $_smarty_tpl->getVariable('export')->value;?>

				<div class="panel-heading no-b">
					
				</div>
				<div class="panel-body col-m-8" style='background-color: white;width: 422px;'>
						<h4><?php echo $_smarty_tpl->getVariable('lang')->value['rep_no_location'];?>
</h4>
					<div class="table-responsive">
						<div class="table-wrapper-scroll-y my-custom-scrollbar" style="position: relative;height: 200px;overflow: auto;">
							<?php if ($_smarty_tpl->getVariable('u')->value){?>
							<table class="table table-bordered table-striped mb-0">
								<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col"><?php echo $_smarty_tpl->getVariable('lang')->value['reps'];?>
</th>
									<th scope="col"><?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
</th>
									<th scope="col"><?php echo $_smarty_tpl->getVariable('lang')->value['time'];?>
</th>
								</tr>
								</thead>
									<tbody>
									<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars["k"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('u')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
 $_smarty_tpl->tpl_vars["k"]->value = $_smarty_tpl->tpl_vars["c"]->key;
?>
										<tr>
											<th scope="row"><?php echo $_smarty_tpl->getVariable('k')->value+1;?>
</th>
											<td><a href="tel:<?php echo $_smarty_tpl->getVariable('c')->value['mobile'];?>
" style="font-size: 17px;color: black;"> <?php echo $_smarty_tpl->getVariable('c')->value['name'];?>
 </a></td>
											<td><?php echo $_smarty_tpl->getVariable('c')->value['D'];?>
</td>
											<td><?php echo _time_format($_smarty_tpl->getVariable('c')->value['T']);?>
</td>
										</tr>
										
									<?php }} ?>
									</tbody>
							</table>
							<?php }else{ ?>
								<?php echo $_smarty_tpl->getVariable('lang')->value['no_close_location'];?>
		
							<?php }?>

						</div>
				
					</div>
				</div>
				
			</section>
		</div>
	</div>
<?php }?>