<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <h1>Manage Returned Items</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Returns</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>
        <div class="box">
          <div class="box-header">
            <a href="<?php echo base_url('Controller_Returns/create') ?>" class="btn btn-primary">Add Returned Item</a>
          </div>
          <div class="box-body">
            <div class="table-responsive" style="overflow-x:auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Qty</th>
                  <th>Return Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($returns) && count($returns)): ?>
                  <?php foreach($returns as $item): ?>
                    <tr>
                      <td>
                        <?php
                          $img = !empty($item['image']) ? basename($item['image']) : 'default.jpg';
                          $img_path = FCPATH . 'assets/images/returns_image/' . $img;
                          $img_url = (file_exists($img_path) && is_file($img_path))
                            ? base_url('assets/images/returns_image/' . $img)
                            : base_url('assets/images/returns_image/default.jpg');
                        ?>
                        <img src="<?= $img_url ?>" alt="image" class="img-circle" width="50" height="50">
                      </td>
                      <td><?= htmlspecialchars($item['name']) ?></td>
                      <td><?= htmlspecialchars($item['qty']) ?></td>
                      <td><?= htmlspecialchars($item['return_date']) ?></td>
                      <td><?= htmlspecialchars($item['description']) ?></td>
                      <td>
                        <a href="<?= base_url('Controller_Returns/update/'.$item['id']) ?>" class="btn btn-info"><i class="fa fa-info-circle"></i></a>
                        <button type="button" class="btn btn-danger" onclick="removeFunc(<?= $item['id'] ?>)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="6">No return items found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
function removeFunc(id) {
  if(id) {
    $('#return_id').val(id);
    $('#removeModal').modal('show');
  }
}
$(document).ready(function() {
  var table = $('#manageTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'print'
    ]
  });

  $('#manageTable_filter input').unbind().bind('input', function(e) {
    table.search(this.value).draw();
  });

  $('#removeForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var id = $('#return_id').val();
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: { return_id: id },
      dataType: 'json',
      success: function(response) {
        $('#removeModal').modal('hide');
        if(response.success === true) {
          $('#messages').html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');
          table.row($('button[onclick="removeFunc('+id+')"]').parents('tr')).remove().draw();
        } else {
          $('#messages').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
          '</div>');
        }
      }
    });
  });
});
</script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<!-- Delete Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" action="<?= base_url('Controller_Returns/remove') ?>" method="post" id="removeForm">
        <div class="modal-header">
          <h4 class="modal-title">Remove Returned Item</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="return_id" id="return_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="return_id" id="return_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
