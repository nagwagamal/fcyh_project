          	{if $area_name eq 'list'}
          		<input type="hidden" value="chats" id="page">
          		<input type="hidden" value="{$lang.chats}" id="lang_name">
          		<input type="hidden" value="{$lang.chats}" id="sheet">
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
								<h5> {$lang.list} <b> {$lang.chats} </b></h5>
								<br>
								<input id="myInput" type="text" class="form-control" placeholder="{$lang.search}">
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="tableau_eleves table table-bordered table-striped">
									<thead>
										<tr>
											<th>#</th>
											<th>{$lang.from_user}</th>
											<th>{$lang.to_user}</th>
											<th>{$lang.message} </th>
											<th>{$lang.time} </th>
										</tr>
									</thead>
									<tbody id="myTable">
										{foreach from=$u item="c"}
											<tr id="tr_{$c.id}">
                                                <td><a href="chats.html?do=view&id={$c.id}">{$c.id}</a></td>
                                                <td>{getFromTable a=$c.from_user b="users" c="getUsersInformation" d="name"}
													</td>
                                                <td>{getFromTable a=$c.to_user b="users" c="getUsersInformation" d="name"}
													</td>
<!--
												<td>{$c.from_user}</td>
-->
<!--
												<td>{$c.to_user}</td>
-->
												<td>{$c.message}</td>
												<td>{$c.time}</td>

											</tr>
										{/foreach}
									</tbody>

								</table>
							</div>
							</div>
						</section>

					</div>
				</div>
{elseif $area_name eq 'view'}
          		<input type="hidden" value="chats" id="page">
          		<input type="hidden" value="{$lang.chats}" id="lang_name">
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
						<header class="panel-heading"> {$lang.chats_details} ( # {$u.id} )</header>
						<div class="panel-body">
                             <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.from_user} : </strong></span>
								<span style="width:80%;display:inline-block;">{getFromTable a=$u.from_user b="users"  c="getUsersInformation" d="name"} </span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong> {$lang.to_user} : </strong></span>
								<span style="width:80%;display:inline-block;">{getFromTable a=$u.to_user b="users"  c="getUsersInformation" d="name"} </span>
							</div>

							<!--<div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.from_user} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.from_user} </span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.to_user} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.to_user} </span>
							</div>-->
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.message} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.message} </span>
							</div>
                            <div class="alert alert-info">
								<span style="width:15%;display:inline-block;vertical-align:top;"><strong>{$lang.time} : </strong></span>
								<span style="width:80%;display:inline-block;">{$u.time} </span>
							</div>

							<div class="form-group" id="item_{$u.id}">
								<a class="hidden-print btn btn-info btn-sm" href="javascript:window.print();"style="margin-{$lang.dir_fe}: 20px">{$lang.print}</a>
							</div>
						</div>
					</section>
					</div>
				</div>
			{/if}
