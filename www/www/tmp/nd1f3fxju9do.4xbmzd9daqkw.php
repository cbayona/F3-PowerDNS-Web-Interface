<!-- SlimScroll -->
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/plugins/fastclick/fastclick.js"></script>
<!-- Pnotify -->
<script type="text/javascript" src="/assets/plugins/pnotify/pnotify.js"></script>
<!-- page script -->
<script>
PNotify.prototype.options.styling = "bootstrap3";
$(document).ready(function() {
    $('#addDomainButton').on('click', function() {
        addDomain();
    });
    function addDomain() {
        var data = {
            domain: $('#domainName').val(),
            email: $('#email').val(),
            primary: $('#primaryNameserver').val(),
            csrfToken: $('#csrfToken').text()
        };
        $.ajax({
            url: '/ajax/domains/add',
            method: 'POST',
            data: data
        }).done(function(dataRecv) {
			var redirUrl = dataRecv;
			window.location.href = "/domains/edit/"+redirUrl;
        }).fail(function(errorMsg) {
            new PNotify({
                title: 'Error!',
                text: errorMsg.responseText,
                type: 'error',
                icon: false
            });

        });
    }
});
</script>