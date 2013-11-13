<script src='<?= base_url() ?>fullcalendar/lib/jquery.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.qtip.js"></script>
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
    var given_date =  $("[name='date']").val().split(" ");

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
        //$('#nextRooms').show();
    });

    $("#today").click(function(e){
        var d = new Date();

        var month = d.getMonth();
        var day = d.getDate();
        var year = d.getFullYear();

        $('#calendar').fullCalendar( 'gotoDate', year, month, day );
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);

    });

    $('#nextCal').click(function(e){
        
        $('#calendar').fullCalendar('next');
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
        $("[name='date']").val($.datepicker.formatDate('dd mm yy', view.start));

        
    });

    $('#prevCal').click(function(e){
        $('#calendar').fullCalendar('prev');
        var view = $('#calendar').fullCalendar( 'getView');
        $('#pageTitle').html(view.title);
        $("[name='date']").val($.datepicker.formatDate('dd mm yy', view.start));
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
            $('#calendar').fullCalendar('refetchEvents');
            $('#calendar').fullCalendar( 'rerenderEvents' );
        },

        eventRender: function(event, element) {
            element.bind('dblclick', function() {
                    id = event.id;
                    url = "<?= base_url()?>main/change_booking/"+ id;
                    window.open(url);         
            });

            element.qtip({
                show: 'mouseover',
                hide: 'mouseout',
                content: event.description,
                position: {
        		my: 'top right',  // Position my top left...
        		at: 'top left', // at the bottom right of...
						 // my target
    		}
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
            $('#calendar').fullCalendar('refetchEvents');
            $('#calendar').fullCalendar('rerenderEvents');
        },
		
		eventClick: function(event, jsEnvent, view){
            $("*").qtip("remove");
            args = "json=" + JSON.stringify(event);
            url = "<?= base_url() ?>main/confirm_event";

            $.ajax({
                url: url,
                    data: args,
                    type: 'POST'
            });
            
            $('#calendar').fullCalendar('refetchEvents');


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
                    calendar.fullCalendar( 'rerenderEvents' );
                }
            });
            calendar.fullCalendar('unselect');
        }
    });

     $('#calendar').fullCalendar( 'changeView', view );
      $('#calendar').fullCalendar( 'gotoDate',  parseInt(given_date[2]),  parseInt(given_date[1])-1,  parseInt(given_date[0]) );
    
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
