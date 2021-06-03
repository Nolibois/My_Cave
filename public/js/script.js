$(document).ready(function () {
  //// Choice "Grapes"
  let data = [
    {
      id: 0,
      text: "Merlot",
    },
    {
      id: 1,
      text: "Grenache Noir",
    },
    {
      id: 2,
      text: "Syrah",
    },
    {
      id: 3,
      text: "Cabernet Sauvignon",
    },
    {
      id: 4,
      text: "Carignan ",
    },
    {
      id: 5,
      text: "Pinot Noir",
    },
    {
      id: 6,
      text: "Sauvignon Blanc",
    },
  ];

  $(".js-example-data-array").select2({
    data: data,
  });

  $(".js-example-basic-multiple").select2({
    placeholder: "Choix des cépages",
    multiple: "multiple",
    value: data,
  });
});
