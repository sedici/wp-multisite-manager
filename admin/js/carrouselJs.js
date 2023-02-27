// Chequeo el tamaño de la ventana para corregir los parametros
var queryPhone = window.matchMedia("(max-width: 700px)")
var queryMedium = window.matchMedia("(max-width: 1300px)")


function checkDisplay(queryPhone,queryMedium){
  if(queryPhone.matches){
    params["per_view"] = 1;
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

checkDisplay(queryPhone, queryMedium);

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

