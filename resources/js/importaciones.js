$(document).ready(function() {
    const dropZoneER = document.getElementById('drop-zone-er');
    const inputFileER = document.getElementById('archivo-er');
    const filenameER = document.getElementById('filename-er');

    if (dropZoneER && inputFileER) {
        dropZoneER.addEventListener('click', () => inputFileER.click());

        dropZoneER.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZoneER.classList.add('dragover');
        });

        dropZoneER.addEventListener('dragleave', () => {
            dropZoneER.classList.remove('dragover');
        });

        dropZoneER.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZoneER.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                inputFileER.files = e.dataTransfer.files;
                filenameER.innerHTML = '<i class="fas fa-file-excel"></i> ' + e.dataTransfer.files[0].name;
            }
        });

        inputFileER.addEventListener('change', () => {
            if (inputFileER.files.length) {
                filenameER.innerHTML = '<i class="fas fa-file-excel"></i> ' + inputFileER.files[0].name;
            }
        });
    }
});