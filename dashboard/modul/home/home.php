        <section class="content-header">
          <h1>
            Submission
            <small>Version 1.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
<?php
//if presenter or participant just redirect to profile page
 if ($_SESSION['group_level']=='presenter' or $_SESSION['group_level']=='participant') {
  ?>
  <script type="text/javascript">window.location="<?=base_index();?>profil"</script>
  <?php
} elseif ($_SESSION['group_level']=='reviewer') {
  $abstract_count = $db->fetch_custom_single("select count(tb_data_abstract.id) as jml from tb_data_reviewer
inner join tb_data_abstract on id_abstract=tb_data_abstract.id
 where tb_data_reviewer.id_reviewer=? and status_abstract!='Accepted'",array('id_reviewer' => $_SESSION['id_user']));
 // echo $db->getErrorMessage();

$jml_unfinish_paper=0;

  $status = $db->fetch_custom_single("select status_paper from tb_data_papers inner join tb_data_abstract on tb_data_papers.id_abstract=tb_data_abstract.id
inner join tb_data_reviewer on tb_data_abstract.id=tb_data_reviewer.id_abstract where tb_data_reviewer.id_reviewer=? and status_abstract!='Accepted'",array('id_reviewer' => $_SESSION['id_user']));
  foreach ($status as $stat) {
    if ($stat->status_paper!='Accepted') {
      if ($stat->status_paper!='') {
        $jml_unfinish_paper++;
      }
  }
  }

  ?>
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-pencil-square-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Abstracts Need to be Reviewed</span>
                  <span class="info-box-number"><?=$abstract_count->jml;?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-newspaper-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Papers Need to be Reviewed</span>
                  <span class="info-box-number"><?=$jml_unfinish_paper;?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
</section>
  <?php
} else {

  $get_list_id_abstract = $db->query("select * from tb_data_papers inner join tb_data_abstract on tb_data_papers.id_abstract=tb_data_abstract.id where ada=1");
  $abstract_count = $db->fetch_custom_single("select count(id) as jml from tb_data_abstract where status_abstract!='Accepted' and ada=1");
$jml_unfinish_paper=0;
foreach ($get_list_id_abstract as $dt) {
//  $status = $db->fetch_custom_single("select get_status_paper($dt->id) as status");
  if ($dt->status!='Accepted') {
    $jml_unfinish_paper++;
  }
}
            ?>        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
             <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-pencil-square-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Abstracts Need to be Reviewed</span>
                  <span class="info-box-number"><?=$abstract_count->jml;?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-newspaper-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Papers Need to be Reviewed</span>
                  <span class="info-box-number"><?=$jml_unfinish_paper;?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class='row'>
  <div class="col-md-7">
              <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Article Scope</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Scope Name</th>
                          <th>Total</th>
                          <th>Act</th>
                        </tr>
                      </thead>
                      <tbody>
<?php $data_scope = $db->query("select scope_name,id_scope,count(id_scope) as jml_scope from tb_data_abstract 
inner join tb_ref_scope on id_scope=tb_ref_scope.id where ada=1
group by id_scope");
$jml=0;
  foreach ($data_scope as $scope) {
    ?>

                        <tr>
                          <td><a href="<?=base_index();?>submission"><?=$scope->scope_name;?></a></td>
                          <td><?=$scope->jml_scope;?></td>
                          <td><a class="btn btn-primary" data-toggle="tooltip" data-title="Download Papers" href="<?=base_admin();?>modul/home/down_paper.php?id=<?=$scope->id_scope;?>"><i class="fa fa-download"></i></a></td>
                        </tr>
    <?php
$jml+=$scope->jml_scope;
  }
    ?>
    <tr>
      <td>Total</td>
      <td class="btn btn-sm btn-success btn-flat"><?=$jml;?></td>
    </tr>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
             
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class='col-md-5'>
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Latest Members</h3>
                  <div class="box-tools pull-right">
                    <span class="label label-danger">New Members</span>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php
                    $users = $db->query("select * from sys_users order by id desc limit 8 where id > 2");
                    foreach ($users as $user) {
                      ?>
                    <li>
                      <img src="<?=base_url();?>upload/back_profil_foto/<?=$user->foto_user;?>" alt="User Image"/>
                      <a class="users-list-name" href="#"><?=$user->full_name;?></a>
                      <span class="users-list-date"><?=$user->date_created;?></span>
                    </li>
                    <?php
                    }
                    ?>

                  </ul><!-- /.users-list -->
                </div><!-- /.box-body -->
               
              </div><!--/.box -->
            </div><!-- /.col -->
          
          </div><!-- /.row -->



        </section><!-- /.content -->
  <?php
}
?>