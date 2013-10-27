<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/reset.css" />
<link rel="stylesheet" href="<?= base_url() ?>fullcalendar/fullcalendar.css" />

<script src='<?= base_url() ?>fullcalendar/lib/jquery.min.js'></script>
<script src='<?= base_url() ?>fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script src='<?= base_url() ?>fullcalendar/fullcalendar.min.js'></script>

<link rel="stylesheet" href="<?= base_url() ?>css/clientPage.css" />
<!--<script src='<?= base_url() ?>js/calendarView.js'></script>-->
<script>
$(document).ready(function() {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        //weekends: false,

        height: $(window).height() - 60,

        events: '<?= base_url() ?>/main/get_events'
    });
});
</script>

</head>

<body>
  <header>
    <nav>
      <ul>
        <li>
          <a href="#" class="logo-link">
            Storefront Calendar<span id="logo-caret" class="icon"></span>
          </a>
          <ul>
            <li><a href="#">Add New User</a></li>
            <li><a href="#">Edit User</a></li>
            <li><a href="#">Add New Client</a></li>
            <li><a href="#">Edit Client</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <div id="calendar" style="z-index: -99999;" ></div>

</body>
</html>
