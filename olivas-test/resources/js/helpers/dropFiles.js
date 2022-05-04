// File upload observers variables
let filesDone = 0;
let filesToDo = 0;
let progressBar = qSelect('#progress-bar');
let filesArray = [];

window.fileImgData = null;

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}



const activeDropEvents = () => {
  let dropArea = qSelect('#drop-area');
  if (!dropArea) return;

  ['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false)
  });

  const highlight = e => {
    preventDefaults(e);
    dropArea.classList.add('highlight');
  }

  const unhighlight = e => {
    preventDefaults(e);
    dropArea.classList.remove('highlight');
  }

  // Handle drop
  dropArea.addEventListener('drop', handleDrop, false);
  const handleDrop = e => {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
  }

  // Convert FileList to array
  window.handleFiles = (files) => {
    let moreThanOneFile = files.length > 1;
    if (moreThanOneFile) return;
    // console.log(files);
    let isArray = Array.isArray(files);
    let newFiles = isArray ? files : Array.from(files);
    filesArray = newFiles;
    qSelect('#gallery').innerHTML = '';
    // initializeProgress(filesArray.length);
    filesArray.forEach(previewFile);
    filesArray.forEach(uploadFile);
  }

  const previewFile = file => {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = () => {
      let img = document.createElement('img');
      let imgName = file.name;
      img.setAttribute('data-img-name', imgName);
      img.src = reader.result;
      qSelect('#gallery').appendChild(img);
    }
  }

  qSelect('#gallery').addEventListener('click', e => {
    e.preventDefault();
    let targetElement = e.target;
    let isClickedImg = targetElement.hasAttribute('data-img-name');
    if (!isClickedImg) return;
    let clickedImgName = targetElement.getAttribute('data-img-name');

    let newFilesArray = filesArray.filter(file => file.name != clickedImgName);
    // console.log(newFilesArray);
    filesArray = newFilesArray;
    targetElement.remove();
    // console.log(filesArray);
    // handleFiles(newFilesArray)
  });
  // File upload observers

  const initializeProgress = (numFiles) => {
    progressBar.value = 0;
    filesDone = 0;
    filesToDo = numFiles;
  }

  const progressDone = () => {
    filesDone++;
    let progressPercentage = filesDone / filesToDo * 100;
    progressBar.value = progressPercentage;
  }

  function uploadFile(file) {
    // formData = new FormData();
    // formData.append('file', file);
    // console.log(formData.file);

    window.fileImgData = file;
  }

  // setInterval(() => console.log(formData), 10000);

}

activeDropEvents();

