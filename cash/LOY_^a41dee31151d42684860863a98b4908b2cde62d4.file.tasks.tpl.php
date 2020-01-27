<?php /* Smarty version Smarty-3.0.8, created on 2020-01-26 16:32:20
         compiled from "./assets/themes\internal/tasks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19145e2da2f49fbaf0-93534950%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' =>
  array (
    'a41dee31151d42684860863a98b4908b2cde62d4' =>
    array (
      0 => './assets/themes\\internal/tasks.tpl',
      1 => 1580049137,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19145e2da2f49fbaf0-93534950',
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
                    <form class="form-horizontal" action="tasks.php?do=add" role="form" method="post" enctype="multipart/form-data">
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
" <?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('n')->value['cat_name']){?>selected="selected" <?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['cat_name'];?>
 </option> <?php }} ?> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
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
                                    <input type="file" class="form-control" name="img" value="">
                                </div>
                                <label class="col-sm-2 control-label"> <?php echo $_smarty_tpl->getVariable('lang')->value['image'];?>
 </label>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <select class="form-control" name="user_task">
                                        <option value="0" selected="selected"><?php echo $_smarty_tpl->getVariable('lang')->value['choose_user'];?>
</option>
                                        <?php  $_smarty_tpl->tpl_vars["_p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('p')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_p"]->key => $_smarty_tpl->tpl_vars["_p"]->value){
?>
                                        <option value="<?php echo $_smarty_tpl->getVariable('_p')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('n')->value['user_name']){?>selected="selected" <?php }?>><?php echo $_smarty_tpl->getVariable('_p')->value['name'];?>
 </option> <?php }} ?> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['user_task_name'];?>
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
" <?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('n')->value['user_name']){?>selected="selected" <?php }?>><?php echo $_smarty_tpl->getVariable('_p')->value['name'];?>
 </option> <?php }} ?> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['user_assigned_name'];?>
</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input autocomplete="off" class="date form-control" placeholder="dd/mm/yyyy" name="requested_time">
                                        </div>
                                        <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['requested_time'];?>
</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input autocomplete="off" class="date form-control" placeholder="dd/mm/yyyy" name="arrived_time">
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
        <?php }elseif($_smarty_tpl->getVariable('area_name')->value=='list'){?>
        <input type="hidden" value="tasks" id="page">
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['tasks'];?>
" id="lang_name">
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['tasks'];?>
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
 <b> <?php echo $_smarty_tpl->getVariable('lang')->value['tasks'];?>
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
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['description'];?>
</th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
</th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['user_task_name'];?>
 </th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['user_assigned_name'];?>
 </th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['requested_time'];?>
 </th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['arrived_time'];?>
 </th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['total_time'];?>
 </th>
                                        <th><?php echo $_smarty_tpl->getVariable('lang')->value['review'];?>
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
                                            <a href="tasks.html?do=view&id=<?php echo $_smarty_tpl->getVariable('c')->value['id'];?>
"><?php echo $_smarty_tpl->getVariable('c')->value['tittle'];?>
</a> <br />
                                        </td>
                                        <td><?php echo $_smarty_tpl->getVariable('c')->value['description'];?>
</td>
                                        <td>
                                            <?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('c')->value['cat_id'],'b'=>"categories",'c'=>"getCategoriesInformation",'d'=>"cat_name"),$_smarty_tpl);?>

                                        </td>
                                        <td>
                                            <?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('c')->value['assiged_to'],'b'=>"users",'c'=>"getUsersInformation",'d'=>"name"),$_smarty_tpl);?>

                                        </td>
                                        <td>
                                            <?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('c')->value['user_id'],'b'=>"users",'c'=>"getUsersInformation",'d'=>"name"),$_smarty_tpl);?>

                                        </td>
                                        <td><?php echo $_smarty_tpl->getVariable('c')->value['requested_time'];?>

                                        </td>
                                        <td><?php echo $_smarty_tpl->getVariable('c')->value['arrived_time'];?>
</td>
                                        <td><?php echo $_smarty_tpl->getVariable('c')->value['total_time'];?>
</td>
                                        <td><?php echo $_smarty_tpl->getVariable('c')->value['review'];?>
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
                                        <td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="tasks.html?do=add"><?php echo $_smarty_tpl->getVariable('lang')->value['add_tasks'];?>
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
        <?php }elseif($_smarty_tpl->getVariable('area_name')->value=='view'){?>
        <input type="hidden" value="tasks" id="page">
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('lang')->value['tasks'];?>
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
                    <header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['tasks_details'];?>
 ( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="tasks.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
">
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['tittle'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['description'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['description'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['image'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><a target="_blank" href="<?php echo $_smarty_tpl->getVariable('u')->value['img'];?>
"><img style="border-radius:5px;" src="<?php echo $_smarty_tpl->getVariable('u')->value['img'];?>
" width="80" /></a></span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('u')->value['cat_id'],'b'=>"categories",'c'=>"getCategoriesInformation",'d'=>"cat_name"),$_smarty_tpl);?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['user_assigned_name'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('u')->value['assiged_to'],'b'=>"users",'c'=>"getUsersInformation",'d'=>"name"),$_smarty_tpl);?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['user_task_name'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo getFromTable(array('a'=>$_smarty_tpl->getVariable('u')->value['user_id'],'b'=>"users",'c'=>"getUsersInformation",'d'=>"name"),$_smarty_tpl);?>
 </span>
                            </div>

                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['lon'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['lon'];?>
 </span>
                            </div>

                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['lat'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['lat'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['requested_time'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['requested_time'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['arrived_time'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['arrived_time'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['total_time'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['total_time'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong><?php echo $_smarty_tpl->getVariable('lang')->value['review'];?>
 : </strong></span>
                                <span style="width:80%;display:inline-block;"><?php echo $_smarty_tpl->getVariable('u')->value['review'];?>
 </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> <?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
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
                    <header class="panel-heading"> <?php echo $_smarty_tpl->getVariable('lang')->value['edit_tasks'];?>
( # <?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
 )</header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="tasks.html?do=update&id=<?php echo $_smarty_tpl->getVariable('u')->value['id'];?>
" enctype="multipart/form-data">

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tittle" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['tittle'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['tittle'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['tittle'];?>
<?php }?>">
                                </div>
                                <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="description" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['description'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['description'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['description'];?>
<?php }?>">
                                </div>
                                <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['description'];?>
</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="img" value="">
                                    <?php if ($_smarty_tpl->getVariable('u')->value['img']){?><p class="help-block"><a target="_blank" href="<?php echo $_smarty_tpl->getVariable('u')->value['img'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['show_image'];?>
</a></p><?php }?>
                                </div>
                                <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['image'];?>
</label>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <select class="form-control" name="category">
                                        <?php  $_smarty_tpl->tpl_vars["_c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('c')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_c"]->key => $_smarty_tpl->tpl_vars["_c"]->value){
?>
                                        <option value="<?php echo $_smarty_tpl->getVariable('_c')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('n')->value['cat_name']){?>selected="selected" <?php }?><?php }else{ ?> <?php if ($_smarty_tpl->getVariable('_c')->value['id']==$_smarty_tpl->getVariable('u')->value['cat_id']){?>selected="selected" <?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('_c')->value['cat_name'];?>
 </option> <?php }} ?> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['category'];?>
</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <select class="form-control" name="user_id">
                                            <?php  $_smarty_tpl->tpl_vars["_p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('p')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_p"]->key => $_smarty_tpl->tpl_vars["_p"]->value){
?>
                                            <option value="<?php echo $_smarty_tpl->getVariable('_p')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('n')->value['user_id']){?>selected="selected" <?php }?><?php }else{ ?> <?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('u')->value['user_id']){?>selected="selected" <?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('_p')->value['name'];?>
 </option> <?php }} ?> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['user_task_name'];?>
</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <select class="form-control" name="assiged_to">
                                                <?php  $_smarty_tpl->tpl_vars["_p"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('p')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["_p"]->key => $_smarty_tpl->tpl_vars["_p"]->value){
?>
                                                <option value="<?php echo $_smarty_tpl->getVariable('_p')->value['id'];?>
" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('n')->value['assiged_to']){?>selected="selected" <?php }?><?php }else{ ?> <?php if ($_smarty_tpl->getVariable('_p')->value['id']==$_smarty_tpl->getVariable('u')->value['assiged_to']){?>selected="selected" <?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('_p')->value['name'];?>
 </option> <?php }} ?> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['user_assigned_name'];?>
</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="lon" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['lon'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['lon'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['lon'];?>
<?php }?>">
                                            </div>
                                            <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['lon'];?>
</label>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="lat" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['lat'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['lat'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['lat'];?>
<?php }?>">
                                            </div>
                                            <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['lat'];?>
</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="requested_time" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['requested_time'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['requested_time'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['requested_time'];?>
<?php }?>">
                                            </div>
                                            <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['requested_time'];?>
</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="arrived_time" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['arrived_time'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['arrived_time'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['arrived_time'];?>
<?php }?>">
                                            </div>
                                            <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['arrived_time'];?>
</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="total_time" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['total_time'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['total_time'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['total_time'];?>
<?php }?>">
                                            </div>
                                            <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['total_time'];?>
</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="review" placeholder="<?php echo $_smarty_tpl->getVariable('lang')->value['review'];?>
" value="<?php if ($_smarty_tpl->getVariable('n')->value){?><?php echo $_smarty_tpl->getVariable('n')->value['review'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('u')->value['review'];?>
<?php }?>">
                                            </div>
                                            <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['review'];?>
</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <select class="form-control" name="status">
                                                    <option value="0" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['status']==0){?>selected="selected" <?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['status']==0){?>selected="selected" <?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['deactive'];?>
 </option> <option value="1" <?php if ($_smarty_tpl->getVariable('n')->value){?><?php if ($_smarty_tpl->getVariable('n')->value['status']==1){?>selected="selected" <?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('u')->value['status']==1){?>selected="selected" <?php }?><?php }?>><?php echo $_smarty_tpl->getVariable('lang')->value['active'];?>
 </option> </select> </div> <label class="col-sm-2 control-label"><?php echo $_smarty_tpl->getVariable('lang')->value['status'];?>
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
        <?php }?>
