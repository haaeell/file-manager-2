<!-- Modal Preview File -->
<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filePreviewModalLabel">Preview File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalFilePreviewImg" style="display:none;">
                    <img id="modalImage" src="" alt="File Preview" class="img-thumbnail"
                        style="max-width: 100%;">
                </div>
                <div id="modalFilePreviewPdf" style="display:none;">
                    <iframe id="modalPdf" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                </div>
                <p id="modalFileInfo"></p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#file').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const fileType = file.type;
                if (fileType.startsWith('image/')) {
                    $('#filePreviewImg').attr('src', e.target.result).show();
                    $('#filePreviewPdf').hide();
                } else if (fileType === 'application/pdf') {
                    $('#filePreviewPdf').attr('src', e.target.result).show();
                    $('#filePreviewImg').hide();
                } else {
                    $('#filePreviewImg').hide();
                    $('#filePreviewPdf').hide();
                }
                $('#fileInfo').text(
                    `Name: ${file.name}, Size: ${(file.size / 1024).toFixed(2)} KB`);
                $('#filePreview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#filePreview').hide();
        }
    });

    $('.file-row').on('click', function() {
        if (event.target.classList.contains('rename-icon')) {
            return;
        }
        const fileName = $(this).data('name');
        const fileSize = $(this).data('size');
        const fileType = $(this).data('type');
        const fileUrl = $(this).data('url');

        console.log(fileUrl);
        console.log(fileType);
        console.log(fileSize);
        console.log(fileName);

        $('#modalFileInfo').text(`Name: ${fileName}, Size: ${fileSize}`);

        if (fileType.startsWith('image/')) {
            $('#modalImage').attr('src', fileUrl);
            $('#modalFilePreviewImg').show();
            $('#modalPdf').hide();
            $('#modalFilePreviewPdf').hide();
            $('#filePreviewModal').modal('show');
        } else if (fileType === 'application/pdf') {
            $('#modalPdf').attr('src', fileUrl);
            $('#modalFilePreviewPdf').show();
            $('#modalImage').hide();
            $('#modalFilePreviewImg').hide();
            $('#filePreviewModal').modal('show');
        } else {
            const a = document.createElement('a');
            a.href = fileUrl;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    });
</script>
