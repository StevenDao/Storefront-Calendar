<?php
/*
 * Initialization code used later.
 */
$colours = array(
	'red' => 'red',
	'blue' => 'blue',
	'green' => 'green'
);
?>

<table width="auto" class="outter">
	<tr>
		<td>
			<table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
				<?php  echo form_open('main/add_booking'); ?>
				<tr height="40px">
					<td colspan="2" class="formHeading">Add New Booking</td>
				</tr>
				<tr>
					<td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are compulsory fields
					</td>
				</tr>
				<tr height="10px">
					<td colspan="2"></td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Title</td>
					<td class="formSectionRight" width="68%">
						<input size="35" maxlength="50" class="input" type="text" name="title" required="required">
						<?php echo form_error('username'); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>From</td>
					<td class="formSectionRight" width="68%">
						<input id="start_picker" size="35" class="input date" type="text" name="from_date" required="required">
						<input id="start_time" size="35" class="input time" type="text" name="from_time" required="required">
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>To</td>
					<td class="formSectionRight" width="68%">
						<input id="end_picker" size="35" class="input date" type="text" name="to_date" required="required">
						<input id="end_time" size="35" class="input time" type="text" name="to_time" required="required">
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"></td>
					<td class="formSectionRight" width="68%">
						<input id="all_day" type="checkbox" name="all_day" value="all_day">All Day&nbsp;&nbsp;
						<input id="repeat" type="checkbox" name="repeat" value="repeat">Repeat...
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Room</td>
					<td class="formSectionRight" width="68%">
						<?php echo form_dropdown('rooms', $rooms); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Client</td>
					<td class="formSectionRight" width="68%">
						<?php echo form_dropdown('clients', $clients); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%">Description</td>
					<td class="formSectionRight" width="68%">
						<textarea class="input" rows="4" cols="50" type="text" name="description"></textarea>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%">Colour</td>
					<td class="formSectionRight" width="68%">
						<?php echo form_dropdown('colours', $colours); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%">Status</td>
					<td class="formSectionLast" width="68%">
						<input type="radio" name="status" value="tentative">Tentative&nbsp;&nbsp;
						<input type="radio" name="status" value="confirmed">Confirmed&nbsp;&nbsp;
						<input type="radio" name="status" value="rejected">Rejected
					</td>
				</tr>
				<tr>
					<td></td>
					<td height="30">
						<input value="Continue" class="btnbg" type="submit">&nbsp;&nbsp;
						<input value="Reset" class="btnbg" type="reset">&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<?php echo form_close();?>
			</table>
		</td>
	</tr>
</table>
