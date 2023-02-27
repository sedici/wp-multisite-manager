
function getMs(){
  let autoplay;
  let miliseconds = params["autoplay_seconds"];
  if(miliseconds > 0){
    return autoplay = {
      delay: 5000
    }
  }
  else{
    return autoplay = false
  }
}

 export let swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    autoHeight: true,
    autoplay: getMs(),
    loop: true,
    slidesPerView: params["per_view"],
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  });

  console.log(swiper);


