$(() => {
  const cartCountReload = () => {
    $.ajax({
      url: "/shop/cart/count",
      method: "POST",
      success(data) {
        if (data.status) {
          $("#cart-item-count").html(data.value);
        }
      },
    });
  };

//   $("#catalog-pjax").on("click", ".btn-add-cart", function (e) {
//     e.preventDefault();
    
//   });
const productAdd = (el) => 
$.ajax({
    url: el.attr("href"),
    success(data) {
      if (data) {
        cartCountReload();
      }
    },
  });


  $("#catalog-pjax").on('click', ".product-card", function(e) {

    if ($(e.target).hasClass('btn-add-cart')) {
        productAdd($(e.target));        
        return false;
    }
    
    location.assign($(this).data('url')) 
  })


  cartCountReload();
});
