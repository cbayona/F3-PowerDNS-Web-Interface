  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Edit <span id="useremailtext"><?php echo $USEREMAIL; ?></span></h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
		<div class="col-xs-12">
          <!-- general form elements -->
          <form role="form" lpformnum="1" id="userupdate">
          <input type="hidden" name="userID" id="userID" value="<?php echo $USERID; ?>">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="useremail" class="control-label">Email Address</label>
                                <input name="useremail" type="email" class="form-control" id="usermail" placeholder="Email" autocomplete="off" data-regex="^.+@[^.]+(\.[^.]+)*$" tabindex="1" value="<?php echo $USEREMAIL; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="username" class="control-label">Name</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Name" autocomplete="off" tabindex="2" value="<?php echo $USERNAME; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="userrole" class="control-label">Role</label>
                                <select name="userrole" class="form-control" id="userrole" tabindex="3">
                                    <option value="0"<?php if ($USERADMINLEVEL == 0): ?> selected<?php endif; ?>>User</option>
                                    <option value="1"<?php if ($USERADMINLEVEL == 1): ?> selected<?php endif; ?>>Domain Admin</option>
                                    <option value="2"<?php if ($USERADMINLEVEL == 2): ?> selected<?php endif; ?>>Site Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="maxdomains" class="control-label">Max Domains </label>
                                <input name="maxdomains" type="text" class="form-control" id="maxdomains" placeholder="Max" value="<?php echo $USERMAXDOM; ?>">
                                <small>(0=unlimited)</small>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="userenabled" class="control-label">Enabled</label>
                                <select name="userenabled" id="userenabled" class="form-control">
                                    <option value="1"<?php if ($USERENABLED == 1): ?> selected<?php endif; ?>>Yes</option>
                                    <option value="0"<?php if ($USERENABLED == 0): ?> selected<?php endif; ?>>No</option>
                                </select>
                            </div>
                        </div>                        
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary pull-right" id="updateUserButton">Save</button>
              </div>
          </div>
          </form>
          <!-- /.box -->
          
          <form role="form" lpformnum="1">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Domains</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" id="domains">
              <table id="userdomainslist" class="table table-bordered table-striped table-responsive" width="100%">
                <thead>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>Domain</th>
                  <th>Type</th>
                  <th></th>
                  <th class="no-sort"></th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
<?php $ctr=0; foreach (($USERDOMLIST?:array()) as $ud): $ctr++; ?>
                <tr id="row<?php echo $ud['id']; ?>">
                  <td class="hidden-xs hidden-sm"><?php echo $ud['id']; ?></td>
                  <td><?php echo $ud['name']; ?></td>
                  <td><?php echo $ud['type']; ?></td>
                  <td><?php if ($ud['type'] == 'SLAVE'): ?><b>Master:</b> <?php echo $ud['master']; ?><?php endif; ?></td>
                  <td class="text-center"><a href="/domains/edit/<?php echo $ud['id']; ?>" class="btn btn-info" role="button"><span class="hidden-xs hidden-sm">Edit&nbsp;&nbsp;</span><i class="fa fa-edit"></i></a></td>
                  <td class="text-center">
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDomainDelete" data-userid="<?php echo $USERID; ?>" data-domainid="<?php echo $ud['id']; ?>" data-domainname="<?php echo $ud['name']; ?>">
  <span class="fa fa-trash"></span>
</button>
                  </td>
                </tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>Domain</th>
                  <th>Type</th>
                  <th></th>
                  <th class="no-sort"></th>
                  <th class="no-sort"></th>
                </tr>
                </tfoot>
              </table>
              </div>
              <!-- /.box-body -->
          </div>
          </form>
          <!-- /.box -->                   
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
        <div class="modal modal-danger fade" id="confirmDomainDelete" tabindex="-1" role="dialog" aria-labelledby="confirmRecordDelete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning!</h4>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete the <b><span id="deleteTypeText"></span></b> record: <b><span id="deleteRecord"></span></b></p>
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