<div id="new-booking" title="Create new booking">
  <form id="target">
  <fieldset>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="text ui-widget-content ui-corner-all" />
  </fieldset>
  </form>
</div>

<div class="container">
	<button id="month">Month</button>
	<button id="week">Week</button>
	<button id="day">Day</button>
	
	<button id="prevCal" style="float:left;"><</button>
	<button id="nextCal" style="float:left;">></button>
	<button id="today" style="float:left;margin-left:10px;">Today</button>

	<p id='pageTitle' class='center'>jj</p>
</div>



<div id="calendar"></div>

<div id="nextRooms" class='container'>
<?php
	if (!isset($lower_limit)){
		$lower_limit = 1;
		$view = 'month';
	}
	else{	
		$view = 'resourceDay';
	}

	$hidden = array("$lower_limit" => $lower_limit);
	$prev_limit = $lower_limit - 12;

	if ($lower_limit < 24){
		echo form_open("main/next/$lower_limit");
		echo form_submit("Next", " >>");
		echo form_close();
	}

	if ($lower_limit > 1){
		echo form_open("main/next/$prev_limit");
		$js = "style=float:left;";
		echo form_submit("Prev", " <<", $js);
		echo form_close();
	}
?>
</div>
<input id="lower_limit" type="hidden" value="<?php echo $lower_limit ?>"></input>
<input id="view" type="hidden" value="<?php echo $view ?>"></input>
