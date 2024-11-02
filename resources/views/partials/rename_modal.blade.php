<div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameModalLabel">Rename Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="renameForm" action="{{ route('renameItem') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="renameItemId">
                    <input type="hidden" name="type" id="renameItemType">
                    <div class="mb-3">
                        <label for="newName" class="form-label">New Name</label>
                        <input type="text" class="form-control" id="newName" name="new_name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="renameForm" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.rename-icon').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            const itemId = $(this).data('id');
            const itemType = $(this).data('type');
            const itemName = $(this).closest('tr').find('td a').text().trim();
            
            $('#renameItemId').val(itemId);
            $('#renameItemType').val(itemType);
            $('#newName').val(itemName);

            $('#renameModal').modal('show');
        });
    });
</script>
