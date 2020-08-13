
const hamIcon = document.querySelector('.ham-icon');
const dropdownMenu = document.querySelector('.dropdown-menu');
const openDropdown = () => {
  dropdownMenu.classList.toggle('active');
  hamIcon.classList.toggle('active');
};

hamIcon.addEventListener('click', openDropdown, false);
