/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    var cal = $('#calendar');

    cal.fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: ''

        },
       
        
        events: [{title  : 'moveableEvent',start  : '2013-10-01', editable:true},
                 {title  : 'coloredEvent',start  : '2013-10-05', end : '2010-01-07', color:"red"},
                 {title  : 'unmodifiedEvent',start  : '2013-10-09 12:30:00',allDay : false}],
           
        height: 800
    });

    var listMonth = ["January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "Decemeber"];

    var date = cal.fullCalendar('getDate');
    populateMonth(listMonth, date.getMonth());


    //For now month view and week views only
    $('.button').click(function() {
       
        $("#views").find("button").attr('disabled', false);
        $(this).attr('disabled', true);
        var view = $(this).attr("id");
        console.log(view);
        
        if (view === "agendaWeek" || view === "month") {
            console.log(view);
            cal.fullCalendar('changeView', view);
        };
    });

    //Next button
    $('#next').click(function() {
        cal.fullCalendar('next');
        sliders.val(listMonth [cal.fullCalendar('getDate').getMonth()]);
        sliders.trigger("click");
    });

    //[rev button
    $('#prev').click(function() {
        cal.fullCalendar('prev');
        sliders.val(listMonth [cal.fullCalendar('getDate').getMonth()]);
        sliders.trigger("click");
    });


    var sliders = $("#monthsSli").selectToUISlider({
        labels: 12,
        sliderOptions: {
            stop:
                    function() {
                        var year = $("#calendar").fullCalendar('getDate');
                        year = year.getFullYear();
                        var value = $("#monthsSli").val();

                        value = listMonth.indexOf(value);
                        cal.fullCalendar('gotoDate', year, value);
                            }
                        }
      });
});


function populateMonth(listMonth, month) {

    var option = "";
    $("#monthsSli").html(option);
    for (var i = 0; i < listMonth.length; i++) {
        if (month === i) {
            option += "<option value=" + listMonth[i] + " " + "selected=selected" + ">" + listMonth[i] + "</options>";
        }
        else {
            option += "<option value=" + listMonth[i] + ">" + listMonth[i] + "</options>";
        }
    }

    $("#monthsSli").html(option);


}
;