<div class="modal fade modal_mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">New mail to <span id="mail_space"></span></h4>
      </div>
      <form method="post" action="index.php?module=adminUsers" role="form">
        <div class="modal-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Subject</label>
              <input name="subject" type="text" required maxlength="500" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
              <label for="inputMailContent">Content</label>
              <textarea name="content" required id="inputMailContent" class="form-control" rows="8"></textarea>
            </div>
            <input type="hidden" name="input_mail" value="" id="input_mail">
            <input type="hidden" name="action" value="send_mail">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-send"></span> Send</button>
        </div>
      </form>      
    </div>
  </div>
</div>