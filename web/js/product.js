$(() => {
  $("#product-stars").on("rating:change", function (event, value) {
    const url = $(this).parents(".field-product-stars").data("url");

    $.ajax({
      url: url,
      method: "POST",
      data: { stars: value },
      dataType: "json",
      success(data) {
        if (data) {
            $('.alert-stars').removeClass('d-none')
        }
      },
    });
  });
});
