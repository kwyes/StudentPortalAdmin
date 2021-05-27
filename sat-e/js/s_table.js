function get_selfsubmit_rows_sate() {
  var from = $("#self-date-from").val();
  var to = $("#self-date-to").val();
  var staffid = $("#sSubmit-stfLeader-select").val();
  var table = $("#datatables-selfsubmit").DataTable();
  var eData = [];
  $.ajax({
    url: "../ajax_php/a.GetSelfSubmitHoursSate.php",
    type: "POST",
    cache: false,
    data: {
      from: from,
      to: to,
      staffid:staffid
    },
    dataType: "json",
    success: function(response) {
      selfsubmitResponse = response;
      if (response.result == 0) {
        console.log("IT");
        table.clear().draw();
      } else {
        $(".selectAll").prop("checked", "");
        $(".selectAll").removeClass("allChecked");
        var atag;
        for (var i = 0; i < response.length; i++) {
          var LastName = response[i].LastName;
          var FirstName = response[i].FirstName;
          var EnglishName = response[i].EnglishName;

          var chkbox =
            '<input class="self-submit-chk" type="checkbox" value="' +
            response[i].StudentActivityID +
            '">';
          var title =
            '<a href="" data-id="' +
            response[i].StudentActivityID +
            '" data-toggle="modal" class="sSubmitNameLink" id="">' +
            response[i].Title +
            "</a>";
          var StatusIcon = GetStatusIcon(response[i].ActivityStatus);
          var categoryIcon = GetCategoryIcon(response[i].ActivityCategory);
          var vlweIcon = GetVlweIcon(response[i].VLWE);
          var date = response[i].SDate.substring(0, 10);
          if (response[0].source == "admin") {
            atag =
              '<a class="hoverShowPic selfSubmitPic" data-id="' +
              response[i].StudentID +
              '" href="#"' +
              '" target="">';
          } else {
            atag =
              '<a class="hoverShowPic selfSubmitPic" data-id="' +
              response[i].StudentID +
              '" href="#"' +
              '" target="">';
          }
          var fullName;
          if (EnglishName) {
            fullName =
              atag + FirstName + " (" + EnglishName + ") " + LastName + "</a>";
          } else {
            fullName = atag + FirstName + " " + LastName + "</a>";
          }
          eData.push([
            chkbox,
            date,
            fullName,
            title,
            response[i].ProgramSource,
            categoryIcon,
            response[i].ActivityCategory,
            vlweIcon,
            formatDecimal(response[i].Hours),
            response[i].StaffFullName,
            StatusIcon,
            response[i].SemesterName,
            response[i].SemesterID,
            response[i].ActivityStatus
          ]);
        }
        table.clear();
        table = $("#datatables-selfsubmit").DataTable({
          data: eData,
          deferRender: true,
          bDestroy: true,
          autoWidth: false,
          responsive: true,
          pagingType: "simple_numbers",
          language: {
            paginate: {
              next: '<i class="material-icons">keyboard_arrow_right</i>', // or '→'
              previous: '<i class="material-icons">keyboard_arrow_left</i>' // or '←'
            }
          },
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
          order: [1, "desc"],
          columnDefs: [
            {
              width: "3%",
              targets: 0,
              orderable: false
            },
            {
              width: "9%",
              targets: 1,
              className: "text-center"
            },
            {
              width: "18%",
              targets: 2
            },
            {
              width: "25%",
              targets: 3
            },
            {
              width: "5%",
              targets: 4,
              className: "text-center"
            },
            {
              width: "9%",
              targets: 5,
              className: "text-center"
            },
            {
              visible: false,
              targets: 6
            },
            {
              width: "6%",
              targets: 7,
              className: "text-center"
            },
            {
              width: "5%",
              targets: 8,
              className: "text-center"
            },
            {
              width: "13%",
              targets: 9
            },
            {
              width: "8%",
              targets: 10,
              className: "text-center"
            },
            {
              visible: false,
              targets: 11
            },
            {
              visible: false,
              targets: 12
            },
            {
              visible: false,
              targets: 13
            }
          ],
          dom:
            '<"row"<"col-md-12 selfsubmit-filter-wrapper"f l>>t<"row"<"col-md-6"i><"col-md-6"p>>',
          aoColumns: [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {
              sType: "num-html"
            },
            null,
            null
          ],
          initComplete: function() {
            this.api().columns().every(function() {
              var column = this;
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on("change", function() {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());

                  column.search(val ? "^" + val + "$" : "", true, false).draw();
                });

              column.data().unique().sort().each(function(d, j) {
                select.append('<option value="' + d + '">' + d + "</option>");
              });
            });
          }
        });

        var val = $("#sSubmit-category-select").val();
        table.column(6).search(val ? "^" + val + "$" : "", true, false).draw();

        table.columns().every(function(index) {
          if (index == 6) {
            var that = this;

            $("#sSubmit-category-select").on("change", function() {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });

        var val1 = $("#sSubmit-term-select").val();
        table
          .column(12)
          .search(val1 ? "^" + val1 + "$" : "", true, false)
          .draw();

        table.columns().every(function(index) {
          if (index == 12) {
            var that = this;

            $("#sSubmit-term-select").on("change", function() {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });

        var val2 = $("#sSubmit-status-select").val();
        table
          .column(13)
          .search(val2 ? "^" + val2 + "$" : "", true, false)
          .draw();

        table.columns().every(function(index) {
          if (index == 13) {
            var that = this;

            $("#sSubmit-status-select").on("change", function() {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              that.search(val ? "^" + val + "$" : "", true, false).draw();
            });
          }
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log("ajax error : " + textStatus + "\n" + errorThrown);
    }
  });
}
