$(() => {
  function startCountdown(minutes, seconds, displayElement, callback) {
    const endTime = new Date();
    endTime.setSeconds(endTime.getSeconds() + minutes * 60 + seconds);

    function updateTimer() {
      const now = new Date();
      const remainingMs = endTime - now;

      if (remainingMs <= 0) {
        $(displayElement).text("00:00");
        if (callback) callback();
        return;
      }

      const remainingSecs = Math.floor(remainingMs / 1000);
      const mins = Math.floor(remainingSecs / 60);
      const secs = remainingSecs % 60;

      const formattedMins = mins < 10 ? "0" + mins : mins;
      const formattedSecs = secs < 10 ? "0" + secs : secs;

      $(displayElement).text(formattedMins + ":" + formattedSecs);

      // Запускаем следующий шаг с коррекцией задержки
      const delay = remainingMs % 1000 || 1000; // Ждем оставшиеся мс до следующей секунды
      setTimeout(updateTimer, delay);
    }

    updateTimer(); // Запускаем таймер

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const hook = () => {
      $.ajax({
        url: `/shop/order/qr-payment-hook?id=${id}`,
        success(data) {
          if (data.status) {
            window.location.replace(`view?id=${id}`);
          } else {
            const now = new Date();
            const remainingMs = endTime - now;
            if (remainingMs > 0) {
              setTimeout(hook, 5000);
            }
          }
        },
      });
    };

    setTimeout(hook(), 500);
  }

  startCountdown(5, 0, ".timer-value", function () {
    $(".alert").removeClass("d-none");
    $(".qr").css("filter", "brightness(0.05) sepia(1) hue-rotate(40deg)");
    setTimeout(() => (location.href = "/account"), 3000000);
  });
});
