<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Edit Purchase

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Purchase</li>
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
         <form role="form" action="<?php echo base_url('Controller_Purchased/update/'.$purchased_data['id']) ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>


                <!-- Image upload at the top -->
                <div class="form-group">
                  <label for="product_image">Image</label>
                  <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" />
                </div>

                <div class="form-group">
                  <label for="product_name">Product name</label>
                  <input type="text" class="form-control" id="product_name" name="name" placeholder="Enter product name" value="<?php echo $purchased_data['name']; ?>"  autocomplete="off"/>
                </div>

                <div class="form-group">
                  <label for="qty">Qty</label>
                  <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty" value="<?php echo $purchased_data['qty']; ?>" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off"><?php echo $purchased_data['description']; ?></textarea>
                </div>

                <div class="form-group">
                  <label for="purchase_date">Purchase Date</label>
                  <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="<?php echo $purchased_data['purchase_date']; ?>" autocomplete="off"/>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
          <!-- Save Changes button removed for in-store items -->
                <a href="<?php echo base_url('Controller_Purchased/') ?>" class="btn btn-danger">Back</a>
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
  $("#description").wysihtml5();
  $("#mainPurchasedNav").addClass('active');
  $("#managePurchasedNav").addClass('active');


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
});

</script>