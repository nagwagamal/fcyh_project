			<!-- sidebar menu -->
            <aside style="background-color:#f1f4f9;" class="sidebar offscreen-{if $lang.dir_fe eq 'right'}right{else}left{/if}">
                <!-- main navigation -->
                <nav style="margin-top:15px;background-color:rgb(255, 255, 255);" class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10">
<ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span>  {$lang.country} </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="country.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.country} </span>
                                </a>
                            </li>
                            {/if}
                            {if $group.staffs_add eq 1 }
                            <li>
                                <a href="country.html?do=add" style='background-color: #a3f5ca;'>
                                    <span>{$lang.add_country}</span>
                                </a>
                            </li>
                            {/if} 
                        </ul>
                    </li>
                </ul>

                <ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span>  {$lang.governorate} </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="governorates.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.governorate} </span>
                                </a>
                            </li>
                            {/if}
                            {if $group.staffs_add eq 1 }
                            <li>
                                <a href="governorates.html?do=add" style='background-color: #a3f5ca;'>
                                    <span>{$lang.add_governorate}</span>
                                </a>
                            </li>
                            {/if} 
                        </ul>
                    </li>
                </ul>
                    
                   <ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span>  {$lang.city} </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="cities.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.city} </span>
                                </a>
                            </li>
                            {/if}
                            {if $group.staffs_add eq 1 }
                            <li>
                                <a href="cities.html?do=add" style='background-color: #a3f5ca;'>
                                    <span>{$lang.add_city}</span>
                                </a>
                            </li>
                            {/if} 
                        </ul>
                    </li>
                </ul>
                   <ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span> {$lang.chats} </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="chats.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.chats} </span>
                                </a>
                            </li>
                            {/if}

                        </ul>
                    </li>
                </ul>
                    <ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span> {$lang.complains} </span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="complains.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.complains} </span>
                                </a>
                            </li>
                            {/if}

                        </ul>
                    </li>
                </ul>
                    <ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span> {$lang.users} </span>
                        </a>
                        <ul class="sub-menu">
                        
                            <li>
                                <a href="users.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.users} </span>
                                </a>
                            </li>
                            {/if}
                            {if $group.staffs_add eq 1 }
                            <li>
                                <a href="users.html?do=add" style='background-color: #a3f5ca;'>
                                    <span>{$lang.add_user}</span>
                                </a>
                            </li>
                            {/if} 
                        </ul>
                    </li>
                </ul>
                    <ul class="nav">
                    <li>
                        {if $group.staffs_list eq 1 }
                        <a href="javascript:;">
                            <i class="toggle-accordion"></i>
                            <i class="ti-layers"></i>
                            <span> {$lang.categories} </span>
                        </a>
                        <ul class="sub-menu">

                            <li>
                                <a href="categories.html?do=list" style='background-color: #a3f5ca;'>
                                    <span>{$lang.list} {$lang.categories} </span>
                                </a>
                            </li>
                            {/if}
                            {if $group.staffs_add eq 1 }
                            <li>
                                <a href="categories.html?do=add" style='background-color: #a3f5ca;'>
                                    <span>{$lang.add_categories}</span>
                                </a>
                            </li>
                            {/if}
                            {if $group.staffs_add eq 1 }
                            <li>
                                <a href="categories.html?do=add_cat" style='background-color: #a3f5ca;'>
                                    <span>{$lang.add_categories_1}</span>
                                </a>
                            </li>
                            {/if}
                        </ul>
                    </li>
                </ul>
                   


					<br><br><br><br><br><br>

                </nav>

            </aside>
            <!-- /sidebar menu -->
