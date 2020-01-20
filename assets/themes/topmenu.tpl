			<div class="brand"{if $lang.dir_fe eq 'left'}style="float: left;margin-left: -15px;margin-right: 0;"{/if}>
                <!-- toggle offscreen menu -->
                <a href="javascript:;" class="ti-menu off-{if $lang.dir_fe eq 'left'}left{else}right{/if} visible-xs" data-toggle="offscreen" data-move="{$lang.dir}"></a>
                <!-- /toggle offscreen menu -->
 
                <!-- logo -->
                <a href="index.html" style="margin:auto;display:block;text-align:center;">
                    <img src="./assets/img/dawaa.svg" alt="Dawaa" style="width: 200px;height: 45px;margin-top:1px">
                </a>
                <!-- /logo -->
            </div>
			<ul class="nav navbar-nav {if $lang.dir_fe eq 'left'}navbar-right{/if}">
<!--
				<li class="hidden-xs"{if $lang.dir_fe eq 'left'}style="float: right;"{/if}>
                    <a href="{if $lang.dir_fe eq 'left'}{$page1}{elseif $lang.dir_fe eq 'right'}{$page2}{/if}?&lang={$lang.lang_other_DEFAULT}">
                        <i class="">{$lang.lang_other}</i>
                    </a>
                </li>
-->
<!--
				{if $notifications}	
                <li class="notifications dropdown">
                    <a href="javascript:;" data-toggle="dropdown">
                        <i class="ti-bell"></i>
                        <div class="badge badge-top bg-danger animated flash">
                            <span>{$notifications}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu animated fadeInRight">
                        <div class="panel panel-default no-m">
                            <div class="panel-heading small"><b>{$lang.member}</b></div>
                            <ul class="list-group">
								{foreach from=$tokens item="c"}
									<li class="list-group-item membership_{$c.number}">
										<div class="m-body">
											<span> {$lang.member_num} <b>{$c.number}</b> by_name <b>{$c.name}</b> <br />
												<a href="#" class="deleteThisMembership" membership="{$c.number}">{$lang.delete}</a> - <a href="#" class="useThisMembership" membership="{$c.number}">use</a>
											</span>
										</div>
									</li>
								{/foreach}
                            </ul>
                        </div>
                    </div>
                </li>
				{/if}	
-->
                <li class="off-{if $lang.dir_fe eq 'left'}right{else}left{/if}">
                    <a href="javascript:;" data-toggle="dropdown">
<!--                        <img src="./assets/img/" class="header-avatar img-circle" alt="{$username}" title="{$username}">-->
                        <span class="mr10">{$username}</span>
                        <i class="ti-angle-down ti-caret "></i>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
<!--                       {if $group.setting eq 1 }-->
                        <li>
                            <a href="settings.html">{$lang.PERSONALSITTING}</a>
                        </li>
<!--                        {/if}-->
                        <li>
                            <a href="setting.html">{$lang.SETTING_MANGMENT}</a>
                        </li>
                        <li>
                            <a href="login.html?do=logout">{$lang.LGUT_SUBMIT}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav {if $lang.dir_fe eq 'left'} navbar-left{else}navbar-right{/if}">
                <li class="header-search {if $q}open{/if}" {if $lang.dir_fe eq 'left'} style="float : right;"{/if}>
                    <!-- toggle search -->
                    <a href="javascript:;" class="toggle-search">
                        <i class="ti-search"></i>
                    </a>
                    <!-- /toggle search -->
                    <div class="search-container" {if $lang.dir_fe eq 'left'} style="left:40px; right: auto"{/if}>
                        <form role="search" action="search.html" method="get">
                            <input type="text" name="query"  class="form-control search" placeholder="{$lnag.search}" value="{$q}" >
                        </form>
                    </div>
                </li>
                
                <li class="hidden-xs" {if $lang.dir_fe eq 'left'} style="float : right;"{/if}>
                    <!-- toggle small menu -->
                    <a href="javascript:;" class="toggle-sidebar">
                        <i class="ti-menu"></i>
                    </a>
                    <!-- /toggle small menu -->
                </li>
            </ul>