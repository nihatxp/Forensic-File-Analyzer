$(function () {
    $(document).ready(function () {
      $("#max").hide();
      $("#openFile").on("change", function (evt) {
        if (this.files[0] != undefined) {
          var row = Math.ceil(this.files[0].size / 16);
          if (row) {
            $("#max").show();
            console.log(row);
            $("#rowNum").removeAttr("disabled");
            $("#rowNum").attr("max", row);
            $("#max_num").html(row);
          }
        } else {
          $("#rowNum").attr("disabled", "disabled");
          $("#rowNum").val("0");
          $("#max").hide();
        }
      });
    });
  });
  