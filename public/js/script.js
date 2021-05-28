$(document).ready(function () {
  //// Choice "Grapes"
  let dataGrapes = [
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
    {
      id: "Viognier",
      text: "Viognier",
    },
  ];

  $(".js-grapes-data-array").select2({
    data: dataGrapes,
  });

  // For Filters Form
  $(".js-grapes-basic-multiple").select2({
    placeholder: "Choix des cépages",
    multiple: "multiple",
    allowClear: true,
  });

  /* // For Settings Form
  $(".js-grapes-basic-multiple-2").select2({
    placeholder: "Choix des cépages",
    multiple: "multiple",
    allowClear: true,
  });

  // For Create New Bottle Form
  $(".js-grapes-basic-multiple-3").select2({
    placeholder: "Choix des cépages",
    multiple: "multiple",
    allowClear: true,
  }); */

  ///////////////// Year ////////////////////

  let dataYear = [];
  let nowDate = new Date();
  const firstDate = new Date("january 01, 1900 00:01:00");
  const firstYear = firstDate.getFullYear();
  let nbYear = nowDate.getFullYear() - firstYear;

  for (let i = 0; i <= nbYear; i++) {
    dataYear.push(firstYear + i);
  }

  $(".js-year-data-array").select2({
    data: dataYear,
  });

  $(".js-year-basic").select2({
    placeholder: "Année",
    allowClear: true,
  });

  //////////////// Delete bottle confirmation /////////////
  $("#btn-del").on("click", (e) => {
    e.preventDefault();

    $("#myModal").css("display", "block");
    const textReturn = "";

    let dataUri = $("#formUpdate").attr("action");
    console.log("URL: " + dataUri);

    $("#close").on("click", (e) => {
      $("#myModal").css("display", "none");
    });

    $("#delete").on("click", (e) => {
      $("#myModal").css("display", "none"),
        $.get(dataUri, dataUri, textReturn, "text");
    });

    console.log(textReturn);
  });
});
