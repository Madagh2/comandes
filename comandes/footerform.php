    <script>
      $(document).ready(function(){
        $('select').formSelect();
        M.updateTextFields();
        $('.datepicker').datepicker({
          firstDay: 1,
          yearRange: 2,
          format: 'dd/mm/yyyy',
        });
      });
      //$('#mySwitch').prop('checked');
    </script>
