<?php /* Smarty version Smarty-3.0.8, created on 2020-01-21 16:26:25
         compiled from "./assets/themes\internal/complains.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2055e270a112c15b9-64224391%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' =>
  array (
    'cc1846526a91c8c4c936bebdf0f8a5073c96a949' =>
    array (
      0 => './assets/themes\\internal/complains.tpl',
      1 => 1579616780,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2055e270a112c15b9-64224391',
  'function' =>
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
          	<?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
          		<input type="hidden" value="complains" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['complains'];?>
" id="lang_name">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['complains'];?>
" id="sheet">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['delete_alarm_massage_in_woman'];?>
" id="lang_del">
               <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['status_alarm_massage_in_woman'];?>
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
						<?php if ($_smarty_tpl->getVariable('success')->value){?><div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div><?php }?>
							<section class="panel"><?php echo $_smarty_tpl->getVariable('export')->value;?>

							<div class="panel-heading no-b">
								<h5> <?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <b> <?php echo $_smarty_tpl->getVariable('lang')->value['complains'];?>
 </b></h5>
								<br>
								<input id="myInput" type="text" class="form-control" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
">
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="tableau_eleves table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['from_user'];?>
</th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['complain'];?>
</th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
 </th>
										</tr>
									</thead>
									<tbody id="myTable">
										<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('u')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
?>
											<tr id="tr_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
">
                                                <td><a href="complains.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
</a></td>
                                                <td><?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('c')->value['user_from'],'b'=>"users",'c'=>"getUsersInformation",'d'=>"name"),$_smarty_tpl);?>

													</td>
<!--
												<td><?php echo $_smarty_tpl->getVariable('c')->value['user_from'];?>
</td>
-->
												<td><?php echo $_smarty_tpl->getVariable('c')->value['complain'];?>
</td>
												<td><?php echo $_smarty_tpl->getVariable('c')->value['date'];?>
</td>
											</tr>
										<?php }} ?>
									</tbody>

								</table>
							</div>
							</div>
						</section>

					</div>
				</div>
<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='view'){?>
          		<input type="hidden" value="complains" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['complains'];?>
" id="lang_name">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['delete_alarm_massage_in_woman'];?>
" id="lang_del">
          		<ol class="breadcrumb hidden-print">
					<li>
						<a href="index.html"><i class="ti-home ml5"></i><?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a>
					</li>
					<li class="active"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</li>
				</ol>
				<div class="row">
					<div class="col-lg-12">
					<?php if ($_smarty_tpl->getVariable('success')->value){?>
						<div class="alert alert-success"><?php echo $_smarty_tpl->getVariable('success')->value;?>
</div>
					<?php }else{ ?>
						<?php if ($_smarty_tpl->getVariable('errors')->value){?>
							<div class="alert alert-danger">
								<ul>
								<?php  $_smarty_tpl->tpl_vars["e"] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["e"]->key => $_smarty_tpl->tpl_vars["e"]->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars["e"]->key;
?>
									<li><strong><?php echo $_smarty_tpl->getVariable('e')->value;?>
</strong></li>
								<?php }} ?>
								</ul>
							</div>
						<?php }?>
					<?php }?>
					<section class="panel">
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['complains_details'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['from_user'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('u')->value['user_from'],'b'=>"users",'c'=>"getUsersInformation",'d'=>"name"),$_smarty_tpl);?>
 </span>
							</div>
							<!--<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['user_from'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['user_from'];?>
 </span>
							</div>-->
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['complain'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['complain'];?>
 </span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['date'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['date'];?>
 </span>
							</div>


							<div class="form-group" id="item_<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
								<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();"style="margin-<?php echo $_smarty_tpl->getVariable('lang')->value['dir_fe'];?>
: 20px"><?php echo $_smarty_tpl->getVariable('lang')->value['print'];?>
</a>
							</div>
						</div>
					</section>
					</div>
				</div>
			<?php }?>
