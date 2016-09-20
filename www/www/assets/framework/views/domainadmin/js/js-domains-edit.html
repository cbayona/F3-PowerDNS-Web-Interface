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
  $(function() {
      $('#recordslist').dataTable({
          "order": [],
          "pageLength": 50,
          "autoWidth": true,
          "columnDefs": [{
              "targets": 'no-sort',
              "orderable": true,
              "width": "15%",
              "targets": 1
          }]
      });
  });
</script>
<script>
PNotify.prototype.options.styling = "bootstrap3";
$(document).ready(function() {
    $('.editable').editable({
        params: function(params) {
            var lineid = $(this).data("linenumber");
            var data = {};
            data.pk = params.pk;
            data.name = params.name;
            data.value = params.value;
            data.recordtype = $("#recordtype" + lineid).data('value');
            return data;
        },
    });
    $('.editable-type').editable({
        source: [{
            id: 'A',
            text: 'A'
        }, {
            id: 'AAAA',
            text: 'AAAA'
        }, {
            id: 'AFSDB',
            text: 'AFSDB'
        }, {
            id: 'CERT',
            text: 'CERT'
        }, {
            id: 'CNAME',
            text: 'CNAME'
        }, {
            id: 'DHCID',
            text: 'DHCID'
        }, {
            id: 'DLV',
            text: 'DLV'
        }, {
            id: 'DNSKEY',
            text: 'DNSKEY'
        }, {
            id: 'DS',
            text: 'DS'
        }, {
            id: 'EUI48',
            text: 'EUI48'
        }, {
            id: 'EUI64',
            text: 'EUI64'
        }, {
            id: 'HINFO',
            text: 'HINFO'
        }, {
            id: 'IPSECKEY',
            text: 'IPSECKEY'
        }, {
            id: 'KEY',
            text: 'KEY'
        }, {
            id: 'KX',
            text: 'KX'
        }, {
            id: 'LOC',
            text: 'LOC'
        }, {
            id: 'MINFO',
            text: 'MINFO'
        }, {
            id: 'MR',
            text: 'MR'
        }, {
            id: 'MX',
            text: 'MX'
        }, {
            id: 'NAPTR',
            text: 'NAPTER'
        }, {
            id: 'NS',
            text: 'NS'
        }, {
            id: 'NSEC',
            text: 'NSEC'
        }, {
            id: 'NSEC3',
            text: 'NSEC3'
        }, {
            id: 'NSEC3PARAM',
            text: 'NSEC3PARAM'
        }, {
            id: 'OPT',
            text: 'OPT'
        }, {
            id: 'PTR',
            text: 'PTR'
        }, {
            id: 'RKEY',
            text: 'RKEY'
        }, {
            id: 'RP',
            text: 'RP'
        }, {
            id: 'RRSIG',
            text: 'RRSIG'
        }, {
            id: 'SPF',
            text: 'SPF'
        }, {
            id: 'SRV',
            text: 'SRV'
        }, {
            id: 'SSHFP',
            text: 'SSHFP'
        }, {
            id: 'TLSA',
            text: 'TLSA'
        }, {
            id: 'TSIG',
            text: 'TSIG'
        }, {
            id: 'TXT',
            text: 'TXT'
        }, {
            id: 'WKS',
            text: 'WKS'
        }],
        select2: {
            multiple: false
        }
    });


    $('#addButton').on('click', function() {
        addRecord();
    });

    $('#updateSOAButton').on('click', function() {
        updateSOA();
    });

    var availableRecordTypes = [
        "A", "AAAA", "AFSDB", "CERT", "CNAME", "DHCID",
        "DLV", "DNSKEY", "DS", "EUI48", "EUI64", "HINFO",
        "IPSECKEY", "KEY", "KX", "LOC", "MINFO", "MR",
        "MX", "NAPTR", "NS", "NSEC", "NSEC3", "NSEC3PARAM",
        "OPT", "PTR", "RKEY", "RP", "RRSIG", "SPF",
        "SRV", "SSHFP", "TLSA", "TSIG", "TXT", "WKS"
    ];

    $('#addRecordType').select2({
        data: availableRecordTypes
    });

    function addRecord() {
        var url = window.location.pathname.split('/').slice(1);
        var domainName = $('#domainnametext').text();
        var prio = $('#addPriority').val();
        if (prio.length === 0) prio = 0;
        var ttl = $('#addTtl').val();
        if (ttl.length === 0) ttl = 86400;
        var content = $('#addContent').val();
        if (content.length === 0) content = domainName;
        var data = {
            type: $('#addRecordType').val(),
            content: content,
            prio: prio,
            ttl: ttl,
            action: "addRecord",
            domain: url[2],
            csrfToken: $('#csrfToken').text()
        };

        if ($('#addName').val().length > 0) {
            data.name = $('#addName').val() + "." + domainName;
        } else {
            data.name = domainName;
        }

        $.ajax({
            url: '/ajax/records/add',
            method: 'POST',
            data: data
        }).done(function(dataRecv) {
            var jsonreply = $.parseJSON(dataRecv);
            $('<tr></tr>').appendTo('#recordslist>tbody')
                .append('<td>' + jsonreply.newid + '</td>')
                .append('<td>' + data.type + '</td>')
                .append('<td>' + data.name + '</td>')
                .append('<td class="wrap-all-words">' + data.content + '</td>')
                .append('<td>' + data.prio + '</td>')
                .append('<td>' + data.ttl + '</td>');
            document.getElementById("soaserial").value = jsonreply.newserial;
            new PNotify({
                title: 'Record Added!',
                text: 'Your record has been added',
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
    }

    function updateSOA() {
        var domainid = $("#domainID").val();
        var domainName = $("#domainnametext").text();
        var soaprimary = $("#soaprimary").val();
        var soamail = $("#soamail").val();
        var soarefresh = $("#soarefresh").val();
        var soaretry = $("#soaretry").val();
        var soaexpire = $("#soaexpire").val();
        var soattl = $("#soattl").val();
        var soaserial = $("#soaserial").val();
        var data = {
            domainid: domainid,
            domainname: domainName,
            soaPrimary: soaprimary,
            soaMail: soamail,
            soaRefresh: soarefresh,
            soaRetry: soaretry,
            soaExpire: soaexpire,
            soaTtl: soattl,
            soaSerial: soaserial,
            csrfToken: $('#csrfToken').text()
        };

        $.ajax({
            url: '/ajax/records/soaupdate',
            method: 'POST',
            data: data
        }).done(function(dataRecv) {
            var jsonreply = $.parseJSON(dataRecv);
            document.getElementById("soaserial").value = jsonreply.newserial;
            new PNotify({
                title: 'SOA Updated',
                text: 'Domain SOA record has been updated',
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