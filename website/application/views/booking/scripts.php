<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?= base_url() ?>js/jquery.timepicker.min.js"></script>

<script>

$(function() {
	$( "#start_picker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#end_picker" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( "#start_time" ).timepicker({ 'timeFormat': 'H:i:s' });
	$( "#end_time" ).timepicker({ 'timeFormat': 'H:i:s' });
});

</script>
