<!DOCTYPE html>
<html>
	<head>
<style>

.calendar {
    font-family: Verdana, Arial, Sans-serif;
    width: 100%;
    min-width: 960px;
    border-collapse: collapse;
    word-wrap: break-word;
}

.calendar tbody tr:first-child th {
    color: #505050;
    margin: 0 0 10px 0;
}

.day_header {
    font-weight: normal;
    text-align: center;
    color: #757575;
    font-size: 10px;
}

.calendar td {
    width: 14%; /* Force all cells to be about the same width regardless of content */
    border:1px solid #CCC;
    height: 100px;
    vertical-align: top;
    font-size: 10px;
    padding: 0;
}

.calendar td:hover {
    background: #F3F3F3;
}

.day_listing {
    display: block;
    text-align: right;
    font-size: 12px;
    color: #2C2C2C;
    padding: 5px 5px 0 0;
}

div.today {
    background: #E9EFF7;
    height: 100%;
} 

</style>
	</head>
<body>
	<h1>Welcome <?= $user->first ?>, you are now successfully logged in!</h1>

<?php
	$data = array(
               3  => 'SPRINT 1',
               7  => 'SPRINT 2',
               13 => 'SPRINT 3',
               26 => 'FINAL REVIEW IS DUE TODAY, MAKE SURE TO BLAH BLAH BLAH',
             );

	echo $this->calendar->generate('','',$data);
?>

</body>

</html>

