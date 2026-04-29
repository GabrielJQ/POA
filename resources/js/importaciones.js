document.addEventListener('DOMContentLoaded', function() {
    function initDropZone(dropZoneId, inputFileId, filenameId) {
        const dropZone = document.getElementById(dropZoneId);
        const inputFile = document.getElementById(inputFileId);
        const filename = document.getElementById(filenameId);

        if (!dropZone || !inputFile) return;

        dropZone.addEventListener('click', function() {
            inputFile.click();
        });

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', function() {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                inputFile.files = e.dataTransfer.files;
                if (filename) filename.innerHTML = '<i class="fas fa-file-excel"></i> ' + e.dataTransfer.files[0].name;
            }
        });

        inputFile.addEventListener('change', function() {
            if (inputFile.files.length && filename) {
                filename.innerHTML = '<i class="fas fa-file-excel"></i> ' + inputFile.files[0].name;
            }
        });
    }

    initDropZone('drop-zone-er', 'archivo-er', 'filename-er');
    initDropZone('drop-zone-ventas', 'archivo-ventas', 'filename-ventas');
});