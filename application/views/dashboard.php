

          <!-- ./col -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
    
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
  <?php // Removed admin check to make dashboard visible to all users ?>

        <div class="row">
          <!-- Removed Total Items and Total Category boxes -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3><?php $query = $this->db->query("SELECT COUNT(*) as total FROM products WHERE availability = 1"); echo $query->row()->total; ?></h3>
                <h4><b>Active Products</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-check-circle"></i>
              </div>
              <a href="<?php echo base_url('Controller_Products/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php 
                  $today = date('Y-m-d');
                  $query = $this->db->query("SELECT COUNT(*) as total FROM sales WHERE DATE(sales_date) = '$today'");
                  echo $query->row()->total;
                ?></h3>
                <h4><b>Daily Sales</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-calendar-check-o"></i>
              </div>
              <a href="<?php echo base_url('Controller_Sales/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3>
                  <?php 
                    $query = $this->db->query("SELECT SUM(price) as total FROM products WHERE availability = 1");
                    echo number_format(floatval($query->row()->total), 2);
                  ?>
                </h3>
                <h4><b>Store Value</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
              <a href="<?php echo base_url('Controller_Products/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3>
                  <?php 
                    $query = $this->db->query("SELECT COUNT(*) as total FROM products WHERE returned = 1 AND availability = 1");
                    echo $query->row()->total;
                  ?>
                </h3>
                <h4><b>Returned Items</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-undo"></i>
              </div>
              <a href="<?php echo base_url('Controller_Products/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3>
                  <?php 
                    $query = $this->db->query("SELECT COUNT(*) as total FROM customers");
                    echo $query->row()->total;
                  ?>
                </h3>
                <h4><b>Customers</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
              <a href="<?php echo base_url('Controller_Customers/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
                    <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3>
                  <?php
                    $first_element = $this->db->query("SELECT id FROM attributes ORDER BY id ASC LIMIT 1")->row();
                    $count = 0;
                    if ($first_element) {
                      $element_id = $first_element->id;
                      $query = $this->db->query("SELECT COUNT(*) as total FROM attribute_value WHERE attribute_parent_id = $element_id");
                      $count = $query->row()->total;
                    }
                    echo $count;
                  ?>
                </h3>
                <h4><b>Warehouse</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-list-ol"></i>
              </div>
              <a href="<?php echo base_url('Controller_Element/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-pink">
              <div class="inner">
                <h3>
                  <?php
                    $first_elementsales = $this->db->query("SELECT attribute_parent_id FROM elementsales_value ORDER BY attribute_parent_id ASC LIMIT 1")->row();
                    $count = 0;
                    if ($first_elementsales) {
                      $parrent_id = $first_elementsales->attribute_parent_id;
                      $query = $this->db->query("SELECT COUNT(*) as total FROM elementsales_value WHERE attribute_parent_id = $parrent_id");
                      $count = $query->row()->total;
                    }
                    echo $count;
                  ?>
                </h3>
                <h4><b>Unpaid Items</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-list"></i>
              </div>
              <a href="<?php echo base_url('Controller_Elementsales/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?php $query = $this->db->query('SELECT SUM( net_amount)as total FROM orders WHERE paid_status = 1')->row(); echo floatval($query->total);?></h3>
                <h4><b>Total Sales</b></h4>
              </div>
              <div class="icon">
                <i class="fa fa-dollar"></i>
              </div>
              <a href="<?php echo base_url('Controller_Orders/') ?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>



        <!-- /.row -->

        <!-- Recent Orders Section -->
        <div class="row" style="margin-top: 32px;">
          <div class="col-lg-4 col-md-6 col-xs-12">
            <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(45,124,255,0.06); padding: 24px 18px 18px 18px; margin-bottom: 24px;">
                    <h3 style="font-size: 20px; font-weight: 700; color: #222; margin-bottom: 18px;">Top Selling Products</h3>
                    <div style="max-height: 320px; overflow-y: auto;">
                      <table class="table table-borderless" style="margin-bottom: 0;">
                        <thead>
                          <tr style="color: #888; font-size: 15px;">
                            <th>Product</th>
                            <th>Customers</th>
                            <th>Sold</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = $this->db->query('
                          SELECT name, GROUP_CONCAT(DISTINCT customer_name SEPARATOR ", ") as customers, SUM(qty) as total_sold
                          FROM sales
                          WHERE is_returned = 0
                          GROUP BY name
                          ORDER BY total_sold DESC
                          LIMIT 10
                        ');
                        foreach($query->result() as $row): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($row->name); ?></td>
                            <td><span class="label label-info"><?php echo htmlspecialchars($row->customers); ?></span></td>
                            <td><span class="label label-primary"><?php echo $row->total_sold; ?></span></td>
                          </tr>
                        <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    <a href="<?php echo base_url('Controller_Sales/'); ?>" class="small-box-footer" style="display:block; text-align:right; margin-top:8px; color:#2d7cff; font-weight:500;">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-xs-12">
            <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(45,124,255,0.06); padding: 24px 18px 18px 18px; margin-bottom: 24px;">
              <h3 style="font-size: 20px; font-weight: 700; color: #222; margin-bottom: 18px;">Low Stock Items</h3>
              <div style="max-height: 320px; overflow-y: auto;">
                <table class="table table-borderless" style="margin-bottom: 0;">
                  <thead>
                    <tr style="color: #888; font-size: 15px;">
                      <th>Product</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $query = $this->db->query('SELECT name, qty FROM products WHERE qty < 10 AND availability = 1 ORDER BY qty ASC LIMIT 10');
                  foreach($query->result() as $row): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row->name); ?></td>
                      <td><span class="label label-danger"><?php echo $row->qty; ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <a href="<?php echo base_url('Controller_Products/'); ?>" class="small-box-footer" style="display:block; text-align:right; margin-top:8px; color:#2d7cff; font-weight:500;">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 col-xs-12">
            <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(45,124,255,0.06); padding: 24px 18px 18px 18px; margin-bottom: 24px;">
              <h3 style="font-size: 20px; font-weight: 700; color: #222; margin-bottom: 18px;">Latest Sale</h3>
              <div style="max-height: 320px; overflow-y: auto;">
                <table class="table table-borderless" style="margin-bottom: 0;">
                  <thead>
                    <tr style="color: #888; font-size: 15px;">
                      <th>Product</th>
                      <th>Customer</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  // Show the latest 10 sales with is_returned = 0
                  $query = $this->db->query("SELECT name, customer_name, qty FROM sales WHERE is_returned = 0 ORDER BY id DESC LIMIT 10");
                  foreach($query->result() as $row): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row->name); ?></td>
                      <td><?php echo htmlspecialchars($row->customer_name); ?></td>
                      <td><span class=\"label label-warning\"><?php echo $row->qty; ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <a href="<?php echo base_url('Controller_Sales/'); ?>" class="small-box-footer" style="display:block; text-align:right; margin-top:8px; color:#2d7cff; font-weight:500;">More Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#dashboardMainMenu").addClass('active');
    }); 
  </script>
