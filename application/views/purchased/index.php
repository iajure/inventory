<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Purchased Items

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Purchased</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php if(in_array('createPurchased', $user_permission)): ?>
          <a href="<?php echo base_url('Controller_Purchased/create') ?>" class="btn btn-primary">Add Product2</a>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <a href="<?php echo base_url('Controller_Purchased/create') ?>" class="btn btn-primary">Add Purchased Item</a>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row" style="margin-bottom:10px;">
              <div class="col-md-6"></div>
              <div class="col-md-6 text-right">
                <label for="date_from">From:</label>
                <input type="date" id="date_from" style="margin-right:10px;">
                <label for="date_to">To:</label>
                <input type="date" id="date_to">
              </div>
            </div>
            <div class="table-responsive" style="overflow-x:auto;">
            <div class="table-responsive" style="overflow-x:auto;">
              <table id="manageTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Description</th>
                    <th>Arrived</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
            </div>
<script type="text/javascript">
var manageTable = null;
var base_url = "<?php echo base_url(); ?>";

$j(document).ready(function() {
  function loadTable(date_from, date_to) {
    var ajaxUrl = base_url + 'Controller_Purchased/fetchPurchasedData';
    if (date_from || date_to) {
      ajaxUrl += '?';
      if (date_from) ajaxUrl += 'date_from=' + date_from + '&';
      if (date_to) ajaxUrl += 'date_to=' + date_to;
    }
    if ($.fn.DataTable.isDataTable('#manageTable')) {
      $('#manageTable').DataTable().clear().destroy();
      $('.table-responsive').html('<table id="manageTable" class="table table-bordered table-striped">'+
        '<thead><tr>'+
        '<th>Image</th>'+
        '<th>Product</th>'+
        '<th>Qty</th>'+
        '<th>Description</th>'+
        '<th>Arrived</th>'+
        '<th>Action</th>'+
        '</tr></thead></table>');
    }
    manageTable = $('#manageTable').DataTable({
      dom: 'Bfrtip',
      buttons: ['copy', 'csv', 'excel', 'print'],
      'ajax': ajaxUrl,
      'order': []
    });
  }

  // Initial load
  loadTable();

  // Date range filter
  $('#date_from, #date_to').on('change', function() {
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    loadTable(date_from, date_to);
  });
});
</script>
          </div>
        </div>
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if(in_array('deleteProduct', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" action="<?= base_url('Controller_Purchased/remove') ?>" method="post" id="removeForm">
        <div class="modal-header">
          <h4 class="modal-title">Remove Purchased Item</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="product_id" id="product_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.modal -->
<?php endif; ?>

<script>
function removeFunc(id) {
  if(id) {
    $j('#product_id').val(id);
    $j('#removeModal').modal({backdrop: 'static', keyboard: false});
    $j('#removeForm').off('submit').on('submit', function() {
      var form = $j(this);
      $j('.text-danger').remove();
      $j.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { product_id: id },
        dataType: 'json',
        success: function(response) {
          $j('#manageTable').DataTable().ajax.reload(null, false);
          if(response.success === true) {
            $j('#messages').html('<div class="alert alert-success alert-dismissible" role="alert"'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');
            $j('#removeModal').modal('hide');
          } else {
            $j('#messages').html('<div class="alert alert-warning alert-dismissible" role="alert"'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      });
      return false;
    });
  }
}
$(document).ready(function() {
  var table = $('#manageTable').DataTable({
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'print'
    ]
  });

  // Remove form submit with double-submit protection
  var removeSubmitting = false;
  $('#removeForm').on('submit', function(e) {
    e.preventDefault();
    if (removeSubmitting) {
      console.log('Delete already submitted, ignoring.');
      return;
    }
    removeSubmitting = true;
    var form = $(this);
    var id = $('#product_id').val();
    console.log('Submitting delete for id:', id);
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: { product_id: id },
      dataType: 'json',
      success: function(response) {
        $('#removeModal').modal('hide');
        removeSubmitting = false;
        if(response.success === true) {
          $('#messages').html('<div class="alert alert-success alert-dismissible" role="alert"'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');
          setTimeout(function() { $('#messages .alert').fadeOut('slow'); }, 3000);
          $('#manageTable').DataTable().row($('button[onclick="removeFunc('+id+')"]').parents('tr')).remove().draw();
        } else {
          $('#messages').html('<div class="alert alert-warning alert-dismissible" role="alert"'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
          '</div>');
          setTimeout(function() { $('#messages .alert').fadeOut('slow'); }, 3000);
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