const input1 = document.getElementById('fileInput1');
const input2 = document.getElementById('fileInput2');
const input3 = document.getElementById('fileInput3');
const input4 = document.getElementById('fileInput4');
const input5 = document.getElementById('fileInput5');
const content = document.getElementById('imageP');

input3.addEventListener('input', showInput4);
input4.addEventListener('input', showInput5);

console.log("ora aqui x2 c:");

function showInput4() {
    if (input3.value.trim() !== '') {
        content.style.gridTemplateColumns = 'repeat(4, 1fr)';
      input4.style.display = 'block';
      console.log("entro en el block c:");
    } else {
      input4.style.display = 'none';
      console.log("entro en el none");
    }
  }
  
  function showInput5() {
    if (input4.value.trim() !== '') {
      input5.style.display = 'block';
    } else {
      input5.style.display = 'none';
    }
  }