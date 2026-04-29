document.addEventListener('DOMContentLoaded', function() {
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
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                inputFile.files = e.dataTransfer.files;
                updateFilename(e.dataTransfer.files[0]);
            }
        });

        inputFile.addEventListener('change', () => {
            if (inputFile.files.length) {
                updateFilename(inputFile.files[0]);
            }
        });
    }

    initDropZone('drop-zone-er', 'archivo-er', 'filename-er');
    initDropZone('drop-zone-ventas', 'archivo-ventas', 'filename-ventas');
    initDropZone('drop-zone-pdf', 'archivo-pdf', 'filename-pdf');
});