// Chequeo el tamaño de la ventana para corregir los parametros
var queryPhone = window.matchMedia("(max-width: 950px)")


function checkDisplay(queryPhone){
  if(queryPhone.matches){
    params["per_view"] = 1;
    params["direction"] = 'horizontal';
  }

}


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

checkDisplay(queryPhone);

 export let swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: params["direction"],
    autoHeight: false,
    centeredSlides: true,
    autoplay: getMs(),
    loop: false,
    slidesOffsetAfter:0,

    slidesPerView: params["per_view"],
    // If we need pagination
    
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
  });
