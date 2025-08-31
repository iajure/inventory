<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <?php if(in_array('createSalary', $user_permission) || in_array('updateSalary', $user_permission) || in_array('viewSalary', $user_permission) || in_array('deleteSalary', $user_permission)): ?>
        <li id="mainSalaryNav">
          <a href="<?php echo base_url('Controller_Salary') ?>">
            <i class="fa fa-money"></i> <span>Salary</span>
          </a>
        </li>
        <?php endif; ?>

        

        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>


          <?php if(in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
          <li id="attributeNav">
            <a href="<?php echo base_url('Controller_Element/') ?>">
              <i class="fa fa-files-o"></i> <span>Elements</span>
            </a>
          </li>
          <?php endif; ?>

          <?php if (!isset($page_title)) $page_title = '';
          if(in_array('createAttributeSales', $user_permission) || in_array('updateAttributeSales', $user_permission) || in_array('viewAttributeSales', $user_permission) || in_array('deleteAttributeSales', $user_permission)): ?>
          <li id="attributeSalesNav">
            <a href="<?php echo base_url('Controller_Elementsales/') ?>" class="<?php if($page_title == 'Element Sales'){echo 'active';} ?>">
              <i class="fa fa-files-o"></i> <span>Element Sales</span>
            </a>
          </li>
          <?php endif; ?>

<?php if(in_array('createPurchased', $user_permission) || in_array('updatePurchased', $user_permission) || in_array('viewPurchased', $user_permission) || in_array('deletePurchased', $user_permission)): ?>
  <li class="treeview" id="mainPurchasedNav">
    <a href="#">
      <i class="fa fa-shopping-cart"></i>
      <span>Purchased</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <?php if(in_array('createPurchased', $user_permission)): ?>
        <li id="addPurchasedNav"><a href="<?php echo base_url('Controller_Purchased/create') ?>"><i class="fa fa-circle-o"></i> Add Purchased</a></li>
      <?php endif; ?>
      <?php if(in_array('updatePurchased', $user_permission) || in_array('viewPurchased', $user_permission) || in_array('deletePurchased', $user_permission)): ?>
        <li id="managePurchasedNav"><a href="<?php echo base_url('Controller_Purchased') ?>"><i class="fa fa-circle-o"></i> Manage Purchased</a></li>
      <?php endif; ?>
    </ul>
  </li>
<?php endif; ?>

<?php if(in_array('createSales', $user_permission) || in_array('updateSales', $user_permission) || in_array('viewSales', $user_permission) || in_array('deleteSales', $user_permission)): ?>
  <li class="treeview" id="mainSalesNav">
    <a href="#">
      <i class="fa fa-credit-card"></i>
      <span>Sales</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <?php if(in_array('createSales', $user_permission)): ?>
        <li id="addSalesNav"><a href="<?php echo base_url('Controller_Sales/create') ?>"><i class="fa fa-circle-o"></i> Add Sale</a></li>
      <?php endif; ?>
      <?php if(in_array('updateSales', $user_permission) || in_array('viewSales', $user_permission) || in_array('deleteSales', $user_permission)): ?>
        <li id="manageSalesNav"><a href="<?php echo base_url('Controller_Sales') ?>"><i class="fa fa-circle-o"></i> Manage Sales</a></li>
      <?php endif; ?>
    </ul>
  </li>
<?php endif; ?>
<?php if(isset($user_permission) && in_array('viewReport', $user_permission)): ?>
  <li id="reportNav">
    <a href="<?php echo base_url('Controller_Report') ?>">
      <i class="fa fa-bar-chart"></i> <span>Report</span>
    </a>
  </li>
<?php endif; ?>
<?php if(isset($user_permission) && in_array('viewPermission', $user_permission)): ?>
  <li id="permissionNav">
    <a href="<?php echo base_url('Controller_Permission') ?>">
      <i class="fa fa-lock"></i> <span>Permission</span>
    </a>
  </li>
<?php endif; ?>


        <?php if(in_array('createReturns', $user_permission) || in_array('updateReturns', $user_permission) || in_array('viewReturns', $user_permission) || in_array('deleteReturns', $user_permission)): ?>
          <li class="treeview" id="mainReturnsNav">
            <a href="#">
              <i class="fa fa-undo"></i>
              <span>Returns</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createReturns', $user_permission)): ?>
                <li id="addReturnsNav"><a href="<?php echo base_url('Controller_Returns/create') ?>"><i class="fa fa-circle-o"></i> Add Return</a></li>
              <?php endif; ?>
              <?php if(in_array('updateReturns', $user_permission) || in_array('viewReturns', $user_permission) || in_array('deleteReturns', $user_permission)): ?>
                <li id="manageReturnsNav"><a href="<?php echo base_url('Controller_Returns') ?>"><i class="fa fa-circle-o"></i> Manage Returns</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if(in_array('createCustomers', $user_permission) || in_array('updateCustomers', $user_permission) || in_array('viewCustomers', $user_permission) || in_array('deleteCustomers', $user_permission)): ?>
          <li class="treeview" id="mainCustomersNav">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Customers</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createCustomers', $user_permission)): ?>
                <li id="addCustomersNav"><a href="<?php echo base_url('Controller_Customers/create') ?>"><i class="fa fa-circle-o"></i> Add Customer</a></li>
              <?php endif; ?>
              <?php if(in_array('updateCustomers', $user_permission) || in_array('viewCustomers', $user_permission) || in_array('deleteCustomers', $user_permission)): ?>
                <li id="manageCustomersNav"><a href="<?php echo base_url('Controller_Customers') ?>"><i class="fa fa-circle-o"></i> Manage Customers</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>


          <?php if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
            <li class="treeview" id="mainProductNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Products</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createProduct', $user_permission)): ?>
                  <li id="addProductNav"><a href="<?php echo base_url('Controller_Products/create') ?>"><i class="fa fa-circle-o"></i> Add Product</a></li>
                <?php endif; ?>
                <?php if(in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                <li id="manageProductNav"><a href="<?php echo base_url('Controller_Products') ?>"><i class="fa fa-circle-o"></i> Manage Products</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>


          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li class="treeview" id="mainOrdersNav">
              <a href="#">
                <i class="fa fa-dollar"></i>
                <span>Orders</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createOrder', $user_permission)): ?>
                  <li id="addOrderNav"><a href="<?php echo base_url('Controller_Orders/create') ?>"><i class="fa fa-circle-o"></i> Add Order</a></li>
                <?php endif; ?>
                <?php if(in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
                <li id="manageOrdersNav"><a href="<?php echo base_url('Controller_Orders') ?>"><i class="fa fa-circle-o"></i> Manage Orders</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
          <?php if($user_permission): ?>
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Members</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserNav"><a href="<?php echo base_url('Controller_Members/create') ?>"><i class="fa fa-circle-o"></i> Add Members</a></li>
              <?php endif; ?>

              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserNav"><a href="<?php echo base_url('Controller_Members') ?>"><i class="fa fa-circle-o"></i> Manage Members</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-recycle"></i>
                <span>Permission</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('Controller_Permission/create') ?>"><i class="fa fa-circle-o"></i> Add Permission</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('Controller_Permission') ?>"><i class="fa fa-circle-o"></i> Manage Permission</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

         <!--  <?php if(in_array('viewReports', $user_permission)): ?>
            <li id="reportNav">
              <a href="<?php echo base_url('reports/') ?>">
                <i class="glyphicon glyphicon-stats"></i> <span>Reports</span>
              </a>
            </li>
          <?php endif; ?> -->


          <?php if(in_array('updateCompany', $user_permission)): ?>
            <li id="companyNav"><a href="<?php echo base_url('Controller_Company/') ?>"><i class="fa fa-bank"></i> <span>Company</span></a></li>
          <?php endif; ?>

        <?php endif; ?>
        <!-- user permission info -->

          <li id="settingsNav">
            <a href="<?php echo base_url('Controller_Settings') ?>">
              <i class="fa fa-cog"></i> <span>Settings</span>
            </a>
          </li>

          <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

<?php
  // Detect current controller for sidebar active state
  $CI =& get_instance();
  $current_controller = strtolower($CI->router->fetch_class());
  $current_method = strtolower($CI->router->fetch_method());
?>

<script type="text/javascript">
(function(){
  var controller = "<?= htmlspecialchars($current_controller, ENT_QUOTES) ?>";
  var method = "<?= htmlspecialchars($current_method, ENT_QUOTES) ?>";
  var map = {
    'controller_products': 'mainProductNav',
    'controller_sales': 'mainSalesNav',
    'controller_returns': 'mainReturnsNav',
    'controller_purchased': 'mainPurchasedNav',
    'controller_customers': 'mainCustomersNav',
    'controller_items': 'brandNav',
    'controller_category': 'categoryNav',
    'controller_warehouse': 'storeNav',
    'controller_element': 'attributeNav',
    'controller_permission': 'permissionNav',
    'controller_report': 'reportNav',
    'controller_members': 'mainUserNav',
    'controller_orders': 'mainOrdersNav',
    'controller_company': 'companyNav'
  ,'controller_salary': 'mainSalaryNav'
  };

  var id = map[controller] || null;
  if (!id) {
    var ctrlShort = controller.replace(/^controller_/, '');
    for (var key in map) {
      if (key.replace(/^controller_/, '') === ctrlShort) {
        id = map[key];
        break;
      }
    }
  }

  if (id) {
    var el = document.getElementById(id);
    if (el) {
      el.classList.add('active');
      // If treeview, open and mark child
      if (el.classList.contains('treeview')) {
        var childId = null;
        if (method === 'create' || method === 'add') {
          childId = el.querySelector('[id^="add"]');
        } else {
          childId = el.querySelector('[id^="manage"]');
        }
        if (childId) {
          childId.classList.add('active');
        }
      }
    }
  }
})();
</script>