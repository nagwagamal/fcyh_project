<?php /* Smarty version Smarty-3.0.8, created on 2020-01-20 14:44:19
         compiled from "./assets/themes\sidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:148135e25a0a3ef0dc9-94495108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8eb96ce1082519e6dff4cf350ab7aeaddfb060e' => 
    array (
      0 => './assets/themes\\sidebar.tpl',
      1 => 1579524252,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148135e25a0a3ef0dc9-94495108',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
			<!-- sidebar menu -->
            <aside style="background-color:#f1f4f9;" class="sidebar offscreen-<?php if ($_smarty_tpl->getVariable('lang')->value['dir_fe']=='right'){?>right<?php }else{ ?>left<?php }?>">
                <!-- main navigation -->
                <nav style="margin-top:15px;background-color:rgb(255, 255, 255);" class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10">
<ul class="nav">
                    <li>
                        <?php if ($_smarty_tpl->getVariable('group')->value['staffs_list']==1){?>
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span>  <?php echo $_smarty_tpl->getVariable('lang')->value['country'];?>
 </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="country.html?do=list" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['country'];?>
 </span>
                                </a>
                            </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->getVariable('group')->value['staffs_add']==1){?>
                            <li>
                                <a href="country.html?do=add" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['add_country'];?>
</span>
                                </a>
                            </li>
                            <?php }?> 
                        </ul>
                    </li>
                </ul>

                <ul class="nav">
                    <li>
                        <?php if ($_smarty_tpl->getVariable('group')->value['staffs_list']==1){?>
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span>  <?php echo $_smarty_tpl->getVariable('lang')->value['governorate'];?>
 </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="governorates.html?do=list" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['governorate'];?>
 </span>
                                </a>
                            </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->getVariable('group')->value['staffs_add']==1){?>
                            <li>
                                <a href="governorates.html?do=add" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['add_governorate'];?>
</span>
                                </a>
                            </li>
                            <?php }?> 
                        </ul>
                    </li>
                </ul>
                    
                   <ul class="nav">
                    <li>
                        <?php if ($_smarty_tpl->getVariable('group')->value['staffs_list']==1){?>
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span>  <?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
 </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="cities.html?do=list" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
 </span>
                                </a>
                            </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->getVariable('group')->value['staffs_add']==1){?>
                            <li>
                                <a href="cities.html?do=add" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['add_city'];?>
</span>
                                </a>
                            </li>
                            <?php }?> 
                        </ul>
                    </li>
                </ul>
                   <ul class="nav">
                    <li>
                        <?php if ($_smarty_tpl->getVariable('group')->value['staffs_list']==1){?>
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span> <?php echo $_smarty_tpl->getVariable('lang')->value['chats'];?>
 </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="chats.html?do=list" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['chats'];?>
 </span>
                                </a>
                            </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->getVariable('group')->value['staffs_add']==1){?>
                            <li>
                                <a href="chats.html?do=add" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['add_chats'];?>
</span>
                                </a>
                            </li>
                            <?php }?> 
                        </ul>
                    </li>
                </ul>
                    <ul class="nav">
                    <li>
                        <?php if ($_smarty_tpl->getVariable('group')->value['staffs_list']==1){?>
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span> <?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
 </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="users.html?do=list" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['list'];?>
 <?php echo $_smarty_tpl->getVariable('lang')->value['users'];?>
 </span>
                                </a>
                            </li>
                            <?php }?>
                            <?php if ($_smarty_tpl->getVariable('group')->value['staffs_add']==1){?>
                            <li>
                                <a href="users.html?do=add" style='background-color: #a3f5ca;'>
                                    <span><?php echo $_smarty_tpl->getVariable('lang')->value['add_users'];?>
</span>
                                </a>
                            </li>
                            <?php }?> 
                        </ul>
                    </li>
                </ul>
                   


					<br><br><br><br><br><br>

                </nav>

            </aside>
            <!-- /sidebar menu -->