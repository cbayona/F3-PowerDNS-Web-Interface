  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add User Account</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
		<div class="col-xs-12">
          <!-- general form elements -->
          <form role="form" lpformnum="1" id="soaupdate">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create User Account</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="useremail" class="control-label">Email Address</label>
                                <input name="useremail" type="email" class="form-control" id="useremail" placeholder="Email" autocomplete="off" data-regex="^.+@[^.]+(\.[^.]+)*$" tabindex="1" value="<?php echo $USEREMAIL; ?>">
                            </div>
                            <div class="form-group">
                                <label for="userpass1" class="control-label">User Password</label>
                                <input name="userpass1" type="password" class="form-control" id="userpass1" autocomplete="off" tabindex="6" value="<?php echo $USEREMAIL; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="username" class="control-label">Name</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Name" autocomplete="off" tabindex="2">
                            </div>
                            <div class="form-group">
                                <label for="userpass2" class="control-label">User Password Again</label>
                                <input name="userpass2" type="password" class="form-control" id="userpass2" autocomplete="off" tabindex="7">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="userrole" class="control-label">Role</label>
                                <select name="userrole" class="form-control" id="userrole" tabindex="3">
                                    <option value="0">User</option>
                                    <option value="1">Domain Admin</option>
                                    <option value="2">Site Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                            	<label>&nbsp;</label>
								<button type="button" class="btn btn-block btn-success" id="genPassButton">Generate Password</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="maxdomains" class="control-label">Max Domains </label>
                                <input name="maxdomains" type="text" class="form-control" id="maxdomains" placeholder="Max" tabindex="4">
                                <small>(0=unlimited)</small>
                            </div>
                        </div>                       
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary pull-right" id="addUserButton">Add User</button>
              </div>
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