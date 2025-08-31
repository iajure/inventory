<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <h1>Manage Customers</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Customers</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages">
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
        </div>
        <div class="box">
          <div class="box-header">
            <a href="<?php echo base_url('Controller_Customers/create') ?>" class="btn btn-primary">Add Customer</a>
          </div>
          <div class="box-body">
            <div class="table-responsive" style="overflow-x:auto;">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(isset($customers) && count($customers)): ?>
                  <?php foreach($customers as $item): ?>
                    <tr>
                      <td><?= isset($item['customer_name']) ? htmlspecialchars($item['customer_name']) : '' ?></td>
                      <td><?= isset($item['phone']) ? htmlspecialchars($item['phone']) : '' ?></td>
                      <td><?= isset($item['date']) ? htmlspecialchars($item['date']) : '' ?></td>
                      <td><?= isset($item['description']) ? htmlspecialchars($item['description']) : '' ?></td>
                      <td>
                        <a href="<?= base_url('Controller_Customers/update/'.$item['id']) ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-danger" onclick="removeFunc(<?= $item['id'] ?>)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="4">No customers found.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
            </div>
</div>
<!-- DataTables and export scripts -->
<!-- DataTables and export scripts at the end to avoid reinitialization -->
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script>
var $j = jQuery.noConflict(true);
$j(document).ready(function() {
  // Removed duplicate DataTable initialization to prevent reinitialization error
});
</script>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";
$j(document).ready(function() {
  $j("#mainCustomersNav").addClass('active');
  manageTable = $j('#manageTable').DataTable({
    'ajax': '<?= base_url("Controller_Customers/fetchCustomersData") ?>',
    'order': []
  });
});
function removeFunc(id)
{
  if(id) {
    $j("#removeForm").on('submit', function() {
      var form = $(this);
      $j(".text-danger").remove();
      $j.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { customer_id:id }, 
        dataType: 'json',
        success:function(response) {
          manageTable.ajax.reload(null, false); 
          if(response.success === true) {
            $j("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');
            $("#removeModal").modal('hide');
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
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
      <form role="form" action="<?= base_url('Controller_Customers/remove') ?>" method="post" id="removeForm">
        <div class="modal-header">
          <h4 class="modal-title">Remove Customer</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="customer_id" id="customer_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
