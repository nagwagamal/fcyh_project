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
                            <form class="form-horizontal" action="tasks.php?do=add"  role="form" method="post"enctype="multipart/form-data">
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
											<option value="{$_c.id}" {if $_c.id eq $n.cat_name}selected="selected"{/if}>{$_c.cat_name}</option>
										{/foreach}
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.category}</label>
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
									<select class="form-control" name="category">
										<option value="0" selected="selected">{$lang.choose_user}</option>
										{foreach from=$p item="_p"}
											<option value="{$_p.id}" {if $_p.id eq $n.user_name}selected="selected"{/if}>{$_p.name}</option>
										{/foreach}
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.user_task_name}</label>
							</div>
                            <div class="form-group">
								<div class="col-sm-10">
									<select class="form-control" name="assigned">
										<option value="0" selected="selected">{$lang.choose_user}</option>
										{foreach from=$p item="_p"}
											<option value="{$_p.id}" {if $_p.id eq $n.user_name}selected="selected"{/if}>{$_p.name}</option>
										{/foreach}
									</select>
								</div>
								<label class="col-sm-2 control-label">{$lang.user_assigned_name}</label>
							</div>
                         <div class="form-group">
								<div class="col-sm-10">
								<input  autocomplete="off" class="date form-control"  placeholder="dd/mm/yyyy" name="requested_time">
								</div>
								<label class="col-sm-2 control-label">{$lang.requested_time}</label>
							</div>
                                <div class="form-group">
								<div class="col-sm-10">
								<input  autocomplete="off" class="date form-control"  placeholder="dd/mm/yyyy" name="arrived_time">
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

{/if}
