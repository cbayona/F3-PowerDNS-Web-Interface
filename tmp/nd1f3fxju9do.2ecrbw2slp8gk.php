  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Users</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userlist" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th class="hidden-xs hidden-sm" align="center">ID</th>
                  <th align="center">EMail</th>
                  <th class="hidden-xs hidden-sm" align="center">Name</th>
                  <th class="hidden-xs hidden-sm" align="center">Admin Level</th>
                  <th class="hidden-xs hidden-sm" align="center">Max Domains</th>
                  <th class="no-sort" align="center">Enabled</th>
                  <th class="no-sort"></th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
<?php foreach (($USERLIST?:array()) as $ul): ?>
                <tr id="row<?php echo $ul['userID']; ?>">
                  <td class="hidden-xs hidden-sm"><?php echo $ul['userID']; ?></td>
                  <td><?php echo $ul['userEmail']; ?></td>
                  <td class="hidden-xs hidden-sm"><?php echo $ul['userName']; ?></td>
                  <td class="hidden-xs hidden-sm"><?php echo $ul['userLevelDesc']; ?></td>
                  <td class="hidden-xs hidden-sm"><?php if ($ul['userMaxDomains'] == 0): ?>Unlimited<?php else: ?><?php echo $ul['userMaxDomains']; ?><?php endif; ?></td>
                  <td align="center"><?php if ($ul['userEnabled'] == '0'): ?><i class="fa fa-times-circle fa-2x text-danger" aria-hidden="true"></i><?php else: ?><i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i><?php endif; ?></td>
                  <td align="center"><a href="/users/edit/<?php echo $ul['userID']; ?>" class="btn btn-info" role="button"><span class="hidden-xs hidden-sm">Edit&nbsp;&nbsp;</span><i class="fa fa-edit"></i></a></td>
                  <td class="text-center"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmUserDelete" data-userid="<?php echo $ul['userID']; ?>" data-useremail="<?php echo $ul['userEmail']; ?>"><span class="hidden-xs hidden-sm">Delete&nbsp;&nbsp;</span><span class="fa fa-trash"></span>
</button></td>
                </tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>EMail</th>
                  <th class="hidden-xs hidden-sm">Name</th>
                  <th class="hidden-xs hidden-sm">Admin Level</th>
                  <th class="hidden-xs hidden-sm">Max Domains</th>
                  <th>Enabled</th>
                  <th></th>
                  <th></th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
        <div class="modal modal-danger fade" id="confirmDomainDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDomainDelete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning!</h4>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete this domain?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-outline" id="confirmDelBtn">Yes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->  