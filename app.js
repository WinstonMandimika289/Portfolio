const navB = document.querySelector('#mobile-menu')
const nLinks = document.querySelector('.navMenu')


const mobileMenu = () => {

    navB.classList.toggle('is-active');
    nLinks.classList.toggle('active');
};

navB.addEventListener ('click', mobileMenu);


function myFunction() {
    var element = document.main;
    element.classList.toggle("dark-mode");
  }