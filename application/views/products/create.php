<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>var $j = jQuery.noConflict(true);</script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">




<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add New Products
      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Products</li>
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


        <div class="box">
         

          <!-- /.box-header -->
          <form role="form" action="<?= base_url('Controller_Products/create') ?>" method="post" enctype="multipart/form-data" id="product_form">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label>Data Entry Mode</label><br>
                  <label class="radio-inline">
                    <input type="radio" name="entry_mode" id="entry_manual" value="manual" checked> Manual
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="entry_mode" id="entry_purchased" value="purchased"> From Purchased
                  </label>
                </div>

                <div class="form-group" id="purchased_select_group" style="display:none;">
                  <label for="purchased_select">Select Purchased Item</label>
                  <select id="purchased_select" name="purchased_id" class="form-control">
    <option value="">Select</option>
    <?php foreach ($purchased_items as $item): ?>
      <option value="<?= $item['id'] ?>"
        data-name="<?= htmlspecialchars($item['name']) ?>"
        data-qty="<?= $item['qty'] ?>"
        data-description="<?= htmlspecialchars($item['description']) ?>"
        data-image="<?= $item['image'] ?>">
        <?= htmlspecialchars($item['name']) ?>
      </option>
    <?php endforeach; ?>
  </select>
                </div>

                <div class="form-group">
                  <label for="product_image">Image</label>
                  <div class="kv-avatar">
                      <div class="file-loading">
                          <input id="product_image" name="product_image" type="file">
                      </div>
                  </div>
                  <!-- Remove any extra <img> preview below, keep only this one -->
                  <img id="purchased_image_preview" src="" alt="Image Preview" style="max-width:150px; max-height:150px; display:none; margin-top:10px;">
                  <input type="hidden" id="purchased_image" name="purchased_image" />
                </div>

                <div class="form-group">
                  <label for="product_name">Product name</label>
                  <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" autocomplete="off" />
                </div>
                  <div class="form-group">
                    <label for="entry_price">Entry Price</label>
                    <input type="text" class="form-control" id="entry_price" name="entry_price" placeholder="Enter entry price" autocomplete="off" />
                  </div>

                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" autocomplete="off" />
                </div>

                <!-- Remove old textarea for description and add new input -->
                <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" />
                </div>

                <?php if($attributes): ?>
                  <?php foreach ($attributes as $k => $v): ?>
                    <div class="form-group">
                      <label for="groups"><?php echo $v['attribute_data']['name'] ?></label>
                      <select class="form-control select_group" id="attributes_value_id" name="attributes_value_id[]" multiple="multiple">
                        <?php foreach ($v['attribute_value'] as $k2 => $v2): ?>
                          <option value="<?php echo $v2['id'] ?>"><?php echo $v2['value'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>    
                  <?php endforeach ?>
                <?php endif; ?>


                <div class="form-group">
                  <label for="store">Availability</label>
                  <select class="form-control" id="availability" name="availability">
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="product_date">Product Date</label>
                  <input type="date" class="form-control" id="product_date" name="product_date" value="<?php echo date('Y-m-d'); ?>" />
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Products/') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
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
    $(".select_group").select2();
  // $("#description").wysihtml5(); // Disabled to allow manual typing
    $("#mainProductNav").addClass('active');
    $("#addProductNav").addClass('active');
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

    // Data entry mode logic
    $("input[name='entry_mode']").change(function() {
      if($(this).val() === 'purchased') {
        $("#purchased_select_group").show();
        var selected = $j("#purchased_select option:selected");
        $j("#product_name").val(selected.data('name') || '');
        $j("#qty").val(selected.data('qty'));
        // Remove <p> and <br> tags from description
        var desc = selected.data('description') || '';
        desc = desc.replace(/<p[^>]*>/gi, '').replace(/<\/p>/gi, '').replace(/<br\s*\/?>/gi, '');
  $j("#description").val(desc);
  $j("#description").prop('readonly', false); // Always allow typing
        $j("#image").val(selected.data('image'));
      } else {
        $("#purchased_select_group").hide();
        // Clear fields
        $j("#product_name").val("");
        $j("#qty").val("");
  $j("#description").val("");
  $j("#description").prop('readonly', false); // Always allow typing
        $j("#image").val("");
        $("#purchased_image_preview").hide().attr('src', '');
      }
    });

    // Dropdown logic
    $("#purchased_select").change(function() {
      var selected = $(this).find(':selected');
      $("#product_name").val(selected.data('name') || '');
      $("#qty").val(selected.data('qty'));
      // Remove <p> and <br> tags from description
      var desc = selected.data('description') || '';
      desc = desc.replace(/<p[^>]*>/gi, '').replace(/<\/p>/gi, '').replace(/<br\s*\/?>/gi, '');
  $("#description").val(desc);
  $("#description").prop('readonly', false); // Always allow typing
      $("#image").val(selected.data('image'));

      if (selected.data('image')) {
        $("#purchased_image_preview")
          .attr('src', '<?= base_url("assets/images/purchased_image/") ?>' + selected.data('image'))
          .show();
        $("#purchased_image").val(selected.data('image'));
      } else {
        $("#purchased_image_preview").hide();
        $("#purchased_image").val('');
      }
    });

    // When the form is submitted
    $j("#product_form").submit(function(e) {
      if ($j("input[name='entry_mode']:checked").val() === 'purchased') {
        var selected = $j("#purchased_select option:selected");
        $j("#product_name").val(selected.data('name') || '');
        var price = $j('#price').val();
        if (!price) {
          $j('#price').focus();
          $j('#messages').html('<div class="alert alert-danger alert-dismissible" role="alert"'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong>Price is required.</strong>'+
          '</div>');
          e.preventDefault();
          return false;
        }
        var purchased_id = $j("#purchased_select").val();
        e.preventDefault();
        $j.ajax({
          url: '<?= base_url("Controller_Products/removeFromPurchased") ?>',
          type: 'POST',
          data: { purchased_id: purchased_id },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              $j("#purchased_select option[value='" + purchased_id + "']").remove();
              document.getElementById('product_form').submit();
            }
          }
        });
        return false;
      }
      // For manual entry, allow normal submit
      return true;
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