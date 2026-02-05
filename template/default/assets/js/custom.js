document.addEventListener("DOMContentLoaded", function () {
  const sliderElement = document.querySelector(".slider");
  if (!sliderElement) return;

  const autoplayEnabled = window.SLIDER_CONFIG?.autoplayEnabled ?? true;
  const autoplayDelay = window.SLIDER_CONFIG?.autoplayDelay ?? 5000;

  const swiperConfig = {
    speed: 800,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  };

  if (autoplayEnabled) {
    swiperConfig.autoplay = {
      delay: autoplayDelay,
      disableOnInteraction: false,
    };
  }

  new Swiper(".slider", swiperConfig);
});

document.addEventListener("DOMContentLoaded", function () {
  const donateSwiperEl = document.querySelector(".donate-widget-swiper");
  if (!donateSwiperEl) return;

  new Swiper(".donate-widget-swiper", {
    speed: 500,
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    allowTouchMove: true,
  });
});

document.addEventListener('DOMContentLoaded', () => {

    const tabs = document.querySelectorAll('.hall-tabs button');
    const contents = document.querySelectorAll('.hall-tab');

    if (!tabs.length || !contents.length) return;

    let currentIndex = 0;
    let interval = null;
    const DELAY = 5000; // 5 segundos

    function activateTab(index) {
        tabs.forEach(b => b.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));

        tabs[index].classList.add('active');
        const tabId = tabs[index].dataset.tab;
        document.getElementById(tabId)?.classList.add('active');

        currentIndex = index;
    }

    function startAutoPlay() {
        interval = setInterval(() => {
            let nextIndex = currentIndex + 1;

            if (nextIndex >= tabs.length) {
                nextIndex = 0; // volta pro início
            }

            activateTab(nextIndex);
        }, DELAY);
    }

    function resetAutoPlay() {
        clearInterval(interval);
        startAutoPlay();
    }

    activateTab(0);
    startAutoPlay();

    tabs.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            activateTab(index);
            resetAutoPlay();
        });
    });

});
