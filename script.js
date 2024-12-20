let selectedFile = null;
let selectedFilePath = null;

function loadFileContent(path, event) {
    event.preventDefault();
    event.stopPropagation();

    if (selectedFile) {
        selectedFile.classList.remove('selected');
    }

    selectedFile = event.currentTarget;
    selectedFile.classList.add('selected');

    selectedFilePath = path;

    document.getElementById('open-in-new-tab-button').style.display = 'block';

    const fileContentDiv = document.getElementById('file-content');
    const fileExtension = path.split('.').pop().toLowerCase();
    const imageExtensions = ['ico', 'jpg', 'jpeg', 'png', 'gif', 'bmp'];

    if (imageExtensions.includes(fileExtension)) {
        fileContentDiv.innerHTML = `<img class="image-preview" src="${path}" alt="Image Preview">`;
    } else {
        fetch(path)
            .then(response => response.text())
            .then(data => {
                fileContentDiv.textContent = data;
            })
            .catch(error => {
                fileContentDiv.textContent = 'Error loading file: ' + error;
            });
    }
}


function openInNewTab() {
    if (selectedFilePath) {
        window.open(selectedFilePath, '_blank');
    }
}

function toggleFolder(event) {
    event.stopPropagation();
    const children = event.currentTarget.querySelector('ul');
    if (children) {
        children.classList.toggle('hidden');
    }
}

function toggleAllFolders() {
    const folders = document.querySelectorAll('.folder > ul');
    folders.forEach(folder => {
        folder.classList.toggle('hidden');
    });
}

function clearSelection() {
    if (selectedFile) {
        selectedFile.classList.remove('selected');
        selectedFile = null;
    }

    selectedFilePath = null;
    document.getElementById('file-content').textContent = 'Click on a file to view its contents.';
    document.getElementById('open-in-new-tab-button').style.display = 'none';
}
