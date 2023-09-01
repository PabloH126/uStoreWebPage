const input1 = document.getElementById('fileInput1');
const input2 = document.getElementById('fileInput2');
const input3 = document.getElementById('fileInput3');
const input4 = document.getElementById('fileInput4');
const content = document.getElementById('imageP');
const content4 = document.getElementById('content-4');
const content5 = document.getElementById('content-5');
const contentPP = document.getElementById('contentPP');

input1.addEventListener('input', showInput4);
input1.addEventListener('input', showInput5);
input2.addEventListener('input', showInput4);
input2.addEventListener('input', showInput5);
input3.addEventListener('input', showInput4);
input3.addEventListener('input', showInput5);
input4.addEventListener('input', showInput5);

function showInput4() {
    if (input1.value.trim() && input2.value.trim() && input3.value.trim()) {
        content.style.gridTemplateColumns = 'repeat(4, 1fr)';
        contentPP.style.width = '75%';
        content4.style.display = 'block';
    } else {
        content4.style.display = 'none';
    }
}

function showInput5() {
    if (input4.value.trim()) {
        content.style.gridTemplateColumns = 'repeat(5, 1fr)';
        contentPP.style.width = '60%';
        content5.style.display = 'block';
    } else {
        content5.style.display = 'none';
    }
}