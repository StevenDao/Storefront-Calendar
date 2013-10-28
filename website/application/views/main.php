<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" type='text/css' href="<?= base_url() ?>css/ui.slider.extras.css" />
        <link rel='stylesheet' type='text/css' href="<?= base_url() ?>js/fullcalendar-1.6.4/fullcalendar/fullcalendar.css" />

        <script src="<?= base_url() ?>js/fullcalendar-1.6.4/lib/jquery.min.js"></script>
        <script src="<?= base_url() ?>js/fullcalendar-1.6.4/lib/jquery-ui.custom.min.js"></script>
        <script src="<?= base_url() ?>js/fullcalendar-1.6.4/fullcalendar/fullcalendar.min.js"></script>

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/calendarView.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>/js/selectToUISlider.jQuery.js"></script>
        <script type='text/javascript' src="<?= base_url() ?>js/fullcalendar-1.6.4/fullcalendar/fullcalendar.js"></script>

        <link rel="stylesheet" href="<?= base_url() ?>css/clientPage.css" />
    </head>
    <body class="body">
        <div>

            <nav>
                <ul>
                    <li>
                        <button>
                            <input class="imageIcon" type="image" src="<?= base_url() ?>images/b_actions.png"/>

                            <ul>
                                <li><?= anchor('account/form_new_user', 'Create New User') ?></li>
                                <li><?= anchor('account/modifyuser', 'Modify User') ?></li>
                                <li><?= anchor('account/form_new_client', 'Create New Client') ?></li>
                                <li><?= anchor('account/modifyclient', 'Edit Client') ?></li>
                                <li><a href="#">Do..</a></li>
                            </ul>

                        </button>
                    </li>

                    <li class="special">
                        <h5 class="header">STOREFRONT CALENDER</h5>
                    </li>

                    <li style="float:right; margin-right:20px;">
                        <button>
                            <input class="imageIcon" type="image" src="<?= base_url() ?>images/b_actions.png"/>
                            <ul style="left:85%;">
                                <li><a href="#">Email</a></li>
                                <li><a href="#">User Experience</a></li>
                            </ul>
                        </button>
                    </li>
                </ul>
            </nav>


            <div id="views" class="views">

                <button id="days" class="button">Days</button>
                <button id="agendaWeek" class="button">Week</button>
                <button id="month" class="button">Month</button>
                <button id="rooms" class="button">Room</button>

            </div>

            <div class="calender">

                <button id="prev" style="z-index: 3;"></button>
                <button id="next"></button>
                <div id="calendar" ></div>

            </div>


            <div class="bottom">

                <select name="speed" id="monthsSli" style="display:none">
                    <option value="Slower">Slower</option>
                    <option value="Slow">Slow</option>
                    <option value="Med">Med</option>
                    <option value="Fast">Fast</option>
                    <option value="Faster">Faster</option>
                    </select>

            </div>

        </div>

    </body>
</html>


