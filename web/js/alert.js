// $(() => {
//   const showAlert = () => {
//     setTimeout(() => {
//       $(".alert-count").fadeIn(1500);
//     }, 100);

//     setTimeout(() => {
//       $(".alert-count").fadeOut(2000);
//     }, 3000);
//   };



//   const startsAdd = (el) =>
//     $.ajax({
//       url: el.attr("href"),
//       success(data) {
//         if (data.success) {
//           showAlert();
//         } else {
//             ''
//         }
//       }
//     });


//   $("#cart-pjax").on("pjax:end", () => {
//     cartCountReload();
//     if ($(".alert-stars-empty").length) {
//       $(".btn-stars-create").addClass("d-none");
//     }
//   });

//   cartCountReload();
// });
