  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Domains</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Domains</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Domains:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="domainlist" class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>Name</th>
                  <th class="hidden-xs hidden-sm">Type</th>
                  <th class="hidden-xs hidden-sm">Records</th>
                  <th class="no-sort"></th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
<?php foreach (($DOMAINLIST?:array()) as $dl): ?>
                <tr id="row<?php echo $dl['id']; ?>">
                  <td class="hidden-xs hidden-sm"><?php echo $dl['id']; ?></td>
                  <td><?php echo $idn_to_utf8($dl['name']); ?></td>
                  <td class="hidden-xs hidden-sm"><?php echo $dl['type']; ?></td>
                  <td class="hidden-xs hidden-sm"><?php echo $dl['records']; ?></td>
                  <td class="text-center"><a href="/domains/edit/<?php echo $dl['id']; ?>" class="btn btn-info" role="button"><span class="hidden-xs hidden-sm">Edit&nbsp;&nbsp;</span><i class="fa fa-edit"></i></a></td>
                  <td class="text-center"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDomainDelete" data-domainid="<?php echo $dl['id']; ?>" data-domainname="<?php echo $dl['name']; ?>"><span class="hidden-xs hidden-sm">Delete&nbsp;&nbsp;</span><span class="fa fa-trash"></span>
</button></td>
                </tr>
<?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th class="hidden-xs hidden-sm">ID</th>
                  <th>Name</th>
                  <th class="hidden-xs hidden-sm">Type</th>
                  <th class="hidden-xs hidden-sm">Records</th>
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