'user strict';

const openPostBtn = document.getElementById('open_post_area');
const whiteCover = document.getElementById('white-cover');
const postArea = document.getElementById('post-area');
const closePostArea = document.querySelector('.fa-window-close');

function addHiddenClass(e){
  e.classList.add('hidden');
};

function removeHiddenClass(e){
  e.classList.remove('hidden');
};

openPostBtn.addEventListener('click', ()=>{
  removeHiddenClass(whiteCover);
  removeHiddenClass(postArea);
});

closePostArea.addEventListener('click', ()=>{
  addHiddenClass(whiteCover);
  addHiddenClass(postArea);
});

