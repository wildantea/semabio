   <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=base_url();?>upload/back_profil_foto/<?=$db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->foto_user?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?=ucwords($db->fetch_single_row('sys_users','id',$_SESSION['id_user'])->username)?></p>

              <a href="<?=base_index();?>profil"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
         <!--  search form
         <form action="#" method="get" class="sidebar-form">
           <div class="input-group">
             <input type="text" name="q" class="form-control" placeholder="Search..."/>
             <span class="input-group-btn">
               <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
             </span>
           </div>
         </form>
         /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
             <li class="<?=(uri_segment(1)=='')?'active':'';?>">
                            <a href="<?=base_index();?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
              <?php
              //show only if user is admin
              if ($_SESSION['group_level']=='root') {
                ?>

              <li class="treeview <?=(uri_segment(1)=='install'||uri_segment(1)=='user-managements'||uri_segment(1)=='page'||uri_segment(1)=='group-permission'||uri_segment(1)=='user-group'||uri_segment(1)=='page-service'||uri_segment(1)=='service-permission' || uri_segment(1)=='excel-generator')?'active':'';?>">
                        <a href="#">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>System Setting</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">

                         <li class="<?=(uri_segment(1)=='page')?'active':'';?>">
                            <a href="<?=base_index();?>page">
                                <i class="fa fa-circle-o"></i> <span>Page / Menu</span>
                            </a>
                        </li>
                        <li class="<?=(uri_segment(1)=='user-group')?'active':'';?>">
                            <a href="<?=base_index();?>user-group">
                                <i class="fa fa-circle-o"></i> <span>User Group</span>
                            </a>
                        </li>
                          <li class="<?=(uri_segment(1)=='user-managements')?'active':'';?>">
                            <a href="<?=base_index();?>user-managements">
                                <i class="fa fa-circle-o"></i> <span>User Management</span>
                            </a>
                        </li>
                              <li class="<?=(uri_segment(1)=='group-permission')?'active':'';?>">
                            <a href="<?=base_index();?>group-permission">
                                <i class="fa fa-circle-o"></i> <span>Group User Permission</span>
                            </a>
                        </li>
<li class="<?=(uri_segment(1)=='excel-generator')?'active':'';?>">
                            <a href="<?=base_index();?>excel-generator">
                                <i class="fa fa-circle-o"></i> <span>Excel Generator</span>
                            </a>
                        </li>
                        <li class="<?=(uri_segment(1)=='page-service')?'active':'';?>">
                            <a href="<?=base_index();?>page-service">
                                <i class="fa fa-circle-o"></i> <span>Web Service</span>
                            </a>
                        </li>
                        <li class="<?=(uri_segment(1)=='service-permission')?'active':'';?>">
                            <a href="<?=base_index();?>service-permission">
                                <i class="fa fa-circle-o"></i> <span>Web Service Permission</span>
                            </a>
                        </li>

                        </ul>
                        </li>


<?php

                  }
// Select all entries from the menu table
$result=$db->query("select sys_menu.*,sys_menu_role.read_act,sys_menu_role.insert_act,sys_menu_role.update_act,sys_menu_role.delete_act,sys_menu_role.group_level from sys_menu
left join sys_menu_role on sys_menu.id=sys_menu_role.id_menu
where sys_menu_role.group_level=? and sys_menu_role.read_act=? and tampil=? ORDER BY parent, urutan_menu",array('sys_menu_role.group_level'=>$_SESSION['group_level'],'sys_menu_role.read_act'=>'Y','tampil'=>'Y'));


// Create a multidimensional array to list items and parents
$menu = array(
    'items' => array(),
    'parents' => array()
);
// Builds the array lists with data from the menu table
foreach ($result as $items) {

  $items = $db->convert_obj_to_array($items);

      // Creates entry into items array with current menu item id ie.
    $menu['items'][$items['id']] = $items;
    // Creates entry into parents array. Parents array contains a list of all items with children
    $menu['parents'][$items['parent']][] = $items['id'];
}


echo $db->buildMenu(uri_segment(1),0, $menu);
if (isset($_SESSION['login_as'])) {
  ?>
               <li>
                            <a href="<?=base_admin();?>inc/login_back.php?id=<?=$_SESSION['admin_id'];?>">
                                <i class="fa fa-user"></i> <span>Login Back</span>
                            </a>
                        </li>

<?php
}
?>
           </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
<?php
if ($_SESSION['group_level']=='presenters') {
  ?>
<div style="padding: 20px 30px; background: rgb(243, 156, 18); z-index: 999999; font-size: 16px; font-weight: 600;">
  <a style="color: rgba(255, 255, 255, 0.9); font-size: 16px; display: inline-block; margin-right: 10px; text-decoration: none;" href="<?=base_index();?>submission">Info : We are resetting our paper upload system. So Please re-upload your Paper.</a>
</div>
  <?php
}
?>



