<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<div class="content-wrapper">
  <section class="content-header">
    <h1>Add New Sales Item</h1>
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
          <form role="form" action="<?php echo base_url('Controller_Sales/create') ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php echo validation_errors(); ?>

              <!-- Move image preview to top -->
              <div class="form-group">
                <label for="sales_image">Image</label>
                <img id="sales_image_preview" src="" alt="Product Image" style="max-width:150px; max-height:150px; display:none;">
                <input type="hidden" id="sales_image" name="image" />
              </div>

              <!-- Product Dropdown -->
              <div class="form-group">
                <label for="product_select">Product Name</label>
                <select id="product_select" name="product_id" class="form-control">
                  <option value="">Select Product</option>
                  <?php foreach ($products as $product): ?>
                    <option value="<?= $product['id'] ?>"
                      data-name="<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>"
                      data-qty="<?= isset($product['qty']) ? htmlspecialchars($product['qty'], ENT_QUOTES) : '' ?>"
                      data-price="<?= isset($product['price']) ? htmlspecialchars($product['price'], ENT_QUOTES) : '' ?>"
                      data-description="<?= isset($product['description']) ? htmlspecialchars($product['description'], ENT_QUOTES) : '' ?>"
                      data-image="<?= !empty($product['image']) ? htmlspecialchars($product['image'], ENT_QUOTES) : 'default.jpg' ?>"
                      data-elements='<?= json_encode($product['element_names']) ?>'
                      data-values='<?= json_encode($product['element_values']) ?>'>
                      <?= htmlspecialchars($product['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Element Sales as label and value dropdowns -->
              <?php if (isset($elementsales) && !empty($elementsales)): ?>
                <?php foreach ($elementsales as $es): ?>
                  <?php if (isset($es['name']) && !empty($es['values'])): ?>
                  <div class="form-group">
                    <label><?= htmlspecialchars($es['name']) ?></label>
                    <select name="elementsales_value[<?= $es['id'] ?>]" class="form-control">
                      <option value="">Select <?= htmlspecialchars($es['name']) ?> Value</option>
                      <?php foreach ($es['values'] as $val): ?>
                        <option value="<?= htmlspecialchars($val['id']) ?>"><?= htmlspecialchars($val['value']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>


              <div id="elements_group">
                <!-- JS will fill with labels and dropdowns for each element, or show message if none -->
              </div>

              <!-- Elements Dropdown (Attributes only, partitioned by attribute name) -->

              <!-- Partitioned input values for selected elements -->
              <div id="selected-elements" style="margin-bottom:15px;">
                <!-- JS will fill this -->
              </div>

              <!-- Auto-filled fields -->
              <div class="form-group">
                <label for="sales_product_name">Product Name</label>
                <input type="text" class="form-control" id="sales_product_name" name="name" placeholder="Product Name" required />
              </div>
              <div class="form-group">
                <label for="sales_qty">Quantity</label>
                <input type="text" class="form-control" id="sales_qty" name="qty" placeholder="Quantity" />
              </div>
              <div class="form-group">
                <label for="sales_price">Price</label>
                <input type="text" class="form-control" id="sales_price" name="price" placeholder="Price" />
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" value="<?php echo isset($default_description) ? htmlspecialchars($default_description) : '' ?>" />
              </div>
              <div class="form-group">
                <label for="sales_date">Sales Date</label>
                <input type="date" class="form-control" id="sales_date" name="sales_date" value="<?php echo date('Y-m-d'); ?>" />
              </div>
              <div class="form-group">
                <label for="customer_name">Customer</label>
                <select class="form-control select2" id="customer_name" name="customer_name" required>
                  <option value="">Select Customer</option>
                  <?php foreach ($customers as $customer): ?>
                    <option value="<?= isset($customer['name']) ? htmlspecialchars($customer['name']) : (isset($customer['customer_name']) ? htmlspecialchars($customer['customer_name']) : '') ?>">
                      <?= isset($customer['name']) ? htmlspecialchars($customer['name']) : (isset($customer['customer_name']) ? htmlspecialchars($customer['customer_name']) : 'Unknown'); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Sales/') ?>" class="btn btn-danger">Back</a>
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
    $("#mainSalesNav").addClass('active');
    $("#addSalesNav").addClass('active');
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

    $("#product_select").change(function() {
      var selected = $(this).find(':selected');
      $("#sales_product_name").val(selected.data('name') || '');
      $("#sales_qty").val(selected.data('qty'));
      $("#sales_price").val(selected.data('price'));
  var desc = selected.data('description');
  console.log('Selected product id:', selected.val(), 'data-description:', desc);
  desc = (desc !== undefined && desc !== null) ? String(desc) : '';
  desc = desc.replace(/<p[^>]*>/gi, '').replace(/<\/p>/gi, '').replace(/<br\s*\/?/gi, '');
  $j("#description").val(desc).prop('readonly', false); // always allow typing
  console.log('Set #description value to:', desc);

      var img = selected.data('image');
      if (img && img !== '' && img !== 'default.jpg') {
        $("#sales_image_preview")
          .attr('src', '<?= base_url("assets/images/product_image/") ?>' + img)
          .show();
        $("#sales_image").val(img);
      } else {
        $("#sales_image_preview").hide();
        $("#sales_image").val('');
      }

      // Fill elements dropdown (attributes only, partitioned)
      var attributes = selected.data('attributes');
      if (attributes) {
        try {
          var attrArr = JSON.parse(attributes);
          // Set selected values in the partitioned dropdown
          $("#attributes_value_id").val(attrArr).trigger('change');
        } catch(e) {
          $("#attributes_value_id").val([]).trigger('change');
        }
      } else {
        $("#attributes_value_id").val([]).trigger('change');
      }
      showSelectedElements();
    });

    $(".select_group").select2();

    function showSelectedElements() {
      var selectedText = [];
      $("#attributes_value_id option:selected").each(function() {
        var group = $(this).closest('optgroup').attr('label');
        selectedText.push('<div><strong>' + group + ':</strong> ' + $(this).text() + '</div>');
      });
  $("#selected-elements").html(selectedText.length ? selectedText.join('') : '');
    }

    $("#attributes_value_id").on('change', function() {
      showSelectedElements();
    });

    // Initial call to show selected elements if any
    showSelectedElements();
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
</script>
<script>
$(document).ready(function() {
  $("#product_select").change(function() {
    var selected = $(this).find(':selected');
    var values = selected.data('values');
    $("#elements_group").empty();

    // Only show elements input if there are actual values (not names)
    var hasValues = false;
    if (values && typeof values === 'object') {
      Object.keys(values).forEach(function(elName) {
        // Filter out any value that matches the element name or is empty
        var filtered = (Array.isArray(values[elName]) ? values[elName].filter(function(val) {
          return val && val !== elName;
        }) : []);
        if (filtered.length > 0) {
          hasValues = true;
        }
      });
    }

    if (hasValues) {
      // Show each element name as label and its values in dropdown, only if values are valid
      Object.keys(values).forEach(function(elName) {
        var filtered = (Array.isArray(values[elName]) ? values[elName].filter(function(val) {
          return val && val !== elName;
        }) : []);
        if (filtered.length > 0) {
          var group = $('<div class="form-group"></div>');
          group.append('<label>' + elName + '</label>');
          var select = $('<select class="form-control" name="elements_dropdown[' + elName + '][]" multiple="multiple"></select>');
          filtered.forEach(function(val) {
            select.append('<option value="' + val + '">' + val + '</option>');
          });
          group.append(select);
          $("#elements_group").append(group);
        }
      });
  }
  });

  // Trigger change on page load if a product is pre-selected
  if($("#product_select").val()) {
    $("#product_select").trigger('change');
  }
});
</script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
  $('#customer_name').select2({placeholder: "Select Customer", allowClear: true});
});
</script>
