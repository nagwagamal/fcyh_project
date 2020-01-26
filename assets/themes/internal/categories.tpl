          	{if $area_name eq 'list'}
          	<input type="hidden" value="categories" id="page">
          	<input type="hidden" value="{$lang.categories}" id="lang_name">
          	<input type="hidden" value="{$lang.categories}" id="sheet">
          	<input type="hidden" value="{$lang.delete_alarm_massage_in_woman}" id="lang_del">
          	<input type="hidden" value="{$lang.status_alarm_massage_in_woman}" id="lang_status">
          	<ol class="breadcrumb">
          	    <li>
          	        <a href="index.html"><i class="ti-home ml5"></i>{$lang.NDX_PAGE_NAME}</a>
          	    </li>
          	    <li class="active">{$title}</li>
          	</ol>
          	<div class="row mt">
          	    <div class="col-md-12">
          	        {if $success}<div class="alert alert-success">{$success}</div>{/if}
          	        <section class="panel">{$export}
          	            <div class="panel-heading no-b">
          	                <h5> {$lang.list} <b> {$lang.categories} </b></h5>
          	                <br>
          	                <input id="myInput" type="text" class="form-control" placeholder="{$lang.search}">
          	            </div>
          	            <div class="panel-body">
          	                <div class="table-responsive">
          	                    <table class="tableau_eleves table table-bordered table-striped">
          	                        {if $u}
          	                        <thead>
          	                            <tr>
          	                                <th>#</th>
          	                                <th>{$lang.category}</th>
          	                                <th>{$lang.categories_1}</th>
          	                                <th>{$lang.description}</th>
          	                                <th>{$lang.image}</th>
          	                                <th> {$lang.status} </th>
          	                                {if $group.cities_edit eq "1" || $group.cities_delete eq "1" }
          	                                <th>{$lang.settings}</th>
          	                                {/if}
          	                            </tr>
          	                        </thead>
          	                        <tbody id="myTable">
          	                            {foreach from=$u item="c"}
          	                            <tr id="tr_{$c.id}">
          	                                <td>{$c.id}</td>
          	                                <td>
          	                                    <a href="categories.html?do=view&id={$c.id}">{$c.cat_name}</a>
          	                                </td>
          	                                <td>
          	                                    {getFromTable a=$c.parent_id b="categories" c="getCategoriesInformation" d="cat_name"}
          	                                </td>
          	                                <td>{$c.description}</td>
          	                                <td>{$c.img}</td>
          	                                <td>
          	                                    <span {if $group.cities_active eq 1 } id="active_{$c.id}" class="sta_{$c.status} {/if}">
          	                                        {if $c.status eq 1}
          	                                        <a class="badge bg-success status_deactive" id="{$c.id}" title="{$lang.deactivation}">{$lang.active}</a>
          	                                        {else}<a class="badge bg-danger status_active" id="{$c.id}" title="{$lang.activation}"> {$lang.deactive} </a>
          	                                        {/if}
          	                                    </span>
          	                                    {if $group.cities_edit eq 1 || $group.cities_delete eq 1 }
          	                                </td>
          	                                <td id="item_{$c.id}">
          	                                    {if $group.cities_edit eq 1 }
          	                                    <button class="btn btn-primary btn-xs edit" title="{$lang.edit}"><i class="fa fa-pencil"></i></button>
          	                                    {/if}
          	                                    {if $group.cities_delete eq 1 }


          	                                    <button class="btn btn-danger btn-xs delete" title="{$lang.delete}"><i class="fa fa-trash-o"></i></button>

          	                                    {/if}
          	                                </td>
          	                                {/if}
          	                            </tr>
          	                            {/foreach}
          	                        </tbody>
          	                        {else}<tr>
          	                            <td align="center" colspan="5"><b>{$lang.no_cities}</b></td>
          	                        </tr>{/if}
          	                        <tfoot>
          	                            <tr>

          	                                {if $group.cities_add eq 1 }
          	                                <td colspan="3" align="right">{$pager}</td>
          	                                <td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="categories.html?do=add">{$lang.add_categories}</a></td>
          	                                {else}
          	                                <td colspan="4" align="right">{$pager}</td>
          	                                {/if}
          	                            </tr>
          	                        </tfoot>
          	                    </table>
          	                </div>
          	            </div>
          	        </section>
          	    </div>
          	</div>
          	{elseif $area_name eq 'edit'}
          	<ol class="breadcrumb">
          	    <li>
          	        <a href="index.html"><i class="ti-home ml5"></i>{$lang.NDX_PAGE_NAME}</a>
          	    </li>
          	    <li class="active">{$title}</li>
          	</ol>
          	<div class="row">
          	    <div class="col-lg-12">
          	        {if $success}
          	        <div class="alert alert-success">{$success}</div>
          	        {else}
          	        {if $errors}
          	        <div class="alert alert-danger">
          	            <ul>
          	                {foreach from=$errors item="e" key=k}
          	                <li><strong>{$e}</strong></li>
          	                {/foreach}
          	            </ul>
          	        </div>
          	        {/if}
          	        {/if}
          	        <section class="panel">
          	            <header class="panel-heading"> {$lang.edit_category} ( # {$u.id} )</header>
          	            <div class="panel-body">
          	                <form class="form-horizontal" role="form" method="post" action="categories.html?do=update&id={$u.id}" enctype="multipart/form-data">
          	                    {if $u.parent_id neq null}
          	                    <div class="form-group">
          	                        <div class="col-sm-10">
          	                            <select class="form-control" name="category">
          	                                {foreach from=$c item="_c"}
          	                                <option value="{$_c.id}" {if $n}{if $_c.id eq $n.cat_name}selected="selected" {/if}{else} {if $_c.id eq $u.parent_id}selected="selected" {/if}{/if}>{$_c.cat_name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.categories_1}</label>
          	                        </div>
          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="text" class="form-control" name="cat_name" placeholder="{$lang.no_name_by_english}" value="{if $n}{$n.cat_name}{else}{$u.cat_name}{/if}">
          	                            </div>
          	                            <label class="col-sm-2 control-label">{$lang.category}</label>
          	                        </div>
          	                        {else}
          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="text" class="form-control" name="cat_name" placeholder="{$lang.no_name_by_english}" value="{if $n}{$n.cat_name}{else}{$u.cat_name}{/if}">
          	                            </div>
          	                            <label class="col-sm-2 control-label">{$lang.category}</label>
          	                        </div> {/if}


          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="text" class="form-control" name="description" placeholder="{$lang.no_name_by_english}" value="{if $n}{$n.description}{else}{$u.description}{/if}">
          	                            </div>
          	                            <label class="col-sm-2 control-label">{$lang.description}</label>
          	                        </div>
          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="file" class="form-control" name="img" value="">
          	                                {if $u.img}<p class="help-block"><a target="_blank" href="{$u.img}">{$lang.show_image}</a></p>{/if}
          	                            </div>
          	                            <label class="col-sm-2 control-label">{$lang.image}</label>
          	                        </div>

          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <select class="form-control" name="status">
          	                                    <option value="0" {if $n}{if $n.status eq 0}selected="selected" {/if}{else}{if $u.status eq 0}selected="selected" {/if}{/if}>{$lang.deactive} </option> <option value="1" {if $n}{if $n.status eq 1}selected="selected" {/if}{else}{if $u.status eq 1}selected="selected" {/if}{/if}>{$lang.active} </option> </select> </div> <label class="col-sm-2 control-label">{$lang.status}</label>
          	                            </div>
          	                            <div class="form-group">
          	                                <div class="col-sm-10"><button type="submit" class="btn btn-default">{$lang.update}</button></div>
          	                            </div>
          	                </form>
          	            </div>
          	        </section>
          	    </div>
          	</div>
          	{elseif $area_name eq 'view'}
          	<input type="hidden" value="categories" id="page">
          	<input type="hidden" value="{$lang.categories}" id="lang_name">
          	<input type="hidden" value="{$lang.delete_alarm_massage_in_woman}" id="lang_del">
          	<ol class="breadcrumb hidden-print">
          	    <li>
          	        <a href="index.html"><i class="ti-home ml5"></i>{$lang.NDX_PAGE_NAME}</a>
          	    </li>
          	    <li class="active">{$title}</li>
          	</ol>
          	<div class="row">
          	    <div class="col-lg-12">
          	        {if $success}
          	        <div class="alert alert-success">{$success}</div>
          	        {else}
          	        {if $errors}
          	        <div class="alert alert-danger">
          	            <ul>
          	                {foreach from=$errors item="e" key=k}
          	                <li><strong>{$e}</strong></li>
          	                {/foreach}
          	            </ul>
          	        </div>
          	        {/if}
          	        {/if}
          	        <section class="panel">
          	            <header class="panel-heading"> {$lang.category_details} ( # {$u.id} )</header>
          	            <div class="panel-body">
          	                <form class="form-horizontal" role="form" method="post" action="categories.html?do=update&id={$u.id}">

          	                    <div class="alert alert-info">
          	                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.category} : </strong></span>
          	                        <span style="width:80%;display:inline-block;">{$u.cat_name}</span>
          	                    </div>


          	                    <div class="alert alert-info">
          	                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.categories_1} : </strong></span>
          	                        <span style="width:80%;display:inline-block;">{getFromTable a=$u.parent_id b="categories" c="getCategoriesInformation" d="cat_name"} </span>
          	                    </div>
          	                    <div class="alert alert-info">
          	                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.description} : </strong></span>
          	                        <span style="width:80%;display:inline-block;">{$u.description}</span>
          	                    </div>
          	                    <div class="alert alert-info">
          	                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.image} : </strong></span>
          	                        <span style="width:80%;display:inline-block;"><a target="_blank" href="{$u.img}"><img style="border-radius:5px;" src="{$u.img}" width="80" /></a></span>
          	                    </div>
          	                    <div class="alert alert-info">
          	                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.status} : </strong></span>
          	                        <span style="width:80%;display:inline-block;">{if $u.status eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
          	                    </div>
          	                    <div class="form-group" id="item_{$u.id}">
          	                        <a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-{$lang.dir_fe}: 20px">{$lang.print}</a>
          	                        {if $group.cities_edit eq 1 }
          	                        <a class="hidden-print btn btn-warning btn-sm" href="categories.html?do=edit&id={$u.id}">{$lang.edit} </a>
          	                        {/if}
          	                        {if $group.cities_delete eq 1 }
          	                        <a class="hidden-print btn btn-danger btn-sm delete" href="categories.html?do=del&id={$u.id}">{$lang.delete} </a>
          	                        {/if}
          	                    </div>
          	                </form>
          	            </div>
          	        </section>
          	    </div>
          	</div>
          	{elseif $area_name eq 'add_cat'}
          	<ol class="breadcrumb">
          	    <li>
          	        <a href="index.html"><i class="ti-home ml5"></i>{$lang.NDX_PAGE_NAME}</a>
          	    </li>
          	    <li class="active">{$title}</li>
          	</ol>
          	<div class="row">
          	    <div class="col-lg-12">
          	        {if $success}
          	        <div class="alert alert-success">{$success}</div>
          	        {else}
          	        {if $errors}
          	        <div class="alert alert-danger">
          	            <ul>
          	                {foreach from=$errors item="e" key=k}
          	                <li><strong>{$e}</strong></li>
          	                {/foreach}
          	            </ul>
          	        </div>
          	        {/if}
          	        {/if}
          	        <section class="panel">
          	            <header class="panel-heading"> {$lang.add_category}</header>
          	            <div class="panel-body">
          	                <form class="form-horizontal" role="form" method="post" action="categories.html?do=add_cat" enctype="multipart/form-data">

          	                    <div class="form-group">
          	                        <div class="col-sm-10">
          	                            <select class="form-control" name="category">
          	                                <option value="0" selected="selected">{$lang.choose_category}</option>
          	                                {foreach from=$c item="_c"}
          	                                <option value="{$_c.id}" {if $_c.id eq $n.cat_name}selected="selected" {/if}>{$_c.cat_name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.category}</label>
          	                        </div>
          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="text" class="form-control" name="cat_name" placeholder="{$lang.name}" value="{$n.cat_name}">
          	                            </div>
          	                            <label class="col-sm-2 control-label">{$lang.categories_1}</label>
          	                        </div>
          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="text" class="form-control" name="description" placeholder="{$lang.description}" value="{$n.description}">
          	                            </div>
          	                            <label class="col-sm-2 control-label">{$lang.description}</label>
          	                        </div>
          	                        <div class="form-group">
          	                            <div class="col-sm-10">
          	                                <input type="file" class="form-control" name="img" value="">
          	                            </div>
          	                            <label class="col-sm-2 control-label"> {$lang.image} </label>
          	                        </div>

          	                        <div class="form-group">
          	                            <div class="col-sm-10"><button type="submit" class="btn btn-default">{$lang.add_categories_1}</button></div>
          	                        </div>
          	                </form>
          	            </div>
          	        </section>
          	    </div>
          	</div>



          	{elseif $area_name eq 'add'}
          	<ol class="breadcrumb">
          	    <li>
          	        <a href="index.html"><i class="ti-home ml5"></i>{$lang.NDX_PAGE_NAME}</a>
          	    </li>
          	    <li class="active">{$title}</li>
          	</ol>
          	<div class="row">
          	    <div class="col-lg-12">
          	        {if $success}
          	        <div class="alert alert-success">{$success}</div>
          	        {else}
          	        {if $errors}
          	        <div class="alert alert-danger">
          	            <ul>
          	                {foreach from=$errors item="e" key=k}
          	                <li><strong>{$e}</strong></li>
          	                {/foreach}
          	            </ul>
          	        </div>
          	        {/if}
          	        {/if}
          	        <section class="panel">
          	            <header class="panel-heading"> {$lang.add_category}</header>
          	            <div class="panel-body">
          	                <form class="form-horizontal" role="form" method="post" action="categories.html?do=add" enctype="multipart/form-data">
          	                    <div class="form-group">
          	                        <div class="col-sm-10">
          	                            <input type="text" class="form-control" name="cat_name" placeholder="{$lang.name}" value="{$n.cat_name}">
          	                        </div>
          	                        <label class="col-sm-2 control-label">{$lang.category_name}</label>
          	                    </div>
          	                    <div class="form-group">
          	                        <div class="col-sm-10">
          	                            <input type="text" class="form-control" name="description" placeholder="{$lang.description}" value="{$n.description}">
          	                        </div>
          	                        <label class="col-sm-2 control-label">{$lang.description}</label>
          	                    </div>
          	                    <div class="form-group">
          	                        <div class="col-sm-10">
          	                            <input type="file" class="form-control" name="img" value="">
          	                        </div>
          	                        <label class="col-sm-2 control-label"> {$lang.image} </label>
          	                    </div>
          	                    <div class="form-group">
          	                        <div class="col-sm-10"><button type="submit" class="btn btn-default">{$lang.add_categories}</button></div>
          	                    </div>
          	                </form>
          	            </div>
          	        </section>
          	    </div>
          	</div>
          	{/if}
