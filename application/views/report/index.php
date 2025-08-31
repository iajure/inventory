<div class="content-wrapper">
  <section class="content-header">
    <h1>Report</h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Report</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?= number_format(isset($total_sales_value) ? $total_sales_value : 0, 2) ?></h3>
            <p>Total Sales Value</p>
          </div>
          <div class="icon">
            <i class="fa fa-shopping-cart"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?= number_format(isset($total_product_value) ? $total_product_value : 0, 2) ?></h3>
            <p>Total Product Value</p>
          </div>
          <div class="icon">
            <i class="fa fa-cubes"></i>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
