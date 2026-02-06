@push('scripts')
<script>
document.addEventListener('click', function (e) {
    const tr = e.target.closest('tbody tr');
    if (!tr) return;

    // Ignore clicks on native interactive elements inside the row
    if (e.target.closest('a, button, input, select, textarea')) return;

    // Find the View action button we annotated with data-open-view
    const viewBtn = tr.querySelector('button[data-open-view], a[data-open-view]');
    if (viewBtn) {
        viewBtn.click();
    }
});
</script>
@endpush
