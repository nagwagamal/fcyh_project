<?php /* Smarty version Smarty-3.0.8, created on 2020-01-23 12:28:43
         compiled from "./assets/themes\internal/tasks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:285885e29755be7d556-99377210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' =>
  array (
    'a41dee31151d42684860863a98b4908b2cde62d4' =>
    array (
      0 => './assets/themes\\internal/tasks.tpl',
      1 => 1579775318,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '285885e29755be7d556-99377210',
  'function' =>
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('area_name')->value=='add'){?>
        <ol class="breadcrumb">
            <li><a href="index.html"><i class="ti-home ml5"></i>
                <?php echo $_smarty_tpl->getVariable('lang')->value['NDX_PAGE_NAME'];?>
</a></li>
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
                            <header class="panel-heading">
                            <div class="panel-body">
                            <form class="form-horizontal" action="tasks.php?do=add"  role="form" method="post"enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="enter the title" name="title" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['title'];?>
<?php }?>">
                                    </div>
                                    <label class="col-sm-2 control-label">
                                    <?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</label>
                                </div>
                             <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="category">
										<option value="0" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['choose_category'];?>
</option>
										<?php  $_smarty_tpl->tpl_vars["_c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('c')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_c"]->key => $_smarty_tpl->tpl_vars["_c"]->value){
?>
											<option value="<?php echo $_smarty_tpl->getVariable('_c')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('n')->value['cat_name']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['cat_name'];?>
</option>
										<?php }} ?>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
</label>
							</div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="description" class="form-control" placeholder="enter the description" name="description" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['description'];?>
<?php }?>">
                                    </div>
                                    <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['description'];?>

                                    </label>
                                </div>
                                <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="category">
										<option value="0" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['choose_user'];?>
</option>
										<?php  $_smarty_tpl->tpl_vars["_p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('p')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_p"]->key => $_smarty_tpl->tpl_vars["_p"]->value){
?>
											<option value="<?php echo $_smarty_tpl->getVariable('_p')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('n')->value['user_name']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('_p')->value['name'];?>
</option>
										<?php }} ?>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['user_task_name'];?>
</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="assigned">
										<option value="0" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['choose_user'];?>
</option>
										<?php  $_smarty_tpl->tpl_vars["_p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('p')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_p"]->key => $_smarty_tpl->tpl_vars["_p"]->value){
?>
											<option value="<?php echo $_smarty_tpl->getVariable('_p')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('n')->value['user_name']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('_p')->value['name'];?>
</option>
										<?php }} ?>
									</select>
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['user_assigned_name'];?>
</label>
							</div>
                         <div class="form-group">
								<div class="col-sm-10">
								<input  autocomplete="off" class="date form-control"  placeholder="dd/mm/yyyy" name="requested_time">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['requested_time'];?>
</label>
							</div>
                                <div class="form-group">
								<div class="col-sm-10">
								<input  autocomplete="off" class="date form-control"  placeholder="dd/mm/yyyy" name="arrived_time">
								</div>
								<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['arrived_time'];?>
</label>
							</div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="description" class="form-control" placeholder="enter the total_time" name="total_time" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['total_time'];?>
<?php }?>">
                                    </div>
                                    <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['total_time'];?>

                                    </label>
                                </div>
                                 <div class="form-group">
                                    <div class="col-sm-10">
                                        <input type="description" class="form-control" placeholder="enter the review" name="review" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['review'];?>
<?php }?>">
                                    </div>
                                    <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['review'];?>

                                    </label>
                                </div>
                                <div class="form-group">
								<div class="col-sm-10"><button type="submit" class="btn btn-default"><?php echo $_smarty_tpl->getVariable('lang')->value['add_tasks'];?>
</button></div>
							</div>
                            </form>
                            </div>
                            </header>
                        </section>

<?php }?>
