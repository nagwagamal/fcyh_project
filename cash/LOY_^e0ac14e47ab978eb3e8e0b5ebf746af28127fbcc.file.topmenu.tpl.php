<?php /* Smarty version Smarty-3.0.8, created on 2020-01-26 16:12:48
         compiled from "./assets/themes\topmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:171745e2d78c5bed7c5-27317014%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0ac14e47ab978eb3e8e0b5ebf746af28127fbcc' => 
    array (
      0 => './assets/themes\\topmenu.tpl',
      1 => 1580047429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '171745e2d78c5bed7c5-27317014',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
			<div class="brand"<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>style="float: left;margin-left: -15px;margin-right: 0;"<?php }?>>
                <!-- toggle offscreen menu -->
                <a href="javascript:;" class="ti-menu off-<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>left<?php }else{ ?>right<?php }?> visible-xs" data-toggle="offscreen" data-move="<?php echo $_smarty_tpl->getVariable('lang')->value['dir'];?>
"></a>
                <!-- /toggle offscreen menu -->
 
                <!-- logo -->
                <a href="index.html" style="margin:auto;display:block;text-align:center;">
                    <img src="./assets/img/fcyh.png" alt="Dawaa" style="width: 150px;height: 45px;margin-top:1px">
                </a>
                <!-- /logo -->
            </div>
			<ul class="nav navbar-nav <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>navbar-right<?php }?>">
<!--
				<li class="hidden-xs"<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>style="float: right;"<?php }?>>
                    <a href="<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?><?php echo $_smarty_tpl->getVariable('page1')->value;?>
<?php }elseif($_smarty_tpl->getVariable('lang')->value['dir_fe']=='right'){?><?php echo $_smarty_tpl->getVariable('page2')->value;?>
<?php }?>?&lang=<?php echo $_smarty_tpl->getVariable('lang')->value['lang_other_DEFAULT'];?>
">
                        <i class=""><?php echo $_smarty_tpl->getVariable('lang')->value['lang_other'];?>
</i>
                    </a>
                </li>
-->
<!--
				<?php if ($_smarty_tpl->getVariable('notifications')->value){?>	
                <li class="notifications dropdown">
                    <a href="javascript:;" data-toggle="dropdown">
                        <i class="ti-bell"></i>
                        <div class="badge badge-top bg-danger animated flash">
                            <span><?php echo $_smarty_tpl->getVariable('notifications')->value;?>
</span>
                        </div>
                    </a>
                    <div class="dropdown-menu animated fadeInRight">
                        <div class="panel panel-default no-m">
                            <div class="panel-heading small"><b><?php echo $_smarty_tpl->getVariable('lang')->value['member'];?>
</b></div>
                            <ul class="list-group">
								<?php  $_smarty_tpl->tpl_vars["c"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tokens')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["c"]->key => $_smarty_tpl->tpl_vars["c"]->value){
?>
									<li class="list-group-item membership_<?php echo $_smarty_tpl->getVariable('c')->value['number'];?>
">
										<div class="m-body">
											<span> <?php echo $_smarty_tpl->getVariable('lang')->value['member_num'];?>
 <b><?php echo $_smarty_tpl->getVariable('c')->value['number'];?>
</b> by_name <b><?php echo $_smarty_tpl->getVariable('c')->value['name'];?>
</b> <br />
												<a href="#" class="deleteThisMembership" membership="<?php echo $_smarty_tpl->getVariable('c')->value['number'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['delete'];?>
</a> - <a href="#" class="useThisMembership" membership="<?php echo $_smarty_tpl->getVariable('c')->value['number'];?>
">use</a>
											</span>
										</div>
									</li>
								<?php }} ?>
                            </ul>
                        </div>
                    </div>
                </li>
				<?php }?>	
-->
                <li class="off-<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?>right<?php }else{ ?>left<?php }?>">
                    <a href="javascript:;" data-toggle="dropdown">
<!--                        <img src="./assets/img/" class="header-avatar img-circle" alt="<?php echo $_smarty_tpl->getVariable('username')->value;?>
" title="<?php echo $_smarty_tpl->getVariable('username')->value;?>
">-->
                        <span class="mr10"><?php echo $_smarty_tpl->getVariable('username')->value;?>
</span>
                        <i class="ti-angle-down ti-caret "></i>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
<!--                       <?php if ($_smarty_tpl->getVariable('group')->value['setting']==1){?>-->
                        <li>
                            <a href="settings.html"><?php echo $_smarty_tpl->getVariable('lang')->value['PERSONALSITTING'];?>
</a>
                        </li>
<!--                        <?php }?>-->
                        <li>
                            <a href="setting.html"><?php echo $_smarty_tpl->getVariable('lang')->value['SETTING_MANGMENT'];?>
</a>
                        </li>
                        <li>
                            <a href="login.html?do=logout"><?php echo $_smarty_tpl->getVariable('lang')->value['LGUT_SUBMIT'];?>
</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> navbar-left<?php }else{ ?>navbar-right<?php }?>">
                <li class="header-search <?php if ($_smarty_tpl->getVariable('q')->value){?>open<?php }?>" <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> style="float : right;"<?php }?>>
                    <!-- toggle search -->
                    <a href="javascript:;" class="toggle-search">
                        <i class="ti-search"></i>
                    </a>
                    <!-- /toggle search -->
                    <div class="search-container" <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> style="left:40px; right: auto"<?php }?>>
                        <form role="search" action="search.html" method="get">
                            <input type="text" name="query"  class="form-control search" placeholder="<?php echo $_smarty_tpl->getVariable('lnag')->value['search'];?>
" value="<?php echo $_smarty_tpl->getVariable('q')->value;?>
" >
                        </form>
                    </div>
                </li>
                
                <li class="hidden-xs" <?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='left'){?> style="float : right;"<?php }?>>
                    <!-- toggle small menu -->
                    <a href="javascript:;" class="toggle-sidebar">
                        <i class="ti-menu"></i>
                    </a>
                    <!-- /toggle small menu -->
                </li>
            </ul>
