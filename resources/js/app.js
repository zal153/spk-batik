import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.Swal = Swal;

window.confirmDelete = function(formId, message = 'Apakah Anda yakin ingin menghapus data ini?') {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626', // bg-red-600 color
        cancelButtonColor: '#4f46e5', // bg-indigo-600 color
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
};

Alpine.start();
