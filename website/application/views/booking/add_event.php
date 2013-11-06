
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <script>
  $(function() {
    
    $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>

 <p class="specialP"> Add Event<?php //     echo $test;  ?></p>

    <table class="tableS"> 
            <tr>
                <td>

                    <?php
                    echo form_open('main/detailed_add_event');
                    echo form_label("Book the event as");
                    $all_user = array();
                    if($type == 1):
                        
                        foreach($book_as as $user):
                            $all_user["$user->id"] = "$user->login";
                        endforeach;
                        
                    else:
                       $all_user["$book_as->id"] = "$book_as->login";
                    endif;
                    echo form_dropdown('userid', $all_user);
                    
                    ?>
                </td>

                <td>
                    <?php
                    $all_rooms = array();
                    foreach ($rooms as $room):
                        $all_rooms["$room->id"] = "$room->name";
                    endforeach;
                    
                    echo form_label("Room");
                    echo form_dropdown('room_id', $all_rooms);
                    ?>
                    
                </td>
                
            </tr>
            <tr>
                <td colspan="2">

                    <?php
                    echo form_label('Title of the progam');
                    echo form_error('title');
                    echo form_input(array(
                        'name' => 'title',
                        'required' => 'required'
                    ));
                    ?>
                </td>
            </tr>
            <tr >
                <td>

                    <?php
                    
                    echo form_label('Starting time');
                    echo form_error('start_date');
                    echo form_input(array(
                        'id' => 'datepicker1',
                        'name' => 'start_date',
                        'placeholder' => 'Date',
                        'required' => 'required'
                    ));
                    ?>

                </td>
                
                <td>
                        
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

                    $style = 'style="width:45%;margin-right:5%;"';
                    $attributes = array(
                        'style' => 'width:45%;margin-right:4%;'
                    );

                    echo form_label("Hour", "s_hour", $attributes);
                    echo form_label("Minute", "s_minute", $attributes);
                    echo form_dropdown("start_hour", $hours, '', $style);

                    
                    echo form_dropdown("start_minute", $minute, '', $style);
                    ?>
                    
                </td>
                
            </tr>
            
            <tr>
                <td>

                    <?php
                    
                    echo form_label('Finishing time');
                    echo form_error('finish_date');
                    echo form_input(array(
                        'id' => 'datepicker2',
                        'name' => 'finish_date',
                        'placeholder' => 'Date',
                        'required' => 'required'
                    ));
                    ?>

                </td>

                <td>

                    <?php
                    echo form_label("Hour", "s_hour", $attributes);
                    echo form_label("Minute", "s_minute", $attributes);
                    echo form_dropdown("finish_hour", $hours, '', $style);
                    echo form_dropdown("finish_minute", $minute, '', $style);
                    ?>

                </td>
                
            </tr>
            <tr>
                <td>
                    <?php 
                   
                    echo form_submit("submit", "Save", 'style="float:right;"');
                    echo form_close();
                    ?>
                </td>
            </tr>
            
 </table>