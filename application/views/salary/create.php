<?php /* Salary create: Add new salary record */ ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Add Salary</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Salary</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>
        <div class="box">
          <form role="form" action="<?php echo base_url('Controller_Salary/create') ?>" method="post">
            <div class="box-body">
              <?php echo validation_errors(); ?>
              <div class="form-group">
                <label for="user_id">Employee</label>
                <select id="user_id" name="user_id" class="form-control" required>
                  <option value="">Select Employee</option>
                  <?php if(isset($users)) foreach($users as $user): ?>
                    <option value="<?= $user['id'] ?>" data-name="<?= htmlspecialchars($user['firstname'].' '.$user['lastname']) ?>">
                      <?= htmlspecialchars($user['firstname'].' '.$user['lastname']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
                <div class="form-group">
                  <label for="month">Salary Month</label>
                  <select class="form-control" id="month" name="month" required>
                    <option value="">Select Month</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
              <div class="form-group">
                <label for="employee_name">Name</label>
                <input type="text" class="form-control" id="employee_name" name="employee_name" readonly />
              </div>
              <!-- Position field skipped -->
              <div class="form-group">
                <label for="basic_salary">Basic Salary</label>
                <input type="number" step="0.01" class="form-control" id="basic_salary" name="basic_salary" required />
              </div>
              <div class="form-group">
                <label for="allowances">Allowances</label>
                <input type="number" step="0.01" class="form-control" id="allowances" name="allowances" value="0" />
              </div>
              <div class="form-group">
                <label for="deductions">Deductions</label>
                <input type="number" step="0.01" class="form-control" id="deductions" name="deductions" value="0" />
              </div>
              <div class="form-group">
                <label for="net_salary">Net Salary</label>
                <input type="number" step="0.01" class="form-control" id="net_salary" name="net_salary" readonly />
              </div>
              <div class="form-group">
                <label for="salary_date">Salary Date</label>
                <input type="date" class="form-control" id="salary_date" name="salary_date" value="<?php echo date('Y-m-d'); ?>" required />
              </div>
              <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo base_url('Controller_Salary/') ?>" class="btn btn-danger">Back</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
// Auto-fill employee name and net salary calculation
$(document).ready(function() {
  $('#user_id').change(function() {
    var selected = $(this).find(':selected');
    $('#employee_name').val(selected.data('name') || '');
  });
  function calcNet() {
    var basic = parseFloat($('#basic_salary').val()) || 0;
    var allow = parseFloat($('#allowances').val()) || 0;
    var ded = parseFloat($('#deductions').val()) || 0;
    $('#net_salary').val((basic + allow - ded).toFixed(2));
  }
  $('#basic_salary, #allowances, #deductions').on('input', calcNet);
});
</script>
