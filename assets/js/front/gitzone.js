function activeAllTil(elements, activeElement) {
  const activeIndex = [...elements].indexOf(activeElement);
  [...elements].forEach((element, index) => {
    if (index <= activeIndex) {
      element.classList.add('active')
    } else {
      element.classList.remove('active')
    }
  });
}

function getParents(element, parents) {
  parents.push(element);
  if (element.parentElement) {
    return getParents(element.parentElement, parents)
  } else {
    return parents;
  }
}

// window.addEventListener('click', function(event) {
//   const targetParents = getParents(event.target, []);
//   const target = targetParents.find((parent) => parent.classList.contains('product__rating__star'));
//   if(target) {
//     activeAllTil(target.parentElement.children, target);
//   }
// });

// $(function() {
// });
// $(window).on('load', function() {
// });
