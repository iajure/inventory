<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Sale</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Sales</li>
    </ol>
  </section>
  <section class="content">
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
        <div class="box">
         <form role="form" action="<?php echo base_url('Controller_Sales/update/'.$sales_data['id']) ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label>Image Preview: </label>
                  <img src="<?php echo base_url() . $sales_data['image'] ?>" width="150" height="150" class="img-circle">
                </div>
                <div class="form-group">
                  <label for="product_image">Update Image</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="product_name">Product name</label>
                  <input type="text" class="form-control" id="product_name" name="name" placeholder="Enter product name" value="<?php echo $sales_data['name']; ?>"  autocomplete="off"/>
                </div>
                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" value="<?php echo $sales_data['qty']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="<?php echo $sales_data['price']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off"><?php echo $sales_data['description']; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="sales_date">Sales Date</label>
                  <input type="date" class="form-control" id="sales_date" name="sales_date" value="<?php echo $sales_data['sales_date']; ?>" autocomplete="off"/>
                </div>

                <!-- Customer Name -->
                <div class="form-group">
                  <label for="customer_name">Customer</label>
                  <select class="form-control select2" id="customer_name" name="customer_name" required>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer): ?>
                      <?php $cust_name = isset($customer['name']) ? $customer['name'] : (isset($customer['customer_name']) ? $customer['customer_name'] : ''); ?>
                      <option value="<?= htmlspecialchars($cust_name) ?>" <?php echo (isset($sales_data['customer_name']) && $sales_data['customer_name'] == $cust_name) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cust_name) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Element Sales as label and value dropdowns -->
                <?php 
                $selected_elementsales = array();
                if (!empty($sales_data['elementsales_value_id'])) {
                  $selected_elementsales = json_decode($sales_data['elementsales_value_id'], true);
                  if (!is_array($selected_elementsales)) $selected_elementsales = array();
                }
                ?>
                <?php if (isset($elementsales) && !empty($elementsales)): ?>
                  <?php foreach ($elementsales as $es): ?>
                    <?php if (isset($es['name']) && !empty($es['values'])): ?>
                    <div class="form-group">
                      <label><?= htmlspecialchars($es['name']) ?></label>
                      <select name="elementsales_value[<?= $es['id'] ?>]" class="form-control">
                        <option value="">Select <?= htmlspecialchars($es['name']) ?> Value</option>
                        <?php foreach ($es['values'] as $val): ?>
                          <option value="<?= htmlspecialchars($val['id']) ?>" <?php echo (in_array($val['id'], $selected_elementsales)) ? 'selected' : '' ?>><?= htmlspecialchars($val['value']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
              <div class="box-footer">
                <?php if (empty($sales_data['is_returned']) || $sales_data['is_returned'] != 1): ?>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                <?php endif; ?>
                <a href="<?php echo base_url('Controller_Sales/') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
        </div>
      </div>
    </div>
  </section>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#description").wysihtml5();
    $("#mainSalesNav").addClass('active');
    $("#manageSalesNav").addClass('active');
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
  // No sync needed, single select2 for customer
  });
</script>
