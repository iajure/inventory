<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Return</h1>
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
         <form role="form" action="<?php echo base_url('Controller_Returns/update/'.$returns_data['id']) ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <?php echo validation_errors(); ?>
                <?php
                  $img = !empty($returns_data['image']) ? $returns_data['image'] : 'default.jpg';
                  $img_url = (strpos($img, 'assets/images/returns_image/') === false) ? base_url('assets/images/returns_image/' . $img) : base_url($img);
                ?>
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
                  <input type="text" class="form-control" id="product_name" name="name" placeholder="Enter product name" value="<?php echo $returns_data['name']; ?>"  autocomplete="off"/>
                </div>
                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" value="<?php echo $returns_data['qty']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="<?php echo $returns_data['price']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off" value="<?php echo htmlspecialchars($returns_data['description']); ?>" />
                </div>
                <div class="form-group">
                  <label for="customer_name">Customer Name</label>
                  <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter customer name" autocomplete="off" value="<?php echo htmlspecialchars($returns_data['customer_name']); ?>" />
                </div>
                <div class="form-group">
                  <label for="return_date">Returns Date</label>
                  <input type="date" class="form-control" id="return_date" name="return_date" value="<?php echo htmlspecialchars($returns_data['return_date']); ?>" autocomplete="off"/>
                </div>
              </div>
              <div class="box-footer">
                <!-- Save Changes button removed for details-only view -->
                <a href="<?php echo base_url('Controller_Returns/') ?>" class="btn btn-danger">Back</a>
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
    $("#manageReturnsNav").addClass('active');
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>';
    var initialPreview = [
      '<img src="<?php echo $img_url; ?>" class="file-preview-image kv-preview-data" style="width:150px;height:150px;">'
    ];
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
        allowedFileExtensions: ["jpg", "png", "gif"],
        initialPreview: initialPreview,
        initialPreviewAsData: false,
        initialPreviewFileType: 'image',
        initialPreviewConfig: [
          {caption: '<?php echo basename($img); ?>', width: '120px', key: 1}
        ]
    });
  });
</script>
