<?php /* Smarty version Smarty-3.0.8, created on 2020-01-21 15:49:55
         compiled from "./assets/themes\internal/users.tpl" */ ?>
<?php /*%%SmartyHeaderCode:835e26e9e860fcb1-04811737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' =>
  array (
    '6a2d9f96a14b85ecced274b00cd3f35f1badd744' =>
    array (
      0 => './assets/themes\\internal/users.tpl',
      1 => 1579609408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '835e26e9e860fcb1-04811737',
  'function' =>
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
          	<?php if ($_smarty_tpl->getVariable('area_name')->value=='list'){?>
          		<input type="hidden" value="users" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
" id="lang_name">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
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
 <b> <?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
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
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
</th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
</th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['email_verified'];?>
 </th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['mobile'];?>
 </th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['mobile_verified'];?>
 </th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
 </th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['address'];?>
 </th>
											<th><?php echo $_smarty_tpl->getVariable('lang')->value['volunteer'];?>
 </th>
											<?php if ($_smarty_tpl->getVariable('group')->value['governorates_edit']=="1"||$_smarty_tpl->getVariable('group')->value['governorates_delete']=="1"||$_smarty_tpl->getVariable('group')->value['cities_list']=="1"){?>
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
													<a href="users.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('c')->value['name'];?>
</a> <br />
												</td>
                                                <td><?php echo $_smarty_tpl->getVariable('c')->value['email'];?>
</td>
												<td>
													<?php if ($_smarty_tpl->getVariable('c')->value['email_verified']==1){?>
													<a class="badge bg-success status_deactive" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"  title="<?php echo $_smarty_tpl->getVariable('lang')->value['deactivation'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</a>
													<?php }else{ ?><a class="badge bg-danger status_active" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['activation'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
 </a>
													<?php }?>
												</td>
                                                <td><?php echo $_smarty_tpl->getVariable('c')->value['mobile'];?>
</td>
												<td>
													<?php if ($_smarty_tpl->getVariable('c')->value['mobile_verified']==1){?>
													<a class="badge bg-success status_deactive" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"  title="<?php echo $_smarty_tpl->getVariable('lang')->value['deactivation'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</a>
													<?php }else{ ?><a class="badge bg-danger status_active" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['activation'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
 </a>
													<?php }?>
												</td>
                                               <td><?php echo $_smarty_tpl->getVariable('c')->value['city'];?>
</td>
                                                <td><?php echo $_smarty_tpl->getVariable('c')->value['address'];?>
</td>
                                                <td>
													<?php if ($_smarty_tpl->getVariable('c')->value['volunteer']==1){?>
													<a class="badge bg-success status_deactive" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"  title="<?php echo $_smarty_tpl->getVariable('lang')->value['deactivation'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</a>
													<?php }else{ ?><a class="badge bg-danger status_active" id="<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['activation'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
 </a>
													<?php }?>
												</td>
											<?php if ($_smarty_tpl->getVariable('group')->value['governorates_edit']=="1"||$_smarty_tpl->getVariable('group')->value['governorates_delete']=="1"){?>
												<td id="item_<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
">
													<?php if ($_smarty_tpl->getVariable('group')->value['governorates_edit']==1){?>
														<button class="btn btn-primary btn-xs edit" title="<?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
"><i class="fa fa-pencil"></i></button>
													<?php }?>
													<?php if ($_smarty_tpl->getVariable('group')->value['governorates_delete']==1){?>
													<button class="btn btn-danger btn-xs delete" title="<?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
"><i class="fa fa-trash-o"></i></button>
													<?php }?>
												</td>
											<?php }?>
											</tr>
										<?php }} ?>
									</tbody>
									<tfoot>
										<tr>
										<?php if ($_smarty_tpl->getVariable('group')->value['governorates_edit']=="1"||$_smarty_tpl->getVariable('group')->value['governorates_delete']=="1"||$_smarty_tpl->getVariable('group')->value['cities_list']=="1"){?>
											<?php if ($_smarty_tpl->getVariable('group')->value['governorates_add']==1){?>
												<td colspan="3" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
												<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="users.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_user'];?>
</a></td>
											<?php }else{ ?>
												<td colspan="4" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
											<?php }?>
										<?php }else{ ?>
											<?php if ($_smarty_tpl->getVariable('group')->value['governorates_add']==1){?>
												<td colspan="2" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
</td>
												<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="users.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_user'];?>
</a></td>
											<?php }else{ ?>
												<td colspan="3" align="right"><?php echo $_smarty_tpl->getVariable('pager')->value;?>
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['edit_users'];?>
( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="users.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
" enctype="multipart/form-data">

							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['name'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
</label>
							</div>
                     <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['email'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['email'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
</label>
							</div>
                         <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email_key" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['email_key'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['email_key'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['email_key'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['email_key'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="email_verified">
										<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['email_verified']==0){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['email_verified']==0){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
</option>
										<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['email_verified']==1){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['email_verified']==1){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</option>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['email_verified'];?>
</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['mobile'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['mobile'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['mobile'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['mobile'];?>
</label>
							</div>
                         <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile_key" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['mobile_key'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['mobile_key'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['mobile_key'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['mobile_key'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="mobile_verified">
										<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['mobile_verified']==0){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['mobile_verified']==0){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
</option>
										<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['mobile_verified']==1){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['mobile_verified']==1){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</option>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['mobile_verified'];?>
</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="address" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['address'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['address'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['address'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['address'];?>
</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="volunteer">
										<option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['volunteer']==0){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['volunteer']==0){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
</option>
										<option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['volunteer']==1){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['volunteer']==1){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
</option>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['volunteer'];?>
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
          		<input type="hidden" value="users" id="page">
          		<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['users_details'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="users.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['name'];?>
 </span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['email'];?>
 </span>
							</div>

							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['email_verified'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['email_verified']==0){?><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
<?php }?></span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['mobile'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['mobile'];?>
 </span>
							</div>

							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['mobile_verified'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['mobile_verified']==0){?><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
<?php }?></span>
							</div>
                             <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['address'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['address'];?>
 </span>
							</div>

							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['volunteer'];?>
 : </strong></span>
								<span style="width:80%;display:inline-block;"><?php if ($_smarty_tpl->getVariable('u')->value['volunteer']==0){?><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
<?php }?></span>
							</div>

							<div class="form-group" id="item_<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
								<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();"style="margin-<?php echo $_smarty_tpl->getVariable('lang')->value['dir_fe'];?>
: 20px"><?php echo $_smarty_tpl->getVariable('lang')->value['print'];?>
</a>
								<?php if ($_smarty_tpl->getVariable('group')->value['governorates_edit']==1){?>
									<a class="hidden-print btn btn-warning btn-sm" href="users.html?do=edit&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['edit'];?>
</a>
								<?php }?>
								<?php if ($_smarty_tpl->getVariable('group')->value['governorates_delete']==1){?>
									<a class="hidden-print btn btn-danger btn-sm delete" href="users.html?do=del&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
"> <?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
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
						<header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['add_users'];?>
</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="users.html?do=add" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['name'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['name'];?>
</label>
							</div>
                       <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['email'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['email'];?>
</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email_key" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['email_key'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['email_key'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['email_key'];?>
</label>
							</div>
                       <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['mobile'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['mobile'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['mobile'];?>
</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile_key" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['mobile_key'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['mobile_key'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['mobile_key'];?>
</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="address" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['address'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['address'];?>
<?php }?>">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['address'];?>
</label>
							</div>
							<div class="form-group">
								<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['add_user'];?>
</button></div>
							</div>
						</form>
						</div>
					</section>
					</div>
				</div>
			<?php }?>
