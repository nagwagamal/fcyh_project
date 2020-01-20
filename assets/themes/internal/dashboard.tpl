   {if $area_name eq 'list'}
	<input type="hidden" value="location" id="page">
	<input type="hidden" value="{$lang.product}" id="lang_name">
	<input type="hidden" value="{$lang.location}" id="sheet">
	<input type="hidden" value="{$lang.delete_alarm_massage_in_men}" id="lang_del">
	<input type="hidden" value="{$lang.status_alarm_massage_in_men}" id="lang_status">
   
	<ol class="breadcrumb">
		<li>
			<a href="index.html"><i class="ti-home ml5"></i>{$lang.NDX_PAGE_NAME}</a>
		</li>
		<li class="active">{$title}</li>
	</ol>
	<div class="row mt">
		<div class="col-md-12">
			<section class="">{$export}
				<div class="panel-heading no-b">
					
				</div>
				<div class="panel-body col-m-8" style='background-color: white;width: 422px;'>
						<h4>{$lang.rep_no_location}</h4>
					<div class="table-responsive">
						<div class="table-wrapper-scroll-y my-custom-scrollbar" style="position: relative;height: 200px;overflow: auto;">
							{if $u}
							<table class="table table-bordered table-striped mb-0">
								<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">{$lang.reps}</th>
									<th scope="col">{$lang.date}</th>
									<th scope="col">{$lang.time}</th>
								</tr>
								</thead>
									<tbody>
									{foreach from=$u item="c" key="k"}
										<tr>
											<th scope="row">{$k+1}</th>
											<td><a href="tel:{$c.mobile}" style="font-size: 17px;color: black;"> {$c.name} </a></td>
											<td>{$c.D}</td>
											<td>{$c.T|_time_format}</td>
										</tr>
										
									{/foreach}
									</tbody>
							</table>
							{else}
								{$lang.no_close_location}		
							{/if}

						</div>
				
					</div>
				</div>
				
			</section>
		</div>
	</div>
{/if}