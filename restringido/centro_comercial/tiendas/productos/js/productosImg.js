const input3 = document.getElementById('fileInput3');
const input4 = document.getElementById('fileInput4');
const content = document.getElementById('imageP');
const content4 = document.getElementById('content-4');
const content5 = document.getElementById('content-5');

input3.addEventListener('input', showInput4);
input4.addEventListener('input', showInput5);

console.log("ora aqui x3");

function showInput4() {
    if (input3.value.trim() !== '') {
        content.style.gridTemplateColumns = 'repeat(4, 1fr)';
        content4.style.display = 'block';
    } else {
        content4.style.display = 'none';
    }
  }
  
  function showInput5() {
    if (input4.value.trim() !== '') {
        content.style.gridTemplateColumns = 'repeat(5, 1fr)';
        content5.style.display = 'block';
    } else {
        content5.style.display = 'none';
    }
  }