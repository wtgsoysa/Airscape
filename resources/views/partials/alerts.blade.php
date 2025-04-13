{{-- resources/views/partials/alerts.blade.php --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#007872'
    });
</script>
@endif
