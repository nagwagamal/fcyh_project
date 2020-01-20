  document.querySelectorAll('.product').forEach(element => {
	activeAllTil(element.querySelectorAll('.product__rating__star'), element.querySelector('.product__rating__star.active'));
  });
  document.querySelectorAll('.component--main-slider').forEach(element => {
	new MainSlider({selector: element}).init();
  });
  document.querySelectorAll('.component--switcher').forEach(element => {
	new Switcher({selector: element}).init();
  });
