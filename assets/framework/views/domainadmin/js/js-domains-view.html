<!-- DataTables -->
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/plugins/fastclick/fastclick.js"></script>
<!-- Pnotify -->
<script type="text/javascript" src="/assets/plugins/pnotify/pnotify.js"></script>
<!-- page script -->
<script>
  $(function() {
      $('#domainlist').dataTable({
          "order": [],
          "columnDefs": [{
              "targets": 'no-sort',
              "orderable": false,
          }]
      });
  });
</script>
<script>
PNotify.prototype.options.styling = "bootstrap3";
$(document).ready(function() {
    $('#confirmDomainDelete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var domainid = button.data('domainid') // Extract info from data-* attributes
        var domainname = button.data('domainname')
        var tablerowid = '#row' + domainid
        var content = 'Are you sure want to delete <b>' + domainname + '</b>?'
        var modal = $(this)
        modal.find('.modal-body').html(content)
        $("#confirmDelBtn").unbind("click").click(function(e) {
            var data = {
                domainid: domainid,
                domainname: domainname,
                csrfToken: $('#csrfToken').text()
            };

            $.ajax({
                url: '/ajax/domains/delete',
                method: 'POST',
                data: data
            }).done(function(data) {
                $('#confirmDomainDelete').modal('hide');
                $(tablerowid).closest('tr').remove();
                new PNotify({
                    title: 'Domain Deleted!',
                    text: 'Your domain has been deleted',
                    type: 'success',
                    icon: false
                });
            }).fail(function(errorMsg) {
                new PNotify({
                    title: 'Error!',
                    text: errorMsg.responseText,
                    type: 'error',
                    icon: false
                });
            });
        });
    });
});
</script>