$(document).ready(function () {
  //// Choice "Grapes"
  let data = [
    {
      id: 0,
      text: "Merlot",
    },
    {
      id: 1,
      text: "Grenache noir",
    },
    {
      id: 2,
      text: "Syrah",
    },
    {
      id: 3,
      text: "Cabernet sauvignon",
    },
    {
      id: 4,
      text: "Carignan ",
    },
    {
      id: 5,
      text: "Pinot noir",
    },
    {
      id: 6,
      text: "Sauvignon blanc",
    },
  ];

  $(".js-example-data-array").select2({
    data: data,
  });

  $(".js-example-basic-multiple").select2({
    placeholder: "Choix des cépages",
    multiple: "multiple",
  });
});
