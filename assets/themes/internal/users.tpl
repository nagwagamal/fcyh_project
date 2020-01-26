          	{if $area_name eq 'list'}
          		<input type="hidden" value="users" id="page">
          		<input type="hidden" value="{$lang.users}" id="lang_name">
          		<input type="hidden" value="{$lang.users}" id="sheet">
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
								<h5> {$lang.list} <b> {$lang.users} </b></h5>
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
											<th>{$lang.email}</th>
											<th>{$lang.mobile} </th>
											<th>{$lang.city} </th>
											<th>{$lang.address} </th>
											<th>{$lang.type} </th>
											<th>{$lang.volunteer} </th>
											<th>{$lang.status } </th>
											{if $group.governorates_edit eq "1" || $group.governorates_delete eq "1" || $group.cities_list eq "1"  }
												<th>{$lang.settings}</th>
											{/if}
										</tr>
									</thead>
									<tbody id="myTable">
										{foreach from=$u item="c"}
											<tr id="tr_{$c.id}">
												<td>{$c.id}</td>
												<td>
													<a href="users.html?do=view&id={$c.id}">{$c.name}</a> <br />
												</td>
                                                <td>{$c.email}</td>
                                                <td>{$c.mobile}</td>
                                               <td>{$c.city}</td>
                                                <td>{$c.address}</td>
                                                <td>{$c.type}</td>
                                                <td>
													{if $c.volunteer   eq 1}
													<a class="badge bg-success status_deactive" id="{$c.id}"  title="{$lang.deactivation}">{$lang.active}</a>
													{else}<a class="badge bg-danger status_active" id="{$c.id}" title="{$lang.activation}"> {$lang.deactive} </a>
													{/if}
												</td>
                                                <td>
													{if $c.status  eq 1}
													<a class="badge bg-success status_deactive" id="{$c.id}"  title="{$lang.deactivation}">{$lang.active}</a>
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
										{if $group.governorates_edit eq "1" || $group.governorates_delete eq "1" || $group.cities_list eq "1"  }
											{if $group.governorates_add eq 1 }
												<td colspan="3" align="right">{$pager}</td>
												<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="users.html?do=add">{$lang.add_user}</a></td>
											{else}
												<td colspan="4" align="right">{$pager}</td>
											{/if}
										{else}
											{if $group.governorates_add eq 1 }
												<td colspan="2" align="right">{$pager}</td>
												<td colspan="1" align="left"><a class="btn btn-success btn-sm pull-left" href="users.html?do=add">{$lang.add_user}</a></td>
											{else}
												<td colspan="3" align="right">{$pager}</td>
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
						<header class="panel-heading"> {$lang.edit_users}( # {$u.id} )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="users.html?do=update&id={$u.id}" enctype="multipart/form-data">

							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" placeholder="{$lang.name}" value="{if $n}{$n.name}{else}{$u.name}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.name}</label>
							</div>
                     <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" placeholder="{$lang.email}" value="{if $n}{$n.email}{else}{$u.email}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.email}</label>
							</div>
                         <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email_key" placeholder="{$lang.email_key}" value="{if $n}{$n.email_key}{else}{$u.email_key}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.email_key}</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="email_verified">
										<option value="0" {if $n}{if $n.email_verified eq 0}selected="selected"{/if}{else}{if $u.email_verified eq 0}selected="selected"{/if}{/if}>{$lang.deactive}</option>
										<option value="1" {if $n}{if $n.email_verified eq 1}selected="selected"{/if}{else}{if $u.email_verified eq 1}selected="selected"{/if}{/if}>{$lang.active}</option>
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.email_verified}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile" placeholder="{$lang.mobile}" value="{if $n}{$n.mobile}{else}{$u.mobile}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.mobile}</label>
							</div>
                         <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile_key" placeholder="{$lang.mobile_key}" value="{if $n}{$n.mobile_key}{else}{$u.mobile_key}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.mobile_key}</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="mobile_verified">
										<option value="0" {if $n}{if $n.mobile_verified eq 0}selected="selected"{/if}{else}{if $u.mobile_verified eq 0}selected="selected"{/if}{/if}>{$lang.deactive}</option>
										<option value="1" {if $n}{if $n.mobile_verified eq 1}selected="selected"{/if}{else}{if $u.mobile_verified eq 1}selected="selected"{/if}{/if}>{$lang.active}</option>
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.mobile_verified}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="address" placeholder="{$lang.address}" value="{if $n}{$n.address}{else}{$u.address}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.address}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="type" placeholder="{$lang.type}" value="{if $n}{$n.type}{else}{$u.type}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.type}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="volunteer">
										<option value="0" {if $n}{if $n.volunteer eq 0}selected="selected"{/if}{else}{if $u.volunteer eq 0}selected="selected"{/if}{/if}>{$lang.deactive}</option>
										<option value="1" {if $n}{if $n.volunteer eq 1}selected="selected"{/if}{else}{if $u.volunteer eq 1}selected="selected"{/if}{/if}>{$lang.active}</option>
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.volunteer}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="status">
										<option value="0" {if $n}{if $n.volunteer eq 0}selected="selected"{/if}{else}{if $u.status eq 0}selected="selected"{/if}{/if}>{$lang.deactive}</option>
										<option value="1" {if $n}{if $n.volunteer eq 1}selected="selected"{/if}{else}{if $u.status eq 1}selected="selected"{/if}{/if}>{$lang.active}</option>
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.status}</label>
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
          		<input type="hidden" value="users" id="page">
          		<input type="hidden" value="{$lang.users}" id="lang_name">
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
						<header class="panel-heading"> {$lang.users_details} ( # {$u.id} )</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="users.html?do=update&id={$u.id}">
							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.name} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.name} </span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.email} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.email} </span>
							</div>

							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.email_verified} : </strong></span>
								<span style="width:80%;display:inline-block;">{if $u.email_verified eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.mobile} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.mobile} </span>
							</div>

							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.mobile_verified} : </strong></span>
								<span style="width:80%;display:inline-block;">{if $u.mobile_verified eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
							</div>
                             <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.address} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.address} </span>
							</div>
                          <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.type} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.type} </span>
							</div>

							<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.volunteer} : </strong></span>
								<span style="width:80%;display:inline-block;">{if $u.volunteer eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
							</div>
                     <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.status} : </strong></span>
								<span style="width:80%;display:inline-block;">{if $u.status eq 0}{$lang.deactive}{else}{$lang.active}{/if}</span>
							</div>

							<div class="form-group" id="item_{$u.id}">
								<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();"style="margin-{$lang.dir_fe}: 20px">{$lang.print}</a>
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
						<header class="panel-heading"> {$lang.add_users}</header>
						<div class="panel-body">
						<form class="form-horizontal" role="form" method="post" action="users.html?do=add" enctype="multipart/form-data">
							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="name" placeholder="{$lang.name}" value="{if $n}{$n.name}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.name}</label>
							</div>
                       <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" placeholder="{$lang.email}" value="{if $n}{$n.email}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.email}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email_key" placeholder="{$lang.email_key}" value="{if $n}{$n.email_key}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.email_key}</label>
							</div>
                       <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile" placeholder="{$lang.mobile}" value="{if $n}{$n.mobile}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.mobile}</label>
							</div>

							<div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="mobile_key" placeholder="{$lang.mobile_key}" value="{if $n}{$n.mobile_key}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.mobile_key}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="address" placeholder="{$lang.address}" value="{if $n}{$n.address}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.address}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<input type="text" class="form-control" name="type" placeholder="{$lang.type}" value="{if $n}{$n.type}{/if}">
								</div>
								<label class="col-sm-2 control-label">{$lang.type}</label>
							</div>
							<div class="form-group">
								<div class="col-sm-10"><button type="submit" class="btn btn-default">{$lang.add_user}</button></div>
							</div>
						</form>
						</div>
					</section>
					</div>
				</div>
			{/if}
