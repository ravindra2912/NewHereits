	 </div>
	 <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="https://hereits.com" target="_blank">Hereits</a>.</strong> All rights reserved.
  </footer>
	
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- script src="<?php echo base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script -->
<!-- jQuery UI 1.11.4 -->
<!-- script src="<?php echo base_url(); ?>assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script -->
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- bootstrap color picker -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/adminlte.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/demo.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

<?php 
if(isset($footer_import) != null){
	echo $footer_import;
}
?>
<!-- alertify -->
<script src="<?php echo base_url(); ?>assets/admin/alertify/lib/alertify.min.js"></script>
<script>
<?php if($this->session->flashdata('success')){?>
      alertify.success("<?php echo $this->session->flashdata('success'); ?>");
<?php } ?>

</script>
<!-- Spiner -->
<script>
	document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'interactive') {
       document.getElementById('contents').style.visibility="hidden";
  } else if (state == 'complete') {
      setTimeout(function(){
         document.getElementById('interactive');
         document.getElementById('load').style.visibility="hidden";
         document.getElementById('contents').style.visibility="visible";
      },1000);
  }
}

$(".onclick-load").click(function(){
	document.getElementById("load").style.visibility = "unset"; 
}); 
</script>

<script>
  $(function () {
    //Initialize Select2 Elements 
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

	//Timepicker for store timing page
    $('#start_time').datetimepicker({
      format: 'HH:mm',
	  ignoreReadonly: true
    })
    $('#end_time').datetimepicker({
      format: 'HH:mm',
	  ignoreReadonly: true
    })
	$('#start_time1').datetimepicker({
      format: 'HH:mm',
	  ignoreReadonly: true
    })
    $('#end_time1').datetimepicker({
      format: 'HH:mm',
	  ignoreReadonly: true
    })
    
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    
    
    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>




</body>
</html>
