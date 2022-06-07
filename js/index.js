let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.navbar');
let videoBtn = document.querySelectorAll('.vid-btn');
let colors = document.querySelectorAll('.colors');
let sizes = document.querySelectorAll('.sizes');
let color = document.getElementById('color');
let size = document.getElementById('size');
var i=1;

window.onscroll = () =>{
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
}

menu.addEventListener('click', () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
});

videoBtn.forEach(btn =>{
    btn.addEventListener('click', ()=>{
        document.querySelector('.controls .active').classList.remove('active');
        btn.classList.add('active');
        let src = btn.getAttribute('data-src');
        document.querySelector('#video-slider').src = src;
    });
});

colors.forEach(colors =>{
  colors.addEventListener('click', ()=>{
      document.querySelector('.color-container .active').classList.remove('active');
      colors.classList.add('active');
  });
});

sizes.forEach(sizes =>{
  sizes.addEventListener('click', ()=>{
      document.querySelector('.size-container .active').classList.remove('active');
      sizes.classList.add('active');
  });
});

$('#subhidden').hover(function(){
  let colorvalue = document.getElementsByClassName('colors active');
  let sizevalue = document.getElementsByClassName('sizes active');
  console.log(colorvalue.length);
  color.value = colorvalue[1].value;
  size.value = sizevalue[1].value;
});

$(document).ready(function(){
  setInterval(function(){
    i++;
    document.getElementById('video-slider').src = "images/image"+i+".png";
    document.querySelector('.controls .active').classList.remove('active');
    document.getElementById('pan'+i).classList.add('active');
    if (i>2) {
        i=0;
    }
}, 3500);
});


var swiper = new Swiper(".brand-slider", {
    spaceBetween: 20,
    loop:true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    breakpoints: {
        450: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 4,
        },
        1200: {
          slidesPerView: 5,
        },
      },
});


function validateForm() {
  const EMPTY_STR = "";
  var check = true;
  var user_name = document.getElementById('user_name');
  var user_phone = document.getElementById('user_phone');
  var user_email = document.getElementById('user_email');
  var user_address = document.getElementById('user_address');
  var user_name_error = document.getElementById('user_name_error');
  var user_phone_error = document.getElementById('user_phone_error');
  var user_email_error = document.getElementById('user_email_error');
  var user_address_error = document.getElementById('user_address_error');
  
  if(user_name.value==EMPTY_STR) {
      user_name.style.border = "1px solid red";
      user_name_error.innerHTML = "Bạn phải nhập họ tên";
      user_name_error.style.color = "red";
      check = false;
  }else{
    user_name.style.border = EMPTY_STR;
    user_name_error.innerHTML = EMPTY_STR;
    user_name_error.style.color = EMPTY_STR;
  }
  if(user_phone.value == EMPTY_STR) {
      user_phone.style.border = "1px solid red";
      user_phone_error.innerHTML = "Bạn phải nhập số điện thoại";
      user_phone_error.style.color = "red";
      check = false;
  }else{
    user_phone.style.border = EMPTY_STR;
    user_phone_error.innerHTML= EMPTY_STR;
    user_phone_error.style.color= EMPTY_STR;
  }
  if(user_email.value==EMPTY_STR) {
      user_email.style.border = "1px solid red";
      user_email_error.innerHTML = "Bạn phải nhập email";
      user_email_error.style.color = "red";
      check = false;
  }else{
    user_email.style.border = EMPTY_STR;
    user_email_error.innerHTML= EMPTY_STR;
    user_email_error.style.color= EMPTY_STR;
  }
  if(user_address.value==EMPTY_STR) {
    user_address.style.border = "1px solid red";
    user_address_error.innerHTML = "Bạn phải nhập địa chỉ";
    user_address_error.style.color = "red";
    check = false;
  }else{
    user_address.style.border = EMPTY_STR;
    user_address_error.innerHTML = EMPTY_STR;
    user_address_error.style.color = EMPTY_STR;
  }
  
  return check;
}