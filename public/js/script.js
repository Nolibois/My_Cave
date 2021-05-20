$(document).ready(function () {
  let order = "asc";

  //// Choice "Grapes"
  let data = [
    {
      id: "Merlot",
      text: "Merlot",
    },
    {
      id: "Grenache Noir",
      text: "Grenache Noir",
    },
    {
      id: "Syrah",
      text: "Syrah",
    },
    {
      id: "Cabernet Sauvignon",
      text: "Cabernet Sauvignon",
    },
    {
      id: "Carignan ",
      text: "Carignan ",
    },
    {
      id: "Pinot Noir",
      text: "Pinot Noir",
    },
    {
      id: "Sauvignon Blanc",
      text: "Sauvignon Blanc",
    },
  ];

  $(".js-example-data-array").select2({
    data: data,
  });

  $(".js-example-basic-multiple").select2({
    placeholder: "Choix des cépages",
    multiple: "multiple",
    selectOnClose: true,
  });

  $("#orderName").on("click", () => {
    /* if(order === 'asc'){

    } */

    $.ajax({
      url: "index.php",
      type: "GET",
      data: "action=manageCave&order=" + order + "&column=name",
      dataType: "json",

      success: function (jsonReturn, status) {
        console.log(jsonReturn);
      },

      error: function (result, status, error) {
        console.log(result);
        console.log(error);
        console.log(status);
      },
    });
  });
});
