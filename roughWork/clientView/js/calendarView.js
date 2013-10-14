/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    var cal = $('#calendar');
    // page is now ready, initialize the calendar...
    cal.fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: ''
            
        },  
        height: 800
    });
    
    
 
    $('.button').click(function() {
        $("#views").find("button").attr('disabled', false);
        $(this).attr('disabled' ,true);
        var view = $(this).attr("id");  
          
        
        console.log(view);
        if (view === "basicWeek" || view === "month") {
            $('#calendar').fullCalendar('changeView', view);
            
        }
        ;


    });

    $('#next').click(function() {

        $('#calendar').fullCalendar('next');

    });

    $('#prev').click(function() {

        $('#calendar').fullCalendar('prev');

    });

    var listMonth = ["January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "Decemeber"];


    var date = $("#calendar").fullCalendar('getDate');
    

     
    populateMonth(listMonth, date.getMonth());

    




    $("#monthsSli").selectToUISlider({
        labels:12,
        
        sliderOptions: {
            stop:
                    function(e, ui) {
                        var value = $("#monthsSli").val();
                        value = listMonth.indexOf(value);
                        cal.fullCalendar('gotoDate', '2013', value);
                    }
        }
    });




});


function populateMonth(listMonth, month) {

    var option = "";
    $("#monthsSli").html(option);
    for (var i = 0; i < listMonth.length; i++) {
        if (month === i){
            option += "<option value=" + listMonth[i] + " " +"selected=selected" + ">" + listMonth[i] + "</options>";
        }
        else{
            option += "<option value=" + listMonth[i] + ">" + listMonth[i] + "</options>";
        }
    }

    $("#monthsSli").html(option);


}
;