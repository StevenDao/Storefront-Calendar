<script src='<?= base_url() ?>fullcalendar/lib/jquery.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>
<script src='<?= base_url() ?>fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script src='<?= base_url() ?>fullcalendar/fullcalendar.min.js'></script>


<script>
    $(function() {
    });
</script>

<script>
$(document).ready(function() {
    var booking_title = "";
    var page = $('#lower_limit').val();
    var view = $('#view').val();
    
    if(view != 'resourceDay'){
        $('#nextRooms').hide();
    }

    $("#month").click(function(e){
        $('#calendar').fullCalendar( 'changeView', 'month' );
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
        $('#nextRooms').hide();
    });  

    $("#week").click(function(e){
        $('#calendar').fullCalendar( 'changeView', 'agendaWeek' );
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
        $('#nextRooms').hide();
    });  

    $("#day").click(function(e){
        $('#calendar').fullCalendar( 'changeView', 'resourceDay' );
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
        $('#nextRooms').show();
    });

    $("#today").click(function(e){
        var d = new Date();

        var month = d.getMonth();
        var day = d.getDate();
        var year = d.getFullYear();

        $('#calendar').fullCalendar( 'gotoDate', year, month, day );
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
        $('#nextRooms').hide();
    });

    $('#nextCal').click(function(e){
        $('#calendar').fullCalendar('next');
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
    });

    $('#prevCal').click(function(e){
        $('#calendar').fullCalendar('prev');
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
    });

    var calendar = $('#calendar').fullCalendar({
        header: {
            left: '',
            center: '',
            right: ''
        },
        editable: true,
        allDayDefault: false,
        firstHour: 9,
        //weekends: false,

        height: $(window).height() - 150,

        events: '<?= base_url() ?>main/get_events',
        resources: '<?= base_url() ?>main/get_rooms/'+page,

        
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
		
		eventClick: function(event, jsEnvent, view){
			args= "json=" + JSON.stringify(event);
			ar = event.id;
			url = "<?= base_url()?>main/cal_edit_event/"+ ar;
			window.open(url);
		
			return;			
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

     $('#calendar').fullCalendar( 'changeView', view );
    

    var view = $('#calendar').fullCalendar( 'getView');
    $('#pageTitle').html(view.title);


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
