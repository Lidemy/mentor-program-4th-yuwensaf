/* eslint-disable no-restricted-syntax */
/* eslint-disable no-undef */
/* eslint-disable max-len */
/* eslint-disable  */
// nav 的漢堡選單
const hamIcon = document.querySelector('.ham-icon');
const dropdownMenu = document.querySelector('.dropdown-menu');
const openDropdown = () => {
  dropdownMenu.classList.toggle('active');
  hamIcon.classList.toggle('active');
};

hamIcon.addEventListener('click', openDropdown, false);

// faq 的展開與收合
document.querySelector('.question-block').addEventListener('click', (e) => {
  const elements = document.querySelectorAll('.toggle-height');
  const target = e.target.closest('.toggle-height');
  const targetHeight = target.offsetHeight; // target 元素的目前高度

  // 跑 for 迴圈，先把「不是 target 且被展開的 faq」給收合
  for (element of elements) {
    if (element !== target && element.offsetHeight !== 80) { // 如果這個 element 不是 target，且 height 不是 80px（代表被展開了）
      element.style.height = '80px'; // 就把它收合
    }
  }

  // 最後，再針對點擊的那個 faq 去展開或收合
  if (targetHeight === 80) { // 如果 target 的高度是 80px
    target.style.height = target.scrollHeight + `px`; // 那就把它展開（scrollHeight 會把元素的 padding 和被隱藏內容的高度都算進去）
  } else { // 如果 target 的高度不是 80px
    target.style.height = '80px'; // 那就把它收合
  }
});
