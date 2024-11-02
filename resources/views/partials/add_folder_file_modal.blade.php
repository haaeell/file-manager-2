<!-- Modal Tambah Folder/File -->
<div class="modal fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFolderModalLabel">Tambah Folder atau File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFolderForm" action="{{ route('files.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="folder_id" value="{{ $folder_id ?? '' }}">
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe</label>
                        <select class="form-select" id="type" name="type">
                            <option value="folder">Folder</option>
                            <option value="file">File</option>
                        </select>
                    </div>
                    <div class="mb-3" id="folderInput">
                        <label for="name" class="form-label">Nama Folder</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3" id="fileInput" style="display:none;">
                        <label for="file" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="file" name="file">
                        <div id="filePreview" class="mt-2" style="display:none;">
                            <p><strong>Preview:</strong></p>
                            <img id="filePreviewImg" src="" alt="File Preview" class="img-thumbnail"
                                style="max-width: 100%; display:none;">
                            <iframe id="filePreviewPdf" src="" style="display:none; width: 100%; height: 300px;"
                                frameborder="0"></iframe>
                            <p id="fileInfo"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="addFolderForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#type').change(function() {
            if ($(this).val() === 'file') {
                $('#folderInput').hide();
                $('#fileInput').show();
            } else {
                $('#folderInput').show();
                $('#fileInput').hide();
            }
        });
    });
</script>
