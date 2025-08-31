

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      </ol>
    </section>
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
    

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
        <div class="col-md-12 col-xs-12">
          
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

            <form role="form" action="<?php base_url('Controller_Permission/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="group_name">Permission Name</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name">
                </div>
                <div class="form-group">
                  <label for="permission">Permission</label>

                  <table class="table table-responsive">
                    <thead>
                      <tr>

                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Salary</td>
                        <td><input type="checkbox" name="permission[]" value="createSalary" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" value="updateSalary" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" value="viewSalary" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" value="deleteSalary" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Members</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createUser" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUser" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Permission</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createGroup" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Settings</td>
                        <td></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSettings" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewSettings" class="minimal"></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Elements</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createAttribute" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateAttribute" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewAttribute" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteAttribute" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Element Sales</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createAttributeSales" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateAttributeSales" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewAttributeSales" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteAttributeSales" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Products</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createProduct" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateProduct" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewProduct" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteProduct" class="minimal"></td>
                      </tr>
                      <tr>
<tr>
  <td>Purchased</td>
  <td><input type="checkbox" name="permission[]" value="createPurchased" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="updatePurchased" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="viewPurchased" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="deletePurchased" class="minimal"></td>
</tr>
<tr>
  <td>Sales</td>
  <td><input type="checkbox" name="permission[]" value="createSales" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="updateSales" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="viewSales" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="deleteSales" class="minimal"></td>
</tr>
<tr>
  <td>Returns</td>
  <td><input type="checkbox" name="permission[]" value="createReturns" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="updateReturns" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="viewReturns" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="deleteReturns" class="minimal"></td>
</tr>
<tr>
  <td>Customers</td>
  <td><input type="checkbox" name="permission[]" value="createCustomers" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="updateCustomers" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="viewCustomers" class="minimal"></td>
  <td><input type="checkbox" name="permission[]" value="deleteCustomers" class="minimal"></td>
</tr>

                      <tr>
                        <td>Orders</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createOrder" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateOrder" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrder" class="minimal"></td>
                      </tr>
                      <tr>
  <td>Reports</td>
  <td><input type="checkbox" disabled></td> <!-- Update disabled -->
  <td><input type="checkbox" disabled></td> <!-- Create disabled -->
  <td><input type="checkbox" name="permission[viewReport]" value="viewReports"></td>
  <td><input type="checkbox" disabled></td> <!-- Delete disabled -->
</tr>

                      <tr>
                        <td>Company</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCompany" class="minimal"></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                  
                    </tbody>
                  </table>
                  
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save & Close</button>
                <a href="<?php echo base_url('Controller_Permission/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       
      </div>
      <!-- /.box -->

 

    </section>