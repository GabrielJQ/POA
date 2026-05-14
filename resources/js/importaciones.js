document.addEventListener('DOMContentLoaded', function () {
    function initDropZone(dropZoneId, inputFileId, filenameId) {
        const dropZone = document.getElementById(dropZoneId);
        const inputFile = document.getElementById(inputFileId);
        const filename = document.getElementById(filenameId);

        if (!dropZone || !inputFile) return;

        function updateFilename(file) {
            if (!filename) return;
            const isPdf = file.name.toLowerCase().endsWith('.pdf');
            const icon = isPdf ? 'fa-file-pdf' : 'fa-file-excel';
            filename.innerHTML = `<i class="fas ${icon}"></i> ${file.name}`;
        }

        dropZone.addEventListener('click', () => inputFile.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                inputFile.files = e.dataTransfer.files;
                updateFilename(e.dataTransfer.files[0]);
            }
        });

        inputFile.addEventListener('change', (e) => {
            if (inputFile.files.length) {
                updateFilename(inputFile.files[0]);
            }
        });
    }

    initDropZone('zone-upload-er', 'archivo-er', 'filename-er');
    initDropZone('zone-upload-mermas', 'archivo-mermas', 'filename-mermas');
    initDropZone('zone-upload-ventas', 'archivo-ventas', 'filename-ventas');
    initDropZone('zone-upload-pdf', 'archivo-pdf', 'filename-pdf');
    initDropZone('zone-upload-surt', 'archivo-surtimiento', 'filename-surt');
    initDropZone('zone-upload-apertura', 'archivo-apertura', 'filename-apertura');
});