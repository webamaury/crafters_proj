<!-- CREDIT CARD - SHOPPING BAG -->
<div class="modal" id="modal-shoppingbag" tabindex="-1" role="dialog" aria-labelledby="modal-shoppingbag-label"
     aria-hidden="true" style="padding-top: 100px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal-shoppingbag-label">Your shopping bag</h4>
			</div>
			<div class="modal-body">
				<div class="row center-block">
					<div class="col-md-12">
						<div class="col-md-6">
							<span class="ajax_all_quantity">0 product</span>
						</div>
						<div class="col-md-6 text-right">
							Total : <span class="ajax_all_price">0</span> €
						</div>
						<br/>

						<hr/>

						<form role="form" class="ajax_display_cart_content maxheight300">
							<!--<div class="col-md-12">
								<div class="col-md-4">
									<img src="illu/13.jpg" class="img-responsive">
								</div>
								<div class="col-md-5 description-achat">
									<br/>

									<p><strong>Geometric illusion</strong></p>

									<p>
										<small>From Geo Trouvetout</small>
									</p>
									<p>
										<small>Quantity: 2</small>
									</p>
									<p>
										<small>Quantity: 2</small>
									</p>
								</div>
								<div class="col-md-3">
									<br/>
									<br/>

									<p class="price">9$</p>
								</div>
							</div>-->
						</form>
						<div class="col-xs-12">
							<br/>
							Delivery:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="hidden" name="delivery_ajax" class="delivery_ajax" value="<?php echo (isset($_SESSION[_SES_NAME]['Delivery'])) ? $_SESSION[_SES_NAME]['Delivery'] : "0" ; ?>">

							<label class="radio-inline">
								<input type="radio" name="delivery" id="inlineRadio1" value="0"<?php echo ((isset($_SESSION[_SES_NAME]['Delivery']) && $_SESSION[_SES_NAME]['Delivery'] == 0) || !isset($_SESSION[_SES_NAME]['Delivery'])) ? " checked" : "" ; ?>> Normal (6€)
							</label>
							<label class="radio-inline">
								<input type="radio" name="delivery" id="inlineRadio2" value="1"<?php echo (isset($_SESSION[_SES_NAME]['Delivery']) && $_SESSION[_SES_NAME]['Delivery'] == 1) ? " checked" : "" ; ?>> Express (10€)
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" href="index.php?module=commande">Buy it</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
