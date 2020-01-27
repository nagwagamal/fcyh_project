{if $area_name eq 'add'}
<ol class="breadcrumb">
    <li><a href="index.html"><i class="ti-home ml5"></i>
            {$lang.NDX_PAGE_NAME}</a></li>
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
            <header class="panel-heading">
                <div class="panel-body">
                    <form class="form-horizontal" action="tasks.php?do=add" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="enter the title" name="title" value="{if $n}{$n.title}{/if}">
                            </div>
                            <label class="col-sm-2 control-label">
                                {$lang.title}</label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <select class="form-control" name="category">
                                    <option value="0" selected="selected">{$lang.choose_category}</option>
                                    {foreach from=$c item="_c"}
                                    <option value="{$_c.id}" {if $_c.id eq $n.cat_name}selected="selected" {/if}>{$_c.cat_name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.category}</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="description" class="form-control" placeholder="enter the description" name="description" value="{if $n}{$n.description}{/if}">
                                </div>
                                <label class="col-sm-2 control-label">{$lang.description}
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="img" value="">
                                </div>
                                <label class="col-sm-2 control-label"> {$lang.image} </label>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <select class="form-control" name="user_task">
                                        <option value="0" selected="selected">{$lang.choose_user}</option>
                                        {foreach from=$p item="_p"}
                                        <option value="{$_p.id}" {if $_p.id eq $n.user_name}selected="selected" {/if}>{$_p.name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.user_task_name}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <select class="form-control" name="assigned">
                                            <option value="0" selected="selected">{$lang.choose_user}</option>
                                            {foreach from=$p item="_p"}
                                            <option value="{$_p.id}" {if $_p.id eq $n.user_name}selected="selected" {/if}>{$_p.name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.user_assigned_name}</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input autocomplete="off" class="date form-control" placeholder="dd/mm/yyyy" name="requested_time">
                                        </div>
                                        <label class="col-sm-2 control-label">{$lang.requested_time}</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input autocomplete="off" class="date form-control" placeholder="dd/mm/yyyy" name="arrived_time">
                                        </div>
                                        <label class="col-sm-2 control-label">{$lang.arrived_time}</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="description" class="form-control" placeholder="enter the total_time" name="total_time" value="{if $n}{$n.total_time}{/if}">
                                        </div>
                                        <label class="col-sm-2 control-label">{$lang.total_time}
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="description" class="form-control" placeholder="enter the review" name="review" value="{if $n}{$n.review}{/if}">
                                        </div>
                                        <label class="col-sm-2 control-label">{$lang.review}
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10"><button type="submit" class="btn btn-default">{$lang.add_tasks}</button></div>
                                    </div>
                    </form>
                </div>
            </header>
        </section>
        {elseif $area_name eq 'list'}
        <input type="hidden" value="tasks" id="page">
        <input type="hidden" value="{$lang.tasks}" id="lang_name">
        <input type="hidden" value="{$lang.tasks}" id="sheet">
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
                        <h5> {$lang.list} <b> {$lang.tasks} </b></h5>
                        <br>
                        <input id="myInput" type="text" class="form-control" placeholder="{$lang.search}">
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="tableau_eleves table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th>{$lang.title}</th>
                                        <th>{$lang.description}</th>
                                        <th>{$lang.category}</th>
                                        <th>{$lang.user_task_name} </th>
                                        <th>{$lang.user_assigned_name} </th>
                                        <th>{$lang.requested_time} </th>
                                        <th>{$lang.arrived_time} </th>
                                        <th>{$lang.total_time} </th>
                                        <th>{$lang.review} </th>
                                        {if $group.governorates_edit eq "1" || $group.governorates_delete eq "1" || $group.cities_list eq "1" }
                                        <th>{$lang.settings}</th>
                                        {/if}
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    {foreach from=$u item="c"}
                                    <tr id="tr_{$c.id}">
                                        <td>{$c.id}</td>
                                        <td>
                                            <a href="tasks.html?do=view&id={$c.id}">{$c.tittle}</a> <br />
                                        </td>
                                        <td>{$c.description}</td>
                                        <td>
                                            {getFromTable a=$c.cat_id b="categories" c="getCategoriesInformation" d="cat_name"}
                                        </td>
                                        <td>
                                            {getFromTable a=$c.assiged_to b="users" c="getUsersInformation" d="name"}
                                        </td>
                                        <td>
                                            {getFromTable a=$c.user_id b="users" c="getUsersInformation" d="name"}
                                        </td>
                                        <td>{$c.requested_time}
                                        </td>
                                        <td>{$c.arrived_time}</td>
                                        <td>{$c.total_time}</td>
                                        <td>{$c.review}</td>
                                        {if $group.governorates_edit eq "1" || $group.governorates_delete eq "1" }
                                        <td id="item_{$c.id}">
                                            {if $group.governorates_edit eq 1 }
                                            <button class="btn btn-primary btn-xs edit" title="{$lang.edit}"><i class="fa fa-pencil"></i></button>
                                            {/if}
                                            {if $group.governorates_delete eq 1 }
                                            <button class="btn btn-danger btn-xs delete" title="{$lang.delete}"><i class="fa fa-trash-o"></i></button>
                                            {/if}
                                        </td>
                                        {/if}
                                    </tr>
                                    {/foreach}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        {if $group.governorates_edit eq "1" || $group.governorates_delete eq "1" || $group.cities_list eq "1" }
                                        {if $group.governorates_add eq 1 }
                                        <td colspan="3" align="right">{$pager}</td>
                                        <td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="tasks.html?do=add">{$lang.add_tasks}</a></td>
                                        {else}
                                        <td colspan="4" align="right">{$pager}</td>
                                        {/if}
                                        {/if}
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {elseif $area_name eq 'view'}
        <input type="hidden" value="tasks" id="page">
        <input type="hidden" value="{$lang.tasks}" id="lang_name">
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
                    <header class="panel-heading"> {$lang.tasks_details} ( # {$u.id} )</header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="tasks.html?do=update&id={$u.id}">
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.title} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.tittle} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.description} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.description} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.image} : </strong></span>
                                <span style="width:80%;display:inline-block;"><a target="_blank" href="{$u.img}"><img style="border-radius:5px;" src="{$u.img}" width="80" /></a></span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.category} : </strong></span>
                                <span style="width:80%;display:inline-block;">{getFromTable a=$u.cat_id b="categories" c="getCategoriesInformation" d="cat_name"} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.user_assigned_name } : </strong></span>
                                <span style="width:80%;display:inline-block;">{getFromTable a=$u.assiged_to b="users" c="getUsersInformation" d="name"} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.user_task_name} : </strong></span>
                                <span style="width:80%;display:inline-block;">{getFromTable a=$u.user_id b="users" c="getUsersInformation" d="name"} </span>
                            </div>

                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.lon} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.lon} </span>
                            </div>

                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.lat} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.lat} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.requested_time} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.requested_time} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.arrived_time} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.arrived_time} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.total_time} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.total_time} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.review} : </strong></span>
                                <span style="width:80%;display:inline-block;">{$u.review} </span>
                            </div>
                            <div class="alert alert-info">
                                <span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.status} : </strong></span>
                                <span style="width:80%;display:inline-block;">{if $u.status eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
                            </div>


                            <div class="form-group" id="item_{$u.id}">
                                <a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-{$lang.dir_fe}: 20px">{$lang.print}</a>
                                {if $group.governorates_edit eq 1 }
                                <a class="hidden-print btn btn-warning btn-sm" href="users.html?do=edit&id={$u.id}"> {$lang.edit}</a>
                                {/if}
                                {if $group.governorates_delete eq 1 }
                                <a class="hidden-print btn btn-danger btn-sm delete" href="users.html?do=del&id={$u.id}"> {$lang.delete} </a>
                                {/if}
                            </div>
                        </form>
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
                    <header class="panel-heading"> {$lang.edit_tasks}( # {$u.id} )</header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="tasks.html?do=update&id={$u.id}" enctype="multipart/form-data">

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tittle" placeholder="{$lang.tittle}" value="{if $n}{$n.tittle}{else}{$u.tittle}{/if}">
                                </div>
                                <label class="col-sm-2 control-label">{$lang.title}</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="description" placeholder="{$lang.description}" value="{if $n}{$n.description}{else}{$u.description}{/if}">
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
                                    <select class="form-control" name="category">
                                        {foreach from=$c item="_c"}
                                        <option value="{$_c.id}" {if $n}{if $_c.id eq $n.cat_name}selected="selected" {/if}{else} {if $_c.id eq $u.cat_id}selected="selected" {/if}{/if}>{$_c.cat_name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.category}</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <select class="form-control" name="user_id">
                                            {foreach from=$p item="_p"}
                                            <option value="{$_p.id}" {if $n}{if $_p.id eq $n.user_id}selected="selected" {/if}{else} {if $_p.id eq $u.user_id}selected="selected" {/if}{/if}>{$_p.name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.user_task_name}</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <select class="form-control" name="assiged_to">
                                                {foreach from=$p item="_p"}
                                                <option value="{$_p.id}" {if $n}{if $_p.id eq $n.assiged_to}selected="selected" {/if}{else} {if $_p.id eq $u.assiged_to}selected="selected" {/if}{/if}>{$_p.name} </option> {/foreach} </select> </div> <label class="col-sm-2 control-label">{$lang.user_assigned_name}</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="lon" placeholder="{$lang.lon}" value="{if $n}{$n.lon}{else}{$u.lon}{/if}">
                                            </div>
                                            <label class="col-sm-2 control-label">{$lang.lon}</label>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="lat" placeholder="{$lang.lat}" value="{if $n}{$n.lat}{else}{$u.lat}{/if}">
                                            </div>
                                            <label class="col-sm-2 control-label">{$lang.lat}</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="requested_time" placeholder="{$lang.requested_time}" value="{if $n}{$n.requested_time}{else}{$u.requested_time}{/if}">
                                            </div>
                                            <label class="col-sm-2 control-label">{$lang.requested_time}</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="arrived_time" placeholder="{$lang.arrived_time}" value="{if $n}{$n.arrived_time}{else}{$u.arrived_time}{/if}">
                                            </div>
                                            <label class="col-sm-2 control-label">{$lang.arrived_time}</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="total_time" placeholder="{$lang.total_time}" value="{if $n}{$n.total_time}{else}{$u.total_time}{/if}">
                                            </div>
                                            <label class="col-sm-2 control-label">{$lang.total_time}</label>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="review" placeholder="{$lang.review}" value="{if $n}{$n.review}{else}{$u.review}{/if}">
                                            </div>
                                            <label class="col-sm-2 control-label">{$lang.review}</label>
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
        {/if}
