<script src='<?= base_url() ?>fullcalendar/lib/jquery.min.js'></script>
<script src='<?= base_url() ?>fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script src='<?= base_url() ?>fullcalendar/fullcalendar.min.js'></script>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        allDayDefault: false,
        //weekends: false,

        height: $(window).height() - 60,

        events: '<?= base_url() ?>main/get_events',

        eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {
            event.dayDelta = dayDelta;
            event.minuteDelta = minuteDelta;
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/move_event";

            $.ajax({
                url: url,
                data: args,
                type: 'POST'
            });
        },

        eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
            event.dayDelta = dayDelta;
            event.minuteDelta = minuteDelta;
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/resize_event";

            $.ajax({
                url: url,
                    data: args,
                    type: 'POST'
            });
        }
    });
});


</script>
