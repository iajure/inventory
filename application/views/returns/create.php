<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <h1>Add New Return Item</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Returns</li>
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
          <form role="form" action="<?php echo base_url('Controller_Returns/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php echo validation_errors(); ?>

              <!-- Use previous icon/image upload style, remove duplicate image input -->
              <div class="form-group">
                <label for="return_image">Image</label>
                <div class="kv-avatar">
                  <div class="file-loading">
                    <input id="return_image" name="return_image" type="file" accept="image/*">
                  </div>
                </div>
                <img id="sales_image_preview" src="" alt="Sales Image Preview" style="max-width:150px; max-height:150px; display:none; margin-top:10px;">
                <input type="hidden" id="sales_image" name="image" />
              </div>

              <div class="form-group">
                <label for="sales_product_select">Select Sold Product</label>
                <select class="form-control select2" id="sales_product_select">
                  <option value="">Select Product</option>
                  <?php foreach ($sales as $sale): ?>
                    <option 
                      value="<?= (int)$sale['id'] ?>"
                      data-name="<?= htmlspecialchars($sale['name']) ?>"
                      data-qty="<?= htmlspecialchars($sale['qty']) ?>"
                      data-price="<?= htmlspecialchars($sale['price']) ?>"
                      data-description="<?= htmlspecialchars(str_replace(array("\r", "\n"), '', $sale['description'])) ?>"
                      data-customer="<?= htmlspecialchars($sale['customer_name']) ?>"
                      data-image="<?= !empty($sale['image']) ? htmlspecialchars($sale['image']) : '' ?>"
                    >
                      <?= htmlspecialchars($sale['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <input type="hidden" id="sales_id" name="sales_id" value="" />
                </select>
              </div>
              <div class="form-group">
                <label for="product_name">Product name</label>
                <input type="text" class="form-control" id="product_name" name="name" placeholder="Enter product name" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="qty">Qty</label>
                <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off" />
              </div>
              <div class="form-group">
                <label for="return_date">Returns Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" value="<?php echo date('Y-m-d'); ?>" required />
              </div>
              <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter customer name" autocomplete="off" required>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Returns/') ?>" class="btn btn-danger">Back</a>
              </div>
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
    $("#mainReturnsNav").addClass('active');
    $("#addReturnsNav").addClass('active');
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#return_image").fileinput({
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
    // Remove any custom JS preview for image below the input

    $('#sales_product_select').select2({placeholder: "Select Product", allowClear: true});
    $('#sales_product_select').on('change', function() {
      var selected = $(this).find(':selected');
      $('#product_name').val(selected.data('name') || '');
      $('#qty').val(selected.data('qty') || '');
      $('#price').val(selected.data('price') || '');
      var desc = selected.data('description');
      if (typeof desc === 'undefined' || desc === null) desc = '';
      desc = String(desc);
      // Remove HTML tags if any
      desc = desc.replace(/<[^>]+>/g, '').replace(/\r|\n/g, ' ').trim();
      $('#description').val(desc);
      $('#customer_name').val(selected.data('customer') || '');
      // Set sales_id hidden input
      $('#sales_id').val(selected.val() || '');
      // Show image from sales if available and set hidden input for backend
      var img = selected.data('image');
      if (img && img !== 'default.jpg') {
        $('#sales_image_preview').attr('src', '<?= base_url("assets/images/sales_image/") ?>' + img).show();
        $('#sales_image').val(img); // Only filename, not path
      } else {
        $('#sales_image_preview').hide();
        $('#sales_image').val('');
      }
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
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
