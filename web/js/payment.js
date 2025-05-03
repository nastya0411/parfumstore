document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".payment-form");
  const cardNumberInput = document.getElementById("card-number");
  const cardExpiryInput = document.getElementById("card-expiry");
  const cardHolderInput = document.getElementById("card-holder");
  const cardCvvInput = document.getElementById("card-cvv");

  const cardPreviewNumber = document.getElementById("card-preview-number");
  const cardPreviewExpiry = document.getElementById("card-preview-expiry");
  const cardPreviewHolder = document.getElementById("card-preview-holder");
  const cardTypeImg = document.getElementById("card-type-img");
  const submitBtn = document.getElementById("submit-payment");

  function isFormValid() {
    const inputs = form.querySelectorAll(".form-control");
    let isValid = true;

    inputs.forEach((input) => {
      if (
        input.classList.contains("is-invalid") ||
        (input.required && !input.value.trim())
      ) {
        isValid = false;
      }
    });

    return isValid;
  }

  cardNumberInput.addEventListener("input", function () {
    let value = this.value.replace(/\s/g, "");
    if (value.length > 0) {
      let formatted = "";
      for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) formatted += " ";
        formatted += value[i];
      }
      this.value = formatted;

      cardPreviewNumber.textContent =
        formatted + " •••• •••• ••••".substring(formatted.length);
      if (/^4/.test(value)) {
        cardTypeImg.src = "https://img.icons8.com/color/48/000000/visa.png";
      } else if (/^5[1-5]/.test(value)) {
        cardTypeImg.src =
          "https://img.icons8.com/color/48/000000/mastercard.png";
      } else if (/^3[47]/.test(value)) {
        cardTypeImg.src =
          "https://img.icons8.com/color/48/000000/american-express.png";
      } else {
        cardTypeImg.src =
          "https://img.icons8.com/color/48/000000/bank-card-back-side.png";
      }
    } else {
      cardPreviewNumber.textContent = "•••• •••• •••• ••••";
      cardTypeImg.src =
        "https://img.icons8.com/color/48/000000/bank-card-back-side.png";
    }
  });

  cardExpiryInput.addEventListener("input", function () {
    let value = this.value.replace(/\D/g, "");
    if (value.length >= 2) {
      this.value = value.substring(0, 2) + "/" + value.substring(2, 4);
    }
    cardPreviewExpiry.textContent = this.value || "••/••";
  });

  cardHolderInput.addEventListener("input", function () {
    cardPreviewHolder.textContent = this.value.toUpperCase() || "IVAN IVANOV";
  });

  form.addEventListener("input", function (e) {
    if (e.target.classList.contains("form-control")) {
      if (
        e.target.value.trim() !== "" &&
        !e.target.classList.contains("is-invalid")
      ) {
        e.target.classList.add("is-valid");
      } else {
        e.target.classList.remove("is-valid");
      }
    }
  });

  form.addEventListener("submit", function (e) {
    if (!isFormValid()) {
      e.preventDefault();

      const inputs = form.querySelectorAll(".form-control");
      inputs.forEach((input) => {
        if (input.required && !input.value.trim()) {
          input.classList.add("is-invalid");
          const errorElement = input.nextElementSibling;
          if (
            errorElement &&
            errorElement.classList.contains("invalid-feedback")
          ) {
            errorElement.textContent = "Это поле обязательно для заполнения";
          }
        }
      });

      return false;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Обработка платежа...';

    const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

    (async () =>
      await sleep(
        1500
      ))(() => (submitBtn.innerHTML = "Оплата успешно проведена!"));

    setTimeout(() => {}, 2500);
  });
});
