{if $area_name eq 'list'}
<input type="hidden" value="country" id="page">
<input type="hidden" value="{$lang.country}" id="lang_name">
<input type="hidden" value="{$lang.country}" id="sheet">
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
                <h5> {$lang.list} <b> {$lang.country} </b></h5>
                <br>
                <input id="myInput" type="text" class="form-control" placeholder="{$lang.search}">
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="tableau_eleves table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{$lang.name}</th>
                                <th>{$lang.status} </th>
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
                                    <a href="country.html?do=view&id={$c.id}">{$c.count_name_ar} - {$c.count_name}</a> <br />
                                </td>
                                <td>
                                    {if $c.status eq 1}
                                    <a class="badge bg-success status_deactive" id="{$c.id}" title="{$lang.deactivation}">{$lang.active}</a>
                                    {else}<a class="badge bg-danger status_active" id="{$c.id}" title="{$lang.activation}"> {$lang.deactive} </a>
                                    {/if}
                                </td>
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
                                <td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="country.html?do=add">{$lang.add_country}</a></td>
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
            <header class="panel-heading"> {$lang.edit_country}( # {$u.id} )</header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="country.html?do=update&id={$u.id}" enctype="multipart/form-data">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="count_name_ar" placeholder="{$lang.count_name_ar}" value="{if $n}{$n.count_name_ar}{else}{$u.count_name_ar}{/if}">
                        </div>
                        <label class="col-sm-2 control-label">{$lang.name_by_arabic}</label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="count_name" placeholder="{$lang.name_by_english}" value="{if $n}{$n.count_name}{else}{$u.count_name}{/if}">
                        </div>
                        <label class="col-sm-2 control-label">{$lang.name_by_english}</label>
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
<input type="hidden" value="governorates" id="page">
<input type="hidden" value="{$lang.governorate}" id="lang_name">
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
            <header class="panel-heading"> {$lang.governorate_details} ( # {$u.id} )</header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="governorates.html?do=update&id={$u.id}">
                    <div class="alert alert-info">
                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.name} : </strong></span>
                        <span style="width:80%;display:inline-block;">{$u.gov_name_ar} - {$u.gov_name}</span>
                    </div>

                    <div class="alert alert-info">
                        <span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.status} : </strong></span>
                        <span style="width:80%;display:inline-block;">{if $u.status eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
                    </div>
                    <div class="form-group" id="item_{$u.id}">
                        <a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();" style="margin-{$lang.dir_fe}: 20px">{$lang.print}</a>
                        {if $group.governorates_edit eq 1 }
                        <a class="hidden-print btn btn-warning btn-sm" href="governorates.html?do=edit&id={$u.id}"> {$lang.edit}</a>
                        {/if}
                        {if $group.governorates_delete eq 1 }
                        <a class="hidden-print btn btn-danger btn-sm delete" href="governorates.html?do=del&id={$u.id}"> {$lang.delete} </a>
                        {/if}
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
            <header class="panel-heading"> {$lang.add_country}</header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="country.html?do=add" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="count_name_ar" placeholder="{$lang.name_by_arabic}" value="{if $n}{$n.name_ar}{/if}">
                        </div>
                        <label class="col-sm-2 control-label">{$lang.name_by_arabic}</label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="count_name" placeholder="{$lang.name_by_english}" value="{if $n}{$n.name_en}{/if}">
                        </div>
                        <label class="col-sm-2 control-label">{$lang.name_by_english}</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10"><button type="submit" class="btn btn-default">{$lang.add_country}</button></div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
{/if}
