<script src='<?= base_url() ?>fullcalendar/lib/jquery.min.js'></script>
<script src='<?= base_url() ?>fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script src='<?= base_url() ?>fullcalendar/fullcalendar.min.js'></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
    $(function() {
    });
</script>

<script>
$(document).ready(function() {
    var booking_title = "";

    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        allDayDefault: false,
        firstHour: 9,
        //weekends: false,

        height: $(window).height() - 60,

        events: '<?= base_url() ?>main/get_events',

        eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {
            event.day_delta = dayDelta;
            event.minute_delta = minuteDelta;
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/move_event";

            $.ajax({
                url: url,
                data: args,
                type: 'POST'
            });
        },

        eventResize: function(event, dayDelta, minuteDelta, revertFunc) {
            event.day_delta = dayDelta;
            event.minute_delta = minuteDelta;
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/resize_event";

            $.ajax({
                url: url,
                    data: args,
                    type: 'POST'
            });
        },

        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
            $( "#new-booking" ).dialog( "open" );
            $( "#new-booking" ).on( "dialogclose" , function(event, ui) {
                if (booking_title) {
                    var booking = {
                        title: booking_title,
                        start: start,
                        end: end,
                        allDay: allDay
                    };

                    args = "json=" + JSON.stringify(booking);
                    url = "<?= base_url() ?>main/add_event";

                    $.ajax({
                        url: url,
                        data: args,
                        type: 'POST'
                    });

                    booking_title = "";
                    booking = null;
                    calendar.fullCalendar('refetchEvents');
                }
            });
            calendar.fullCalendar('unselect');
        }
    });

    allFields = $( [] ).add( title );
    $( "#new-booking" ).dialog({
        autoOpen: false,
        height: "auto",
        width: "auto",
        buttons: {
            "Add": function() {
                booking_title = $("#title").val();
                $( this ).dialog( "close" );
            }
        },
        close: function() {
            allFields.val("");
        }
    });

    $( "#target" ).submit(function (e) {
        $( "#new-booking button" ).click();
        return false;
    });
});


</script>
