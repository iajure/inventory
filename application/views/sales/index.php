<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

<div class="content-wrapper">
  <section class="content-header">
    <h1>Manage Sales Items</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Sales</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>
        <div class="box">
          <div class="box-header">
            <a href="<?php echo base_url('Controller_Sales/create') ?>" class="btn btn-primary">Add Sales Item</a>
          </div>
          <div class="box-body">
            <div class="table-responsive" style="overflow-x:auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Sales Date</th>
                  <th>Description</th>
                  <th>Return</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($sales) && count($sales)): ?>
                  <?php foreach($sales as $item): ?>
                    <tr>
                      <td>
                        <?php
                          $img = !empty($item['image']) ? basename($item['image']) : 'default.jpg';
                          // Always use the sales_image folder for sales images
                          $img_url = base_url('assets/images/sales_image/' . $img);
                        ?>
                        <img src="<?= $img_url ?>" alt="image" class="img-circle" width="50" height="50">
                      </td>
                      <td><?= htmlspecialchars($item['name']) ?></td>
                      <td>$<?= htmlspecialchars($item['price']) ?></td>
                      <td><?= htmlspecialchars($item['qty']) ?></td>
                      <td><?= htmlspecialchars($item['sales_date']) ?></td>
                      <td><?= htmlspecialchars($item['description']) ?></td>
                      <td>
                        <?php if ($item['is_returned'] == 1): ?>
                          <span class="label label-primary">Returned</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($item['is_returned'] == 1): ?>
                          <a href="<?= base_url('Controller_Sales/update/'.$item['id']) ?>" class="btn btn-info"><i class="fa fa-info-circle"></i></a>
                          <button type="button" class="btn btn-danger" onclick="removeFunc(<?= $item['id'] ?>)"><i class="fa fa-trash"></i></button>
                        <?php else: ?>
                          <a href="<?= base_url('Controller_Sales/update/'.$item['id']) ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                          <button type="button" class="btn btn-danger" onclick="removeFunc(<?= $item['id'] ?>)"><i class="fa fa-trash"></i></button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="7">No sales items found.</td></tr>
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
<!-- Delete Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" action="<?= base_url('Controller_Sales/remove') ?>" method="post" id="removeForm">
        <div class="modal-header">
          <h4 class="modal-title">Remove Sales Item</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="sale_id" id="sale_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function removeFunc(id) {
  if(id) {
    $('#sale_id').val(id);
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
    var id = $('#sale_id').val();
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: { sale_id: id },
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
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script>
$(document).ready(function(){
  $('.delete-sale').click(function(){
    var id = $(this).data('id');
    if(confirm('Are you sure you want to delete this sale item?')) {
      $.post('<?= base_url("Controller_Sales/remove") ?>', { sale_id: id }, function(resp){
        location.reload();
      });
    }
  });
});
</script>
  });
});
</script>
