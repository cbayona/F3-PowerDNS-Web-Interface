<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/plugins/fastclick/fastclick.js"></script>
<!-- Select2 -->
<script src="/assets/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap Editable -->
<script src="/assets/plugins/bootstrap-editable/js/bootstrap-editable.js"></script>
<!-- Pnotify -->
<script type="text/javascript" src="/assets/plugins/pnotify/pnotify.js"></script>
<!-- page script -->
<script>
PNotify.prototype.options.styling = "bootstrap3";
$(document).ready(function() {
    $('#addUserButton').on('click', function() {
        addUser();
    });

    $('#genPassButton').on('click', function() {
		console.log('Pressed');
        genPass();
    });

    function addUser() {
        var data = {
            useremail: $('#useremail').val(),
			username: $('#username').val(),
            userpassword1: $('#userpass1').val(),
            userpassword2: $('#userpass2').val(),
            role: $('#userrole').val(),
            maxdomains: $('#maxdomains').val(),
            csrfToken: $('#csrfToken').text()
        };
        $.ajax({
            url: '/ajax/users/add',
            method: 'POST',
            data: data
        }).done(function(dataRecv) {
            var jsonreply = $.parseJSON(dataRecv);
			var redirUrl = jsonreply.userid;
			window.location.href = "/users/edit/"+redirUrl;
        }).fail(function(errorMsg) {
            new PNotify({
                title: 'Error!',
                text: errorMsg.responseText,
                type: 'error',
                icon: false
            });

        });
    }

    function genPass() {
        $.ajax({
            url: '/ajax/password',
            method: 'GET',
            data: 'newpass'
        }).done(function(dataRecv) {
            var jsonreply = $.parseJSON(dataRecv);
            document.getElementById("userpass1").value = jsonreply.password;
            document.getElementById("userpass2").value = jsonreply.password;
			$('#userpass1').prop('type', 'text');
        });
    }

    $('#confirmRecordDelete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var recordid = button.data('recordid') // Extract info from data-* attributes
        var recordname = button.data('recordname')
        var recordtype = button.data('recordtype')
        var recordcontent = button.data('recordcontent')
        var thedomain = button.data('thedomain')
        var domainid = button.data('domainid')
        var tablerowid = '#row' + recordid
        var content = 'Are you sure want to delete the <b>' + recordtype + '</b> record: <b>' + recordname + '</b> which points to <b>' + recordcontent + '</b> ?'
        var modal = $(this)
        modal.find('.modal-body').html(content)
        $("#confirmDelBtn").unbind("click").click(function(e) {
            var data = {
                id: recordid,
                type: recordtype,
                content: recordcontent,
                domain: thedomain,
                name: recordname,
                domainid: domainid,
                csrfToken: $('#csrfToken').text()
            };

            $.ajax({
                url: '/ajax/records/delete',
                method: 'POST',
                data: data
            }).done(function(data) {
                $('#confirmRecordDelete').modal('hide');
                $(tablerowid).closest('tr').remove();
                new PNotify({
                    title: 'Record Deleted!',
                    text: 'Your record has been deleted',
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