<div class="modal fade bs-example-modal-sm modal-update-password" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="mySmallModalLabel">Change Password</h4>
			</div>
      <form id="form_ajax_update_password" method="post" action="index.php?module=profile" role="form">
        <div class="modal-body">
            <div class="form-group">
              <label class="control-label" for="current_password">Current password</label>
              <input name="current_password" type="password" required maxlength="30" class="form-control" id="current_password">
            </div>
            <div class="form-group">
              <label class="control-label" for="new_password">New password</label>
              <input name="new_password" type="password" required maxlength="30" class="form-control" id="new_password">
            </div>
            <div class="form-group">
              <label class="control-label" for="confirm_password">Confirm password</label>
              <input name="confirm_password" type="password" required maxlength="30" class="form-control" id="confirm_password">
            </div>

            <input type="hidden" name="action" value="updatePassword">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger"><i class="fa fa-key"></i> Change Password</button>
        </div>
      </form>      
		</div>  
	</div>
</div>
