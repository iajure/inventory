<?php /* Salary edit: Edit salary record */ ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Salary</h1>
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
          <form role="form" action="<?php echo base_url('Controller_Salary/edit/'.$salary['id']) ?>" method="post">
            <div class="box-body">
              <?php echo validation_errors(); ?>
              <div class="form-group">
                <label for="user_id">Employee</label>
                <select id="user_id" name="user_id" class="form-control" required disabled>
                  <option value="">Select Employee</option>
                  <?php if(isset($users)) foreach($users as $user): ?>
                    <option value="<?= $user['id'] ?>" data-name="<?= htmlspecialchars($user['firstname'].' '.$user['lastname']) ?>" <?= ($user['id'] == $salary['user_id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($user['firstname'].' '.$user['lastname']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="employee_name">Name</label>
                <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?= htmlspecialchars($salary['employee_name']) ?>" readonly />
              </div>
              <div class="form-group">
                <label for="month">Salary Month</label>
                <select class="form-control" id="month" name="month" required>
                  <option value="">Select Month</option>
                  <?php $months = ["January","February","March","April","May","June","July","August","September","October","November","December"]; ?>
                  <?php foreach($months as $m): ?>
                    <option value="<?= $m ?>" <?= ($salary['month'] == $m) ? 'selected' : '' ?>><?= $m ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <!-- Position field skipped -->
              <div class="form-group">
                <label for="basic_salary">Basic Salary</label>
                <input type="number" step="0.01" class="form-control" id="basic_salary" name="basic_salary" value="<?= htmlspecialchars($salary['basic_salary']) ?>" required />
              </div>
              <div class="form-group">
                <label for="allowances">Allowances</label>
                <input type="number" step="0.01" class="form-control" id="allowances" name="allowances" value="<?= htmlspecialchars($salary['allowances']) ?>" />
              </div>
              <div class="form-group">
                <label for="deductions">Deductions</label>
                <input type="number" step="0.01" class="form-control" id="deductions" name="deductions" value="<?= htmlspecialchars($salary['deductions']) ?>" />
              </div>
              <div class="form-group">
                <label for="net_salary">Net Salary</label>
                <input type="number" step="0.01" class="form-control" id="net_salary" name="net_salary" value="<?= htmlspecialchars($salary['net_salary']) ?>" readonly />
              </div>
              <div class="form-group">
                <label for="salary_date">Salary Date</label>
                <input type="date" class="form-control" id="salary_date" name="salary_date" value="<?= htmlspecialchars($salary['salary_date']) ?>" required />
              </div>
              <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="Notes"><?= htmlspecialchars($salary['notes']) ?></textarea>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
// Net salary calculation
$j(document).ready(function() {
  function calcNet() {
    var basic = parseFloat($j('#basic_salary').val()) || 0;
    var allow = parseFloat($j('#allowances').val()) || 0;
    var ded = parseFloat($j('#deductions').val()) || 0;
    $j('#net_salary').val((basic + allow - ded).toFixed(2));
  }
  $j('#basic_salary, #allowances, #deductions').on('input', calcNet);
});
</script>
