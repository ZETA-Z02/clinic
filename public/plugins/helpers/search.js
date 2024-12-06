function search(idsearch, idtable) {
  $(`#${idsearch}`).on("keyup", function () {
    let value = $(this).val().toLowerCase();
    $(`#${idtable} tr`).filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
}
