<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <style>
        body {
            background-color: #1F2833;

        }

        hr {
            background: #ccc;
            margin: 50px 0;
        }

        h2 {
            color: #f2f2f2;
            text-align: center;
        }

        /* css for calendar */
        .b-calendar {
            font: 14px/1.2 Arial, sans-serif;
            background: #f2f2f2;
        }

        .b-calendar--along {
            width: 300px;
            padding: 30px 40px;
            margin: 50px auto;
        }

        .b-calendar--many {
            padding: 20px;
            width: 250px;
            display: inline-block;
            vertical-align: top;
            margin: 0 40px 20px;
        }

        .b-calendar__title {
            text-align: center;
            margin: 0 0 20px;
        }

        .b-calendar__year {
            font-weight: bold;
            color: #333;
        }

        .b-calendar__tb {
            width: 100%;
        }

        .b-calendar__head {
            font: bold 14px/1.2 Arial, sans-serif;
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #c0c0c0;
        }

        .b-calendar__np {
            padding: 5px;
        }

        .b-calendar__day {
            font: 14px/1.2 Arial, sans-serif;
            padding: 8px 5px;
            text-align: left;
        }

        .b-calendar__weekend {
            color: red;
        }
    </style>
</head>

<body>

    <?php

    function draw_calendar($month, $year)  // $action = 'none'
    {
        $calendar = '<table cellpadding="0" cellspacing="0" class="b-calendar__tb">';

        // вывод дней недели 
        $headrows = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        // конкатенация строк штопаем таблицу
        $calendar .= '<tr class="b-calendar__row"> ';
        for ($head_day = 0; $head_day <= 6; $head_day++) {
            $calendar .= '<th class="b-calendar__head ';
            // выделяем выходные
            if ($head_day != 0) {
                // если 
                if ($head_day % 5 == 0 || $head_day % 6 == 0) {
                    $calendar .= ' b-calendar__weekend';
                }
            }
            $calendar .= '">';
            $calendar .= '<div class="b-calendar__number">' . $headrows[$head_day] . '</div>';
            $calendar .= '</th>';
        }
        $calendar .= '</tr>';

        // выставляем начало на понедельник
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $running_day = $running_day - 1;
        if ($running_day == -1) {
            $running_day = 6;
        }

        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $day_counter = 0;
        $days_in_week = 1;
        //$dates_array = array();

        //первая строка календаря
        $calendar .= '<tr class="b-calendar__row">';

        //вывод пустых ячеек
        for ($x = 0; $x < $running_day; $x++) {
            $calendar .= '<td class="b-calendar__np"></td>';
            $days_in_week++;
        }

        // дошли до чисел , будем их писать в первую строку
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
            $calendar .= '<td class="b-calendar__day';

            // выделяем выходные дни
            if ($running_day != 0) {
                if (($running_day % 5 == 0) || ($running_day % 6 == 0)) {
                    $calendar .= ' b-calendar__weekend';
                }
            }
            $calendar .= '>';


            // пишем номер в ячейку
            $calendar .= '<div class="b-calendar__number">' . $list_day . '</div>';
            $calendar .= '</td>';

            // дошли до последнего дня недели
            if ($running_day == 6) {
                // закрываем строку
                $calendar .= '</tr>';
                // если день не последний в месяце, начинаем следующую строку
                if (($day_counter + 1) != $days_in_month) {
                    $calendar .= '<tr class="b-calendar__row">';
                }
                // сбрасываем счетчики 
                $running_day = -1;
                $days_in_week = 0;
            }

            $days_in_week++;
            $running_day++;
            $day_counter++;
        }

        // выводим пустые ячейки в конце последней ячейки
        if ($days_in_week < 8) {
            for ($x = 1; $x <= (8 - $days_in_week); $x++) {
                $calendar .= '<td class="b-calendar__np"></td>';
            }
        }

        $calendar .= '</tr>';
        // закрываем таблицу
        $calendar .= '</table>';

        return $calendar;
    }

    ?>

    <h2>Календарь на месяц</h2>

    <div class="b-calendar b-calendar--along">
        <div class="b-calendar__title"><span class="b-calendar_month"> April </span><span class="b-calendar__year">
                2020</span>
            <?php
            echo draw_calendar(4, 2020);
            ?>
        </div>
    </div>

    <hr>

    <h2>Календарь на год</h2>

    <?php

    $months = array(
        0 => 'January',
        1 => 'February',
        2 => 'March',
        3 => 'April',
        4 => 'May',
        5 => 'June',
        6 => 'July',
        7 => 'August',
        8 => 'September',
        9 => 'October',
        10 => 'November',
        11 => 'December'

    );

    for ($month = 1; $month <= 12; $month++) { ?>
        <div class="b-calendar b-calendar--many">
            <div class="b-calendar__title"> <span class="b-calendar__month"> <?= $months[$month - 1] ?> </span> <span class="b-calendar__year"> 2020 </span></div>
            <?php
            echo draw_calendar($month, 2020);
            ?>
        </div>
    <? }

    ?>

</body>

</html>