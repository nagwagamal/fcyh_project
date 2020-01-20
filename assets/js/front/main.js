$(function() {
});
$(window).on('load', function() {
  document.querySelectorAll('.component--main-slider').forEach(element => {
    new MainSlider({selector: element}).init();
  });
  document.querySelectorAll('.component--switcher').forEach(element => {
    console.log('switcher');
    new Switcher({selector: element}).init();
  });
});
