<<<<<<< HEAD

<html>
<title>Add Event</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/reset.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?= base_url() ?>css/newForm.css"/>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
$(function() {

    $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<table width="550px" class="outter">
    <tr>
        <td>
            <table class="text" border="0" cellpadding="4" cellspacing="3" width="100%">
                <tr height="40px">
                    <td colspan="2" class="formHeading">Add Event</td>
                </tr>
                <tr>
                    <td colspan="2" class="note" bgcolor="#383838">Field marked with <span style="color:#FF0000">*</span> are compulsory fields
                    </td>
                </tr>
                <tr height="10px">
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Client</td>
                    <td class="formSectionRight" width="68%">
                        <?php
                        echo form_open('main/detailed_add_event');
                        $all_user = array();
                        if($type == 1):
                            foreach($book_as as $user):
                                $all_user["$user->id"] = "$user->login";
                            endforeach;
                            else:
                             $all_user["$book_as->id"] = "$book_as->login";
                         endif;

                        $class = "class='input'";

                        echo form_dropdown('userid', $all_user, '', $class);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Room</td>
                    <td class="formSectionRight" width="68%">
                        <?php
                        $all_rooms = array();
                        foreach ($rooms as $room):
                            $all_rooms["$room->id"] = "$room->name";
                        endforeach;

                        $class = "class='input'";

                        echo form_dropdown('room_id', $all_rooms, '', $class);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Program Title</td>
                    <td class="formSectionRight" width="68%">
                        <?php echo form_error('title'); ?>
                        <input class="input" type="text" name="title" required="required">
                    </td>
                </tr>
                <tr>
                   <td class="formSectionLeft"><span style="color:#FF0000">*</span>Start Time</td>
                   <td class="formSectionRight" width="20%">
                        <span>
                            <small>
                                &nbsp;
                                Date
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;
                                Hour
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;
                                Minutes</small>
                        </span><br>
                        <?php
                        echo form_error('start_date');
                        echo form_input(array(
                            'id' => 'datepicker1',
                            'name' => 'start_date',
                            'placeholder' => 'Select Date',
                            'required' => 'required'
                            ));
                        ?>
                        <?php
                        $hours = array();
                        for ($x = 8; $x <= 17; $x++) {
                            $hours["$x"] = "$x";
                        }

                        $minute = array();
                        $minute["00"] = '00';
                        $minute["15"] = '15';
                        $minute["30"] = '30';
                        $minute["45"] = '45';

                        $style = 'style="width:15%;margin-right:0%;"';
                        $attributes = array(
                            'style' => 'width:45%;margin-right:4%;'
                            );
                        echo form_dropdown("start_hour", $hours, '', $style);
                        echo form_dropdown("start_minute", $minute, '', $style);
                        ?>
                    </td>
                </tr>
                    <td class="formSectionLeft"><span style="color:#FF0000">*</span>End Time</td>
                   <td class="formSectionRight" width="20%">
                        <span>
                            <small>
                                &nbsp;
                                Date
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;
                                Hour
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;
                                Minutes</small>
                        </span><br>
                        <?php
                        echo form_error('finish_date');
                        echo form_input(array(
                            'id' => 'datepicker2',
                            'name' => 'finish_date',
                            'placeholder' => 'Select Date',
                            'required' => 'required'
                            ));
                        ?>
                        <?php
                        echo form_dropdown("finish_hour", $hours, '', $style);
                        echo form_dropdown("finish_minute", $minute, '', $style);
                        ?>
                    </td>
                </tr>      
                <tr>
                    <td></td>
                    <td height="30">
                        <input value="Save" class="btnbg" type="submit">&nbsp;&nbsp;
                        <?php echo form_close();?>
                        <input value="Reset" class="btnbg" type="reset">&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<html>
=======
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
						<?php echo form_dropdown('room', $rooms); ?>
					</td>
				</tr>
				<tr>
					<td class="formSectionLeft" width="32%"><span style="color:#FF0000">*</span>Client</td>
					<td class="formSectionRight" width="68%">
						<?php echo form_dropdown('client', $clients); ?>
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
						<input type="radio" name="status" value="2">Tentative&nbsp;&nbsp;
						<input type="radio" name="status" value="1">Confirmed&nbsp;&nbsp;
						<input type="radio" name="status" value="3">Rejected
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
>>>>>>> feature/booking/edit
