<?php /* Smarty version Smarty-3.0.8, created on 2020-01-22 16:13:24
         compiled from "./assets/themes\internal/cities.tpl" */ ?>
<?php /*%%SmartyHeaderCode:36875e28588485b264-16855823%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '879a0326e7d8b441e58f6b4586db62896b2536bf' => 
    array (
      0 => './assets/themes\\internal/cities.tpl',
      1 => 1579701548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36875e28588485b264-16855823',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
          	<?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
          		<input type="hidden" value="cities" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
" id="lang_name">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['cities'];?>
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
 <b> <?php echo $_smarty_tpl->getVariable('lang')->value['cities'];?>
  </b></h5>
								<br>
								<input id="myInput" type="text" class="form-control" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['search'];?>
">
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="tableau_eleves table table-bordered table-striped">
									<?php if ($_smarty_tpl->getVariable('u')->value){?>
										<thead>
											<tr>
												<th>#</th>
												<th><?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
</th>
												<th><?php echo $_smarty_tpl->getVariable('lang')->value['governorate'];?>
</th>
												<th> <?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
 </th>
												<?php if ($_smarty_tpl->getVariable('group')->value['cities_edit']=="1"||$_smarty_tpl->getVariable('group')->value['cities_delete']=="1"){?>
													<th><?php echo $_smarty_tpl->getVariable('lang')->value['settings'];?>
</th>
												<?php }?>
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
													<td><?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
</td>
													<td>
														<a href="cities.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('c')->value['city_name_ar'];?>
 - <?php echo $_smarty_tpl->getVariable('c')->value['city_name'];?>
</a> <br />
													</td>
													<td>
														<?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('c')->value['gov_id'],'b'=>"governorates",'c'=>"getGovernoratesInformation",'d'=>"gov_name_ar"),$_smarty_tpl);?>
 - <?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('c')->value['gov_id'],'b'=>"governorates",'c'=>"getGovernoratesInformation",'d'=>"gov_name"),$_smarty_tpl);?>

													</td>
													<td>
														<span <?php if ($_smarty_tpl->getVariable('group')->value['cities_active']==1){?> id="active_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" class="sta_<?php echo $_smarty_tpl->getVariable('c')->value['status'];?>
 <?php }?>">
														<?php if ($_smarty_tpl->getVariable('c')->value['status']==1){?>
														<a class="badge bg-success status_deactive" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"  title="<?php echo $_smarty_tpl->getVariable('lang')->value['deactivation'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</a>
														<?php }else{ ?><a class="badge bg-danger status_active" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['activation'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
 </a>
														<?php }?>
													</span>
													<?php if ($_smarty_tpl->getVariable('group')->value['cities_edit']==1||$_smarty_tpl->getVariable('group')->value['cities_delete']==1){?>
													</td>
														<td id="item_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
">
															<?php if ($_smarty_tpl->getVariable('group')->value['cities_edit']==1){?>
																<button class="btn btn-primary btn-xs edit" title="<?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
"><i class="fa fa-pencil"></i></button>
															<?php }?>
															<?php if ($_smarty_tpl->getVariable('group')->value['cities_delete']==1){?>
																<button class="btn btn-danger btn-xs delete" title="<?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
"><i class="fa fa-trash-o"></i></button>
															<?php }?>
														</td>
													<?php }?>
												</tr>
											<?php }} ?>
										</tbody>
										<?php }else{ ?><tr><td align="center" colspan="5"><b><?php echo $_smarty_tpl->getVariable('lang')->value['no_cities'];?>
</b></td></tr><?php }?>
										<tfoot>
											<tr>
											<?php if ($_smarty_tpl->getVariable('group')->value['cities_edit']==1||$_smarty_tpl->getVariable('group')->value['cities_delete']==1){?>
												<?php if ($_smarty_tpl->getVariable('group')->value['cities_add']==1){?>
													<td colspan="4" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
													<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="cities.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_city'];?>
</a></td>
													<?php }else{ ?>
													<td colspan="5" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
													<?php }?>
											<?php }else{ ?>
												<?php if ($_smarty_tpl->getVariable('group')->value['cities_add']==1){?>
													<td colspan="3" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
													<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="cities.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_city'];?>
</a></td>
												<?php }else{ ?>
													<td colspan="4" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
												<?php }?>
											<?php }?>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</section>
					</div>
				</div>
          	<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='edit'){?>
          		<ol class="breadcrumb">
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['edit_city'];?>
  ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="cities.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="city_name_ar" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name_by_arabic'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['city_name_ar'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['city_name_ar'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name_by_arabic'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="city_name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['no_name_by_english'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['city_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['city_name'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name_by_english'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="governorate">
										<?php  $_smarty_tpl->tpl_vars["_c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('c')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_c"]->key => $_smarty_tpl->tpl_vars["_c"]->value){
?>
											<option value="<?php echo $_smarty_tpl->getVariable('_c')->value['id'];?>
"<?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('n')->value['gov_id']){?>selected="selected"<?php }?><?php }else{ ?> <?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('u')->value['gov_id']){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['gov_name_ar'];?>
 - <?php echo $_smarty_tpl->getVariable('_c')->value['gov_name'];?>
 </option>
										<?php }} ?>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['governorate'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="status">
										<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['status']==0){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['status']==0){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
</option>
										<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['status']==1){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['status']==1){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</option>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
</label>
							</div>
							<div class="form-group">
								<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['update'];?>
</button></div>
							</div>
						</form>
						</div>
					</section>
					</div>
				</div>
          	<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='view'){?>
          		<input type="hidden" value="cities" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
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
						<header class="panel-heading">  <?php echo $_smarty_tpl->getVariable('lang')->value['city_details'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="cities.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['city_name_ar'];?>
 - <?php echo $_smarty_tpl->getVariable('u')->value['city_name'];?>
</span>
							</div>


							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['governorate'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('u')->value['governorate'],'b'=>"governorates",'c'=>"getGovernoratesInformation",'d'=>"gov_name_ar"),$_smarty_tpl);?>
 - <?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('u')->value['governorate'],'b'=>"governorates",'c'=>"getGovernoratesInformation",'d'=>"gov_name"),$_smarty_tpl);?>
</span>
							</div>
							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['status']==0){?><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
<?php }?></span>
							</div>
							<div class="form-group" id="item_<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
								<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-<?php echo $_smarty_tpl->getVariable('lang')->value['dir_fe'];?>
: 20px"><?php echo $_smarty_tpl->getVariable('lang')->value['print'];?>
</a>
								<?php if ($_smarty_tpl->getVariable('group')->value['cities_edit']==1){?>
									<a class="hidden-print btn btn-warning btn-sm" href="cities.html?do=edit&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
 </a>
								<?php }?>
								<?php if ($_smarty_tpl->getVariable('group')->value['cities_delete']==1){?>
									<a class="hidden-print btn btn-danger btn-sm delete" href="cities.html?do=del&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
 </a>
								<?php }?>
							</div>
						</form>
						</div>
					</section>
					</div>
				</div>
          	<?php }elseif($_smarty_tpl->getVariable('area_name')->value=='add'){?>
				<ol class="breadcrumb">
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['add_city'];?>
</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="cities.html?do=add" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="city_name_ar" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name_by_arabic'];?>
" value="<?php echo $_smarty_tpl->getVariable('n')->value['city_name_ar'];?>
" >
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name_by_arabic'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="city_name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name_by_english'];?>
" value="<?php echo $_smarty_tpl->getVariable('n')->value['city_name'];?>
" >
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name_by_english'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="governorate">
										<option value="0" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['choose_governorate'];?>
</option>
										<?php  $_smarty_tpl->tpl_vars["_c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('c')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_c"]->key => $_smarty_tpl->tpl_vars["_c"]->value){
?>
											<option value="<?php echo $_smarty_tpl->getVariable('_c')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('n')->value['governorate']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['gov_name_ar'];?>
 - <?php echo $_smarty_tpl->getVariable('_c')->value['gov_name'];?>
</option>
										<?php }} ?>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['governorate'];?>
</label>
							</div>
							<div class="form-group">
								<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['add_city'];?>
</button></div>
							</div>
						</form>
						</div>
					</section>
					</div>
				</div>
			<?php }?>

<!--
			<?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
<ul style="list-style-type:none;" >
	<li><a href="#" class="pdf btn btn-default  txt" style="float: left;margin:5px">Export to PDF</a></li>
	<li><a href="#" class="csv btn btn-default " style="float: left">Export to xlxs</a></li>
</ul>
<?php }?>
-->
