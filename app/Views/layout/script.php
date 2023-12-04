<script src=<?= base_url('assets/sweetalert2/dist/sweetalert2.all.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>></script>
<script src=<?= base_url('assets/js/datatables-demo.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables/jquery.dataTables.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>>
</script>
<script src=<?= base_url('assets/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>>
</script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/jszip/jszip.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/pdfmake/pdfmake.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/pdfmake/vfs_fonts.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.html5.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.print.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.colVis.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>></script>
<script src=<?= base_url('assets/template/dist/js/adminlte.min.js') ?>></script>
<script src=<?= base_url('assets/config/config.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Flashdata.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Iduka.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Mentor.js') ?>></script>
<script src=<?= base_url('assets/yantodev/tp.js') ?>></script>
<script src=<?= base_url('assets/yantodev/Guru.js') ?>></script>
<script src=<?= base_url('assets/yantodev/users.js') ?>></script>
<script src=<?= base_url('assets/yantodev/student.js') ?>></script>
<script src=<?= base_url('assets/yantodev/print.js') ?>></script>
<script src=<?= base_url('assets/yantodev/master.js') ?>></script>
<script src=<?= base_url('assets/yantodev/teacher.js') ?>></script>
<script src=<?= base_url('assets/yantodev/nomor-surat.js') ?>></script>
<script src=<?= base_url('assets/yantodev/auth/logout.js') ?>></script>

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>