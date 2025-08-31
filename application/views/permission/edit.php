<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Manage Permission
    
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('Controller_Permission/') ?>">Permission</a></li>
        <li class="active">Edit</li>
      </ol>
            <div class="box-header">
            
            </div>
            <form role="form" action="<?php echo base_url('Controller_Permission/update/'.$group_data['id']) ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="group_name">Permission Name</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter permission name" value="<?php echo $group_data['group_name']; ?>">
                </div>
                <div class="form-group">
                  <label>Permissions</label>
                  <div class="checkbox">
                    <?php $serialize_permission = unserialize($group_data['permission']); ?>
                    
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
                          <td><input type="checkbox" name="permission[]" class="minimal" value="createSalary" <?php if($serialize_permission && in_array('createSalary', $serialize_permission)) echo "checked"; ?>></td>
                          <td><input type="checkbox" name="permission[]" class="minimal" value="updateSalary" <?php if($serialize_permission && in_array('updateSalary', $serialize_permission)) echo "checked"; ?>></td>
                          <td><input type="checkbox" name="permission[]" class="minimal" value="viewSalary" <?php if($serialize_permission && in_array('viewSalary', $serialize_permission)) echo "checked"; ?>></td>
                          <td><input type="checkbox" name="permission[]" class="minimal" value="deleteSalary" <?php if($serialize_permission && in_array('deleteSalary', $serialize_permission)) echo "checked"; ?>></td>
                        </tr>
                        <tr>
                          <td>Members</td>
                          <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createUser" <?php if($serialize_permission) {
                            if(in_array('createUser', $serialize_permission)) { echo "checked"; } 
                          } ?> ></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php 
                          if($serialize_permission) {
                            if(in_array('updateUser', $serialize_permission)) { echo "checked"; } 
                          }
                          ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php 
                          if($serialize_permission) {
                            if(in_array('viewUser', $serialize_permission)) { echo "checked"; }   
                          }
                          ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php 
                          if($serialize_permission) {
                            if(in_array('deleteUser', $serialize_permission)) { echo "checked"; }  
                          }
                           ?>></td>
                        </tr>
                        <tr>
                          <td>Permission</td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup" <?php 
                          if($serialize_permission) {
                            if(in_array('createGroup', $serialize_permission)) { echo "checked"; }  
                          }
                           ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup" <?php 
                          if($serialize_permission) {
                            if(in_array('updateGroup', $serialize_permission)) { echo "checked"; }  
                          }
                           ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup" <?php 
                          if($serialize_permission) {
                            if(in_array('viewGroup', $serialize_permission)) { echo "checked"; }  
                          }
                           ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup" <?php 
                          if($serialize_permission) {
                            if(in_array('deleteGroup', $serialize_permission)) { echo "checked"; }  
                          }
                           ?>></td>
                        </tr>
                        <tr>
                          <td>Settings</td>
                          <td></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSettings" <?php if($serialize_permission) { if(in_array('updateSettings', $serialize_permission)) { echo "checked"; } } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewSettings" <?php if($serialize_permission) { if(in_array('viewSettings', $serialize_permission)) { echo "checked"; } } ?>></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Elements</td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAttribute" <?php if($serialize_permission) {
                            if(in_array('createAttribute', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAttribute" <?php if($serialize_permission) {
                            if(in_array('updateAttribute', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAttribute" <?php if($serialize_permission) {
                            if(in_array('viewAttribute', $serialize_permission)) { echo "checked"; }   
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAttribute" <?php if($serialize_permission) {
                            if(in_array('deleteAttribute', $serialize_permission)) { echo "checked"; }  
                          } ?>></td>
                        </tr>
                        <tr>
                          <td>Element Sales</td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAttributeSales" <?php if($serialize_permission) {
                            if(in_array('createAttributeSales', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAttributeSales" <?php if($serialize_permission) {
                            if(in_array('updateAttributeSales', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAttributeSales" <?php if($serialize_permission) {
                            if(in_array('viewAttributeSales', $serialize_permission)) { echo "checked"; }   
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAttributeSales" <?php if($serialize_permission) {
                            if(in_array('deleteAttributeSales', $serialize_permission)) { echo "checked"; }  
                          } ?>></td>
                        </tr>
                        <tr>
                          <td>Products</td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProduct" <?php if($serialize_permission) {
                            if(in_array('createProduct', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProduct" <?php if($serialize_permission) {
                            if(in_array('updateProduct', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProduct" <?php if($serialize_permission) {
                            if(in_array('viewProduct', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProduct" <?php if($serialize_permission) {
                            if(in_array('deleteProduct', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                        </tr>
    <tr>
      <td>Purchased</td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="createPurchased" <?php if($serialize_permission && in_array('createPurchased', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="updatePurchased" <?php if($serialize_permission && in_array('updatePurchased', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="viewPurchased" <?php if($serialize_permission && in_array('viewPurchased', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="deletePurchased" <?php if($serialize_permission && in_array('deletePurchased', $serialize_permission)) echo "checked"; ?>></td>
    </tr>
    <tr>
      <td>Sales</td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="createSales" <?php if($serialize_permission && in_array('createSales', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="updateSales" <?php if($serialize_permission && in_array('updateSales', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="viewSales" <?php if($serialize_permission && in_array('viewSales', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="deleteSales" <?php if($serialize_permission && in_array('deleteSales', $serialize_permission)) echo "checked"; ?>></td>
    </tr>
    <tr>
      <td>Returns</td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="createReturns" <?php if($serialize_permission && in_array('createReturns', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="updateReturns" <?php if($serialize_permission && in_array('updateReturns', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="viewReturns" <?php if($serialize_permission && in_array('viewReturns', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="deleteReturns" <?php if($serialize_permission && in_array('deleteReturns', $serialize_permission)) echo "checked"; ?>></td>
    </tr>
    <tr>
      <td>Customers</td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="createCustomers" <?php if($serialize_permission && in_array('createCustomers', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="updateCustomers" <?php if($serialize_permission && in_array('updateCustomers', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="viewCustomers" <?php if($serialize_permission && in_array('viewCustomers', $serialize_permission)) echo "checked"; ?>></td>
      <td><input type="checkbox" name="permission[]" class="minimal" value="deleteCustomers" <?php if($serialize_permission && in_array('deleteCustomers', $serialize_permission)) echo "checked"; ?>></td>
    </tr>
                     

                        <tr>
                          <td>Orders</td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder" <?php if($serialize_permission) {
                            if(in_array('createOrder', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder" <?php if($serialize_permission) {
                            if(in_array('updateOrder', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder" <?php if($serialize_permission) {
                            if(in_array('viewOrder', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder" <?php if($serialize_permission) {
                            if(in_array('deleteOrder', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                        </tr>
                       
                        <tr>
                          <td>Company</td>
                          <td> - </td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCompany" <?php if($serialize_permission) {
                            if(in_array('updateCompany', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td> - </td>
                          <td> - </td>
                        </tr>
                        <tr>
                          <td>Reports</td>
                          <td> - </td>
                          <td> - </td>
                          <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReport" <?php if($serialize_permission) {
                            if(in_array('viewReport', $serialize_permission)) { echo "checked"; } 
                          } ?>></td>
                          <td> - </td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update Permission</button>
                <a href="<?php echo base_url('Controller_Permission') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#mainGroupNav").addClass('active');
    $("#manageGroupNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
  });
</script>
