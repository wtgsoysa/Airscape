
<?php if(session('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '<?php echo e(session('success')); ?>',
        confirmButtonColor: '#007872'
    });
</script>
<?php endif; ?>
<?php /**PATH F:\University\SDTP\Airscape\resources\views/partials/alerts.blade.php ENDPATH**/ ?>