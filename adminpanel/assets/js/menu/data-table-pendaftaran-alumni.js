$(document).ready(function () {
    "use strict";
    var dataProductView = $(".data-thumb-view").DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "menu/ajax/pendaftaran_alumni.php",
            type: "GET",
            datatype: "json",
            data: function(d) {
                d.filterType = $('#valueSelectFilter').val(),
                d.filterTahun = $('#valueFilterTahun').val();
            }
        },
        responsive: false,
        dom: '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
        oLanguage: {
            sLengthMenu: "_MENU_",
            sSearch: ""
        },
        aLengthMenu: [
            [10, 20, 50, 100, 200, 500],
            [10, 20, 50, 100, 200, 500]
        ],
        select: {
            style: "multi"
        },
        order: [
            [4, "desc"]
        ],
        searchable: true,
        bInfo: false,
        pageLength: 10,
        buttons: [
            {
                extend: 'print',
                text: 'Print all',
                exportOptions: {
                    modifier: {
                        selected: null,
                        columns: ':visible',
                    },
                    stripHtml: false,
                },
                className: "btn-outline-primary"
            },
            {
                extend: 'print',
                text: 'Print selected',
                className: "btn-outline-primary",
                exportOptions: {
                    columns: ':visible',
                    stripHtml: false,
                }
            },
            {
                extend: 'excel',
                text: 'Export to Excel',
                className: 'btn-outline-primary',
                messageTop: 'Report Data Alumni Santa Maria Fatima',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,17,18]
                }
            }
        ],
        initComplete: function (settings, json) {
            $(".dt-buttons .btn").removeClass("btn-secondary");
        }
    });
    
    // SUBMIT FORM FILTER DATA
    $("#submitFilter").on('submit', (function (e) {
        e.preventDefault();
        $.ajax({
            url: "menu/ajax/pendaftaran_alumni.php",
            type: "GET",
            data: function(d) {
                d.filterType = $('#valueSelectFilter').val(),
                d.filterTahun = $('#valueFilterTahun').val();
            },
            success: function (data) {
                dataProductView.draw();
            },
            error: function (e) {
                console.log('error !! ajax submit', e);
            }
        });
    }));

    dataProductView.on('draw.dt', function () {
        setTimeout(function () {
            if (navigator.userAgent.indexOf("Mac OS X") != -1) {
                $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox");
            }
        }, 50);
    });
    
    dataProductView.columns.adjust().draw();
	
	
});