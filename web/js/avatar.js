$(() => {
  $(".btn-avatar").on("click", function (e) {
    e.preventDefault();
    $("#avatar-modal").modal("show");
  });

  const avatarReload = () => {
    $.pjax.reload({
      container: "#avatar-pjax",
      push: false,
      timeout: 5000,
    });
  };

  $("#form-avatar-pjax").on("pjax:end", () => {
    $("#avatar-modal").modal("hide");
    avatarReload();
  });

  $(".avatar-delete").on("click", function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr("href"),
      success(data) {
        if (data) {
          avatarReload();
        }
      },
    });
  });

  $(document).on("shown.bs.modal", "#avatar-modal", function () {
    if (!$(".modal-close-btn", this).length) {
      const closeBtn = $("<button>", {
        class: "modal-close-btn",
        type: "button",
        "aria-label": "Закрыть",
      }).appendTo($(".custom-modal-header", this));

      closeBtn.on("click", function () {
        $("#avatar-modal").modal("hide");
      });
    }
  });
});
