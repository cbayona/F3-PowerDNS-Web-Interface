  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Edit <span id="domainnametext"><?php echo $DOMAINNAME; ?></span></h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Domain</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
		<div class="col-xs-12">
          <!-- general form elements -->
          <form role="form" lpformnum="1" id="soaupdate">
          <input type="hidden" name="domainID" id="domainID" value="<?php echo $DOMAINID; ?>">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">SOA Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="soa-primary" class="control-label">Primary</label>
                                <input type="text" class="form-control" name="soa-primary" id="soaprimary" placeholder="Primary" autocomplete="off" data-regex="^([^.]+\.)*[^.]+$" tabindex="1" value="<?php echo $idn_to_utf8($SOAPRIMARY); ?>">
                            </div>
                            <div class="form-group">
                                <label for="soa-mail" class="control-label">Email</label>
                                <input name="soa-mail" type="text" class="form-control" id="soamail" placeholder="Email" autocomplete="off" data-regex="^.+@[^.]+(\.[^.]+)*$" tabindex="2" value="<?php echo $idn_to_utf8_email($SOAEMAIL); ?>">
                            </div>
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <div class="form-group">
                                <label for="soa-refresh" class="control-label">Refresh</label>
                                <input name="soa-refresh" type="text" class="form-control" id="soarefresh" placeholder="Refresh" autocomplete="off" data-regex="^[0-9]+$" tabindex="3" value="<?php echo $SOAREFRESH; ?>">
                            </div>
                            <div class="form-group">
                                <label for="soa-retry" class="control-label">Retry</label>
                                <input name="soa-retry" type="text" class="form-control" id="soaretry" placeholder="Retry" autocomplete="off" data-regex="^[0-9]+$" tabindex="4" value="<?php echo $SOARETRY; ?>">
                            </div>
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <div class="form-group">
                                <label for="soa-expire" class="control-label">Expire</label>
                                <input name="soa-expire" type="text" class="form-control" id="soaexpire" placeholder="Expire" autocomplete="off" data-regex="^[0-9]+$" tabindex="5" value="<?php echo $SOAEXPIRE; ?>">
                            </div>
                            <div class="form-group">
                                <label for="soa-ttl" class="control-label">TTL</label>
                                <input name="soa-ttl" type="text" class="form-control" id="soattl" placeholder="TTL" autocomplete="off" data-regex="^[0-9]+$" tabindex="6" value="<?php echo $SOATTL; ?>">
                            </div>
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <div class="form-group">
                                <label for="soa-serial" class="control-label">Serial</label>
                                <input name="soa-serial" type="text" class="form-control" id="soaserial" placeholder="Serial" disabled data-regex=".*"  value="<?php echo $SOASERIAL; ?>">
                            </div>
                        </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary pull-right" id="updateSOAButton">Save</button>
              </div>
          </div>
          </form>
          <!-- /.box -->
          
          <form role="form" lpformnum="1">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Domain Records</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" id="records">
              <table id="recordslist" class="table table-bordered table-striped table-responsive" width="100%">
                <thead>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>Type</th>
                  <th>Name</th>
                  <th>Content</th>
                  <th>Priority</th>
                  <th>TTL</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
<?php $ctr=0; foreach (($DOMAINRECORDS?:array()) as $dr): $ctr++; ?>
                <tr id="row<?php echo $dr['id']; ?>">
                  <td class="hidden-xs hidden-sm"><?php echo $dr['id']; ?></td>
                  <td><a href="#" class="editable-type" id="recordtype<?php echo $ctr; ?>" data-type="select2" data-value="<?php echo $dr['type']; ?>" data-pk="<?php echo $dr['id']; ?>" data-url="/ajax/domains/update" data-linenumber="<?php echo $ctr; ?>"><?php echo $dr['type']; ?></a></td>
                  <td><a href="#" class="editable" data-type="text" data-name="name" data-pk="<?php echo $dr['id']; ?>" <?php if ($dr['type']=='TXT'): ?>data-type="textarea" <?php endif; ?><?php if ($dr['type']=='SPF'): ?>data-type="textarea" <?php endif; ?>data-url="/ajax/domains/update" data-title="Enter hostname" data-linenumber="<?php echo $ctr; ?>"><?php echo $idn_to_utf8($dr['name']); ?></a></td>
                  <td class="wrap-all-words"><a href="#" class="editable" data-type="text" data-name="content" data-pk="<?php echo $dr['id']; ?>" data-url="/ajax/domains/update" data-title="Enter IP or Hostname" data-linenumber="<?php echo $ctr; ?>"><?php echo $idn_to_utf8($dr['content']); ?></a></td>
                  <td><a href="#" class="editable" data-type="text" data-name="priority" data-pk="<?php echo $dr['id']; ?>" data-url="/ajax/domains/update" data-title="Enter Priority" data-linenumber="<?php echo $ctr; ?>"><?php echo $dr['prio']; ?></a></td>
                  <td><a href="#" class="editable" data-type="text" data-name="ttl" data-pk="<?php echo $dr['id']; ?>" data-url="/ajax/domains/update" data-title="Enter hostname" data-linenumber="<?php echo $ctr; ?>"><?php echo $dr['ttl']; ?></a></td>
                  <td>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmRecordDelete" data-recordid="<?php echo $dr['id']; ?>" data-recordname="<?php echo $dr['name']; ?>" data-recordtype="<?php echo $dr['type']; ?>" data-recordcontent="<?php echo $dr['content']; ?>" data-thedomain="<?php echo $DOMAINNAME; ?>" data-domainid="<?php echo $DOMAINID; ?>">
  <span class="fa fa-trash"></span>
</button>
                  </td>
                </tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>Type</th>
                  <th>Name</th>
                  <th>Content</th>
                  <th>Priority</th>
                  <th>TTL</th>
                  <th></th>
                </tr>
                </tfoot>
              </table>

              </div>
              <!-- /.box-body -->
          </div>
          </form>
          <!-- /.box -->          
           <form role="form" lpformnum="2" id="addRecordForm">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add A Record</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">

			<div class="row">
				<div class="col-xs-12 col-md-2">
					<div class="form-group">
                    <label for="type">Type</label>
                    	<select id="addRecordType" name="type" class="form-control select2"></select>
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="form-group">
                    <label for="name">Name</label>
						<input type="text" name="name" id="addName" class="form-control" placeholder="Name" tabindex="8">
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="form-group">
                    <label for="content">Content</label>
						<input type="text" name="content" id="addContent" class="form-control" placeholder="Content" tabindex="9">
					</div>
				</div>
				<div class="col-xs-6 col-md-2">
					<div class="form-group">
                    <label for="priority">Priority</label>
						<input type="text" name="addPriority" id="addPriority" class="form-control" placeholder="0" tabindex="10">
					</div>
				</div>
				<div class="col-xs-6 col-md-2">
					<div class="form-group">
                    <label for="ttl">TTL</label>
						<input type="text" name="addttl" id="addTtl" class="form-control" placeholder="86400" tabindex="11">
					</div>
				</div>                
			</div>              

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" id="addButton" class="btn btn-primary pull-right">Save</button>
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
        <div class="modal modal-danger fade" id="confirmRecordDelete" tabindex="-1" role="dialog" aria-labelledby="confirmRecordDelete">
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