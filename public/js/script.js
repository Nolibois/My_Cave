$(document).ready(function () {
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
});
