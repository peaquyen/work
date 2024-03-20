var page = 1;

$(function () {
  getData();
});

$("#show").click(function () {
  page++;
  getData(page);
});

function getData(page = 1) {
  $type = $("#show").attr("data-type");

  $.ajax({
    type: "POST",
    url: "data.php?page=" + page,
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({
      type: $type,
    }),
    success: function (data) {
      if (data.length < 2) {
        $("#show").fadeOut(1000);
      }
      viewData_1(data, $type);
      $("#show").text("Show More....");
    },
  });
}

var total = 0;
var count = 0;
function viewData_1(data, $type) {
  $.each(data, function (key, value) {
    count++;
    drawRow(value, $type, count);
    total++;
  });
  if (data.length < 2) {
    drawFoot(total);
  }
}

function drawRow(rowData, $type, count) {
  var row = $("<tr />");
  $(".table").append(row);
  row.append(`<td align="center">${count}</td>`);

  if ($type == "posts") {
    row.append(`<td>${rowData.company.title}</td>`);
    row.append(`<td>${rowData.title}</td>`);
    row.append(`<td>${rowData.salary}</td>`);
    row.append(`<td class="text-center">
                        <a href="details.php?id=${rowData.id}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-circle-info"></i>                            
                        </a>
                    </td>`);

    row.append(`<td class="text-center">
                        <a href="editPost.php?id=${rowData.id}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>                         
                        </a>
                    </td>`);
    row.append(`<td class="text-center">
                        <a href="./ajax/deletePost.php?id=${rowData.id}" data-id-listing="${rowData.id}" class="btn-delete-listing btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to delete?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>`);
  }

  if ($type == "users") {
    row.append(`<td>${rowData.fullname}</td>`);
    row.append(`<td>${rowData.email}</td>`);
    row.append(`<td>${rowData.phone}</td>`);
    row.append(`<td class="text-center">
                        ${
                          rowData.status == 1
                            ? '<button class="btn btn-success btn-sm">Activated</button>'
                            : '<button class="btn btn-danger btn-sm">Not activated</button>'
                        }
                    </td>`);

    row.append(`<td class="text-center">
                        <a href="editUser.php?id=${rowData.id}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>`);

    row.append(`<td class="text-center">
                        <a href="deleteUser.php?id=${rowData.id}" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to delete?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>`);
  }
}

function drawFoot(total) {
  var row = $("<tr />");
  $("tfoot").append(row);
  row.append(`<th colspan="3">Total:</th>`);
  row.append(`<th colspan="4">${total}</th>`);
}
