$(document).ready(function () {
  ////////////// Choice "GRAPES"
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

  ///////////////// Choice YEARS

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

    $("#myModal").css("display", "flex");
    const textReturn = "";

    let dataUri = $("#formUpdate").attr("action");

    $("#close").on("click", (e) => {
      $("#myModal").css("display", "none");
    });

    $("#delete").on("click", (e) => {
      $("#myModal").css("display", "none"),
        $.get(dataUri, dataUri, textReturn, "text");
    });
  });

  /////////////// SLICK Carousel ////////////////
  $(".single-item").slick();

  ///////////// Display one bottle selected from the list ///////////////////////////
  $(".card-bottle").on("click", (e) => {
    // AJAX
  });

  /////////////// Scroll Up //////////////////
  $("#scroll-up").click(function () {
    $("html, body").animate(
      {
        scrollTop: $("#logo-nav").offset().top,
      },
      1000
    );
  });
});
