<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> Quiz Start </title>

        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       
  <style >
        
    body {
        background-color: #f9f5f5 !important;
        font-family: "Roboto Condensed", Sans-serif !important;
    }

    .quiz_start{ padding-top:2%;padding-bottom:2%;}
        .q-card {
        width: 70%;
        margin: auto;
        padding: 20px 40px 40px 40px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: inset 0px 0px 15px 0px #dcd5d5;
    }

    .quest_img img {
        width: 100%;
    }
    h1, .h1, h2, .h2, h3, .h3 {
        margin-top: 11px;
        margin-bottom: 11px;}
    .q-heding {
        background-color: #bc0808;
        padding: 1px 0px 2px 20px;
        color: white;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    .quest_img span {
        font-size: 30px;
        font-weight: 500;
    }
    button .myform1 {padding: 20px;}
    .options{
        position: relative;
        padding-left: 30px;
    }
    #options label{
        display: inline;
        font-size: 20px;
        cursor: pointer;}
    .options input{
        opacity: 0;
    }
    .checkmark {
        position: absolute;
        top: 2px;
        left: 0;
        height: 20px;
        width: 20px;
        border: 2px solid #bc0808;
        border-radius: 50%;
    }
    .options input:checked ~ .checkmark:after {
        display: block;
    }
    .options .checkmark:after{
        content: "";
      width: 10px;
        height: 10px;
        display: block;
      background: white;
        position: absolute;
        top: 50%;
      left: 50%;
        border-radius: 50%;
        transform: translate(-50%,-50%) scale(0);
        transition: 300ms ease-in-out 0s;
    }
    .options input[type="radio"]:checked ~ .checkmark{
        background: #21bf73;
        transition: 300ms ease-in-out 0s;
    }
    .options input[type="radio"]:checked ~ .checkmark:after{
        transform: translate(-50%,-50%) scale(1);
    }
    .btn-wave, button.btn-wave {
        padding: 10px 50px 10px 50px;
        margin-top: 15px;
    }
    .timer{margin-top:20px;}
    .timer h4{float:right;
      margin-right: 20px;
    }
    .timer span {
        padding: 10px;
        background-color: white;
        color: #bc0808;
        border-radius: 8px;
        margin-left: 10px;
    }

   

    



    @media(max-width:576px){
        .q-card{
            width: 100% !important;
            word-spacing: 2px;
            padding: 10px 25px 25px 25px;
        } 
        .q-heding h3{font-size:16px}
        .q-heding h4{font-size:12px;}
        .timer {
            margin-top: 1px;
            margin-bottom: 10px;
        }
        .timer span {
            padding: 6px !important;
            border-radius: 8px !important;
            font-size: 12px !important;
        }
        .q-heding {
            padding: 0px;}
            .timer h4 {
            margin-right: 0px;
        }
        #options label {
        line-height: 22px;
        font-size: 14px;

        }
        .checkmark {
        top: -1px;
        height: 18px;
        width: 18px;
        }
        .options {
            padding-left: 24px;
        }
        .quest_img span {
        font-size: 20px;
        }
        .sub {
        padding: 3px !important;
        font-size: 14px !important;
        }
    }
    
    @media(max-width:768px){
        .quest_img span {
            font-size: 20px;
        }
        .sub {
        padding: 3px !important;
        font-size: 14px !important;
        }

    }
  </style>
  </head>
    
<body>
<section class="quiz_start">
    <div class="container">
          <div class="q-card">
            <div class="q-heding row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <h3>Question Details</h3>
              <h4> Total Questions: <span style="font-weight: 600;"> 1 / 10</span></h4>
              </div>
             
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 timer">
              <h4> Time:  <span id="counter" class="countdown"></span></h4>
              </div>
              
            </div>

            <div id="question_div">
                @include('quiz.question.question')
            </div>
            
          </div>
    </div>
</section>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>

function countdown() 
{
    var value='{{$topic['timer']*60}}'
    var timer2 = Math.floor(value / 60) + ":" + (value % 60 ? value % 60 : '00');
    var interval = setInterval(function() 
    {
        var timer = timer2.split(':');
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;

        if(minutes == 0 && seconds == 0)
        {
            return false;
        }
        else
        {
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            $('.countdown').html(minutes + ':' + seconds);
            timer2 = minutes + ':' + seconds;
        }
    }, 1000);
}
    countdown();
  </script>
</html>