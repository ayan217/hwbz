
// count

var counted = 0;
$(window).scroll(function () {
  var oTop = $('#counter').offset().top - window.innerHeight;
  if (counted == 0 && $(window).scrollTop() > oTop) {
    $('.counts').each(function () {
      var $this = $(this),
        countTo = $this.attr('data-count');
      $({
        countNum: $this.text(),
      }).animate(
        {
          countNum: countTo,
        },

        {
          duration: 2000,
          easing: 'swing',
          step: function () {
            $this.text(Math.floor(this.countNum));
          },
          complete: function () {
            $this.text(this.countNum);
            //alert('finished');
          },
        }
      );
    });
    counted = 1;
  }
});


const navbtn=document.querySelector(".nav-togglebtn");
const navSlider=document.querySelector(".sliderphone");


navbtn.addEventListener("click",function(){
    navSlider.classList.toggle("toggle-cls");
})