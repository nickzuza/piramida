<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use App\Http\Requests;

class DateController extends Controller
{    public static $days =  array('luni','marți','miercuri','joi','vineri','sîmbăta', 'duminică');
    public static $month = array(
        'en' => array( 1=>'january','february','march','april','may','june','july','august','september','october','november','december'),
        'ru' => array( 1=>'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря') ,
        'ro' => array( 1=>'ianuarie','februarie','martie','aprilie','mai','iunie','iulie','august','septembrie','octombrie','noiembrie','decembrie') ,

    );

    public static function getMonthText( $date ) {
        $time = strtotime( $date );
        $month = (int) date('m', $time );
        return self::$month[Lang::getLocale()][ $month ];
    }

    public static function getDateNews ($date ) {
        $time = strtotime( $date );
        $day = date('d', $time );
        $month = (int) date('m', $time );
        $year = date('Y', $time );
        return $day.'.'.$month.'.'.$year;
    }

    public static function getDateEmail($date){
        $time = strtotime( $date );
        $day = date('d', $time );
        $month = (int) date('m', $time );
        $year = date('Y', $time );

        return $day.' '.$month.' '.$year.' '.date('H', $time ).':'.date('i', $time ).':'.date('s', $time );
    }

    public static function getDateOrders ($date ) {
        $time = strtotime( $date );
        $day = date('d', $time );
        $month = (int) date('m', $time );
        $year = date('Y', $time );
        return $day.' '.self::$month[Lang::getLocale()][ $month ].' '.$year.' '.date('H', $time ).':'.date('i', $time ).':'.date('s', $time );
    }
    public static function getYear( $date ) {
        $time = strtotime( $date );
        $year = date('Y', $time );
        return $year ;
    }
    public static function getDay( $date ) {
        $time = strtotime( $date );
        $day = date('d', $time );
        return $day ;
    }

//    public static function getDate( $date ) {
//        $time = strtotime( $date );
//        $date = date('d', $time );
//        return $date ;
//    }

    public static function getDate($date){
        $time = strtotime( $date );
        $day = date('d', $time );
        $month = (int) date('m', $time );
        $year = date('Y', $time );
        return $day.' '.self::$month[Lang::getLocale()][ $month ].' '.$year;
    }

}