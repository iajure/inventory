<?php /* Salary index: DataTable listing all salary records */ ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Manage Salaries</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Salary</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>
        <a href="<?php echo base_url('Controller_Salary/create') ?>" class="btn btn-primary">Add Salary</a>
        <br /> <br />
        <div class="box">
          <div class="box-body">
            <div class="table-responsive" style="overflow-x:auto;">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Employee</th>
                    <th>Month</th>
                    <th>Basic Salary</th>
                    <th>Allowances</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Salary Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($salary_data) && count($salary_data) > 0): ?>
                    <?php foreach($salary_data as $row): ?>
                      <tr>
                        <td><?= htmlspecialchars($row['employee_name']) ?></td>
                        <td><?= isset($row['month']) ? htmlspecialchars($row['month']) : '' ?></td>
                        <td><?= number_format($row['basic_salary'],2) ?></td>
                        <td><?= number_format($row['allowances'],2) ?></td>
                        <td><?= number_format($row['deductions'],2) ?></td>
                        <td><?= number_format($row['net_salary'],2) ?></td>
                        <td><?= htmlspecialchars($row['salary_date']) ?></td>
                        <td>
                            <a href="<?= base_url('Controller_Salary/edit/'.$row['id']) ?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal" data-id="<?= $row['id'] ?>"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center">No salary records found.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Remove Salary Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Remove Salary</h4>
        </div>
        <form role="form" action="<?= base_url('Controller_Salary/delete') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <input type="hidden" name="id" id="remove_id" value="">
            <p>Do you really want to remove?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
  $('#removeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    $('#remove_id').val(id);
  });
  </script>
</div>
<script>
$j(document).ready(function() {
  $j('#manageTable').DataTable({
    'ajax': '<?php echo base_url('Controller_Salary/fetchSalaryData'); ?>',
    'order': []
  });
});
// Remove function
function removeFunc(id) {
  if(confirm('Are you sure to delete this record?')) {
    $j.ajax({
      url: '<?php echo base_url('Controller_Salary/remove'); ?>',
      type: 'POST',
      data: {id: id},
      success: function(resp) {
        $j('#manageTable').DataTable().ajax.reload(null, false);
      }
    });
  }
}
</script>
