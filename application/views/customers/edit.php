<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Customer</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Customers</li>
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
         <form role="form" action="<?php echo base_url('Controller_Customers/update/'.$customers_data['id']) ?>" method="post">
              <div class="box-body">
                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="customer_name">Customer Name</label>
                  <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter customer name" value="<?php echo $customers_data['customer_name']; ?>"  autocomplete="off"/>
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="<?php echo $customers_data['phone']; ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" class="form-control" id="date" name="date" value="<?php echo $customers_data['date']; ?>" autocomplete="off"/>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off"><?php echo $customers_data['description']; ?></textarea>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('Controller_Customers/') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
        </div>
      </div>
    </div>
  </section>
</div>
