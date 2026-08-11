/*=========================================================================================
    File Name: data-list-view.js
    Description: List View
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {
    "use strict"
    var dataThumbView = $('.data-thumb-view').DataTable();
    dataThumbView.destory();
    dataThumbView.DataTable({
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
            [1, "desc"]
        ],
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
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        initComplete: function (settings, json) {
            $(".dt-buttons .btn").removeClass("btn-secondary")
        }
    })

})