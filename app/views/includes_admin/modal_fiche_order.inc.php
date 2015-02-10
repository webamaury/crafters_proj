<div class="modal fade modal_fiche_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Details about the order of <span class="ajax_firstname"></span></h4>
			</div>
			<div class="modal-body display-inline modal_order">
				<div class="col-md-12">
					<form class="form-horizontal" method="post" action="#" role="form">
						<div class="display-inline">
							<label class="col-md-4 control-label">Creation : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_datecrea"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Status : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_status"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Product number : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_nbproduit"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Name : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_name"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Firstname : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_firstname"></p>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-12">
					<h4 class="text-center">Billing address</h4>
					<form class="form-horizontal" method="post" action="#" role="form">
						<div class="display-inline">
							<label class="col-md-4 control-label">Street : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_numberstreet"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Town : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_town"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Zipcode : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_zipcode"></p>
							</div>
						</div>
						<div class="display-inline">
							<label class="col-md-4 control-label">Country : </label>
							<div class="col-md-8">
								<p class="form-control-static ajax_country"></p>
							</div>
						</div>
					</form>
				</div>
				<div class="col-xs-12 table-responsive">
					<table class="table_modal table-bordered table-striped">
						<thead>
						<tr>
							<th>#</th>
							<th>Type</th>
							<th>Quantity</th>
							<th>Name</th>
							<th>Size</th>
						</tr>
						</thead>
						<tbody class="product_order">

						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>