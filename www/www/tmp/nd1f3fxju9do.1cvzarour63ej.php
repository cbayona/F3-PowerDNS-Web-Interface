  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add Master Domain</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Domain</li>
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
              <h3 class="box-title">Create Domain Name Record</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="domainName" class="control-label">Domain Name</label>
                                <input type="text" class="form-control" name="domainName" id="domainName" autocomplete="off" data-regex="^([^.]+\.)*[^.]+$" tabindex="1">
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Primary Name Server</label>
                                <input name="email" type="text" class="form-control" id="primaryNameserver" autocomplete="on"  tabindex="3" value="<?php echo $SOAEMAIL; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Email" autocomplete="off" data-regex="^.+@[^.]+(\.[^.]+)*$" tabindex="2">
                            </div>
                        </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary pull-right" id="addDomainButton">Add Domain</button>
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