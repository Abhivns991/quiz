@extends('layouts.app')

@section('head')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  
  <script>
    window.Laravel =  <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
  </script>
@endsection

@section('top_bar')
<nav class="navbar navbar-default navbar-static-top">
    <!-- <div class="logo-main-block">
      <div class="container">
        @if ($setting)
          <a href="{{ url('/') }}" title="{{$setting->welcome_txt}}">
            <img src="{{asset('/images/logo/'. $setting->logo)}}" class="img-responsive" alt="{{$setting->welcome_txt}}">
          </a>
        @endif
      </div>
    </div> -->
    <div class="nav-bar">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
            <div class="navbar-header">
              <!-- Branding Image -->
              @if($setting)
              <a href="{{ url('/') }}" title="{{$setting->welcome_txt}}">
                <img src="{{asset('/images/logo/logo1.jpg')}}" class="img-responsive w-50" alt="{{$setting->welcome_txt}}">
              </a>
                    <!-- <a class="tt" title="Quick Quiz Home" href="{{url('/')}}"><h4 class="heading">{{$setting->welcome_txt}}</h4></a> -->
              @endif
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                <li><a href="tel:9386806850" title="callus" class="call"><i class="fa fa-phone fa-lg" aria-hidden="true"></i> +91 9386806850</a></li>
                  <!-- <li><a href="{{ route('login') }}" title="Login">Login</a></li>
                  <li><a href="{{ route('site.signup') }}" title="Register">Register</a></li> -->
                @else
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    
                    <ul class="dropdown-menu" id="dropdown">
                      @if ($auth->role == 'A')
                        <li><a href="{{url('/admin')}}" title="Dashboard">Dashboard</a></li>
                      @elseif ($auth->role == 'S')
                        <li><a href="{{url('/admin/my_reports')}}" title="Dashboard">Dashboard</a></li>
                      @endif
                      <li>
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                      </form>
                      </li>
                    </ul>
                  </li>
                 
                  <li><a href="{{ route('faq.get') }}">FAQ</a></li>
                @endguest
                  @if(!empty($menus))
                    @foreach($menus as $menu)
                      <li><a href="{{ url('pages/'.$menu->slug) }}">{{$menu->name}}</a></li>
                    @endforeach
                  @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('content')
  @if ($auth)
<div class="container">
    <div class="quiz-main-block">
      <div class="row">
        @if ($topics)
          @foreach ($topics as $topic)
            <div class="col-lg-4 col-md-4 col-sm-6">
              <div class="topic-block">
                <div class="card blue-grey darken-1">
                  <div class="card-content white-text">
                    <span class="card-title">{{$topic->title}}</span>
                    <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                    <div class="row">
                      <div class="col-xs-6 pad-0">
                        <ul class="topic-detail">
                          <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                          <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                          <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                          <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
                          <li>Quiz Price <i class="fa fa-long-arrow-right"></i></li>
                        </ul>
                      </div>
                      <div class="col-xs-6">
                        <ul class="topic-detail right">
                          <li>{{$topic->per_q_mark}}</li>
                          <li>
                            @php
                                $qu_count = 0;
                            @endphp
                            @foreach($questions as $question)
                              @if($question->topic_id == $topic->id)
                                @php 
                                  $qu_count++;
                                @endphp
                              @endif
                            @endforeach
                            {{$topic->per_q_mark*$qu_count}}
                          </li>
                          <li>
                            {{$qu_count}}
                          </li>
                          <li>
                            {{$topic->timer}} minutes
                          </li>

                          <li class="amount">
                            @if(!empty($topic->amount))
                            {{-- <i class="{{$setting->currency_symbol}}"></i> {{$topic->amount}}   --}}
                             @else
                               Free
                            @endif
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>


               <div class="card-action text-center">
                  
                  @if (Session::has('added'))
                    <div class="alert alert-success sessionmodal">
                      {{session('added')}}
                    </div>
                  @elseif (Session::has('updated'))
                    <div class="alert alert-info sessionmodal">
                      {{session('updated')}}
                    </div>
                  @elseif (Session::has('deleted'))
                    <div class="alert alert-danger sessionmodal">
                      {{session('deleted')}}
                    </div>
                  @endif

                    @if($auth->topic()->where('topic_id', $topic->id)->exists())
                      <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>
                    @else
                      {!! Form::open(['method' => 'POST', 'action' => 'PaypalController@paypal_post']) !!} 
                        {{ csrf_field() }}
                        <input type="hidden" name="topic_id" value="{{$topic->id}}"/>
                         @if(!empty($topic->amount)) 

                        <button type="submit" class="btn btn-default">Pay  <i class="{{$setting->currency_symbol}}"></i>{{$topic->amount}}</button>
                          @else 

                          <a href="{{route('start.quiz.index', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>

                        @endif

                      {!! Form::close() !!}
                    @endif
                  </div>


                {{--   <div class="card-action">
                    @php 
                      $a = false;
                      $que_count = $topic->question->count();
                      $ans = $auth->answers;
                      $ans_count = $ans ? $ans->where('topic_id', $topic->id)->count() : null;
                      if($que_count && $ans_count && $que_count == $ans_count){
                        $a = true;
                      }
                    @endphp
                    <a href="{{$a ? url('start_quiz/'.$topic->id.'/finish') : route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz
                    </a>
                  </div> --}}
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
</div>
  @endif
  @if (!$auth)
    <div class="container-fluid"  style="background: url({{asset('/images/b_bg2.png')}});background-size: cover; background-position: bottom; background-repeat: no-repeat; position: relative; width: 100%; padding-top: 10px; padding-bottom: 100px;">
      <div class="container">
    <div class="row banner">
          <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 banner-detail">
            <h5>देश के इतिहास का सबसे बड़ी परीक्षा NEET / AIIMS की तैयारी के लिए</h5>
            <img src="{{asset('/images/IMA_logo.png')}}" class="ban-img">
            <h3>Presents</h3>
            <img src="{{asset('/images/b_30.png')}}" class="ban-img1">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12"> 
                <img src="{{asset('/images/01icon.png')}}" class="icon-img1">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                 <img src="{{asset('/images/02icon.png')}}" class="icon-img1">
                </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                 <img src="{{asset('/images/03icon.png')}}" class="icon-img1">
                </div>
            </div>

           
          </div>

          <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
            <div class="login-page"  style="margin:auto;">
                <h3 class="user-register-heading text-center">Login / Register</h3>
                <form class="form login-form" method="POST" action="{{ route('site.signup') }}">
                  {{ csrf_field() }}
              
                  <div class="form-group">
                    <label for="name">ENTER MOBILE No.</label> 
                    <input id="number" type="text" class="form-control" name="mobile"  maxlength="10" pattern="[0-9]{10}"  placeholder="Enter Your Mobile Number" required>
                    </div>
                
                  <div class="mr-t-20">
                    <button type="submit" class="btn btn-wave">Send Otp</button>       
                  </div>
                </form>
                   <br>
                <!-- <div class="text-center"> <span class="mob"> Already Registered?</span>   <a href="#" title="Login now" class="mob-a" >Login now</a> </div> -->
                
            </div>

          </div>
      </div>
    </div>
    </div>
    
      
    <section class="container section2">
      <div class="row">
        <div class="col-lg-12">
            <div class="cntbr">
              <h2>BRILLIANT-30 Test Schedule </h2>
              <h6>Eligibility Criteria</h6>
              <p>The Applicant must be appearing/passed in class X <sup>th</sup> board exam 2022.</p>
              <h1><u>Exam Methodology</u></h1>
              <div class="row ">
                <div class="col-lg-4 col-md-4 col-sm-12">
                <p class="clr-round">1<sup>th</sup> Round <i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> PT (Online)</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                <p class="clr-round">2<sup>nd</sup> Round <i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Mains (Offline)</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                <p class="clr-round">Final Round <i class="fa fa-caret-right fa-lg" aria-hidden="true"></i> Interview (Offline)</p>
                </div>
              </div>

              <div class="row ">
                <div class="col-lg-12">
                <h4 class="h4-title">
                  <span class="count"> 01</span>
                           PT Exam (Online Mode)
                </h4>
                <div class="panel-body">
                          <p>Any time... Any where... (Through a link,QR Code or website)</p>
                          <h4>Result: On spot results</h4>
                          <div class="row exm-card">
                            <div class="col-lg-4 col-md-4 col-sm-12"><a href="https://brilliantpatna.com" target="blank">www.ima.brilliantpatna.com</a><br>
                          <h5>Link</h5></div>
                            <div class="col-lg-4 col-md-4 col-sm-12"> <img src="{{asset('/images/qrlogo.png')}}" class="w-50"> <br>
                            <h5>QR Code</h5>
                          </div>
                            <div class="col-lg-4 col-md-4 col-sm-12"><a href="https://brilliantpatna.com" target="blank">www.brilliantpatna.com</a><br>
                          <h5>Website</h5></div>
                          </div>
                        </div>
              
                </div>
                </div>
              
                <section class="section3">
                    <div class="panel-group" id="accordion1">
                    <div class="panel panel-default">
                      <div class="panel-heading"  data-target="#Exampleone" data-toggle="collapse" data-parent="#accordion1">
                        <h4 class="panel-title"  data-target="#Exampleone" data-toggle="collapse" data-parent="#accordion1">
                           <span class="count"> 01 <i class="fa fa-hand-o-right" aria-hidden="true"></i></span>
                           PT Exam (Online Mode)
                        </h4>
                      </div>
                      <div class="panel-collapse collapse in" id="Exampleone">
                        <div class="panel-body">
                          <p>Any time... Any where... (Through a link,QR Code or website)</p>
                          <h4>Result: On spot results</h4>
                          <div class="row exm-card">
                            <div class="col-lg-4 col-md-4 col-sm-12"><a href="https://brilliantpatna.com" target="blank">www.ima.brilliantpatna.com</a><br>
                          <h5>Link</h5></div>
                            <div class="col-lg-4 col-md-4 col-sm-12"> <img src="{{asset('/images/qrlogo.png')}}" class="w-50"> <br>
                            <h5>QR Code</h5>
                          </div>
                            <div class="col-lg-4 col-md-4 col-sm-12"><a href="https://brilliantpatna.com" target="blank">www.brilliantpatna.com</a><br>
                          <h5>Website</h5></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" data-target="#Exampletwo" data-toggle="collapse" data-parent="#accordion1">
                        <h4 class="panel-title"data-target="#Exampletwo" data-toggle="collapse" data-parent="#accordion1">
                        <span class="count"> 02 <i class="fa fa-hand-o-right" aria-hidden="true"></i></span>
                        Mains Exam (Offline Mode)
                        </h4>
                      </div>
                      <div class="panel-collapse collapse in" id="Exampletwo">
                        <div class="panel-body">
                          <p>District Wise Test schedule to be declared on 31<sup>th</sup> May (Tue) 2022</p>
                          <h4>Result: 9<sup>th</sup> June 2022</h4>
                        </div>
                      </div>
                    </div>

                    <div class="panel panel-default">
                      <div class="panel-heading" data-target="#Examplethree" data-toggle="collapse" data-parent="#accordion1">
                        <h4 class="panel-title"data-target="#Examplethree" data-toggle="collapse" data-parent="#accordion1">
                        <span class="count"> 03 <i class="fa fa-hand-o-right" aria-hidden="true"></i></span>
                        Interview Round (Offline Mode)
                        </h4>
                      </div>
                      <div class="panel-collapse collapse in" id="Examplethree">
                        <div class="panel-body">
                        <p>To be Conducted at Brilliant House ,Patna from  11<sup>th</sup> to  15<sup>th</sup> June 22</p>
                          <h4>Final Result: 19<sup>th</sup> June 2022</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>

                  <h2 class="comm">Classes Commencement: 28<sup>th</sup> June 2022</h2>
               
            </div>
        </div>
      </div>    
    </section>

    

    <section class="section4">
      <div class="container">
        <div class="row">
          <h2 class="whatmk">About Brilliant, Patna </h2>
          <p class="text-justify"> Talking about NEET preparations , for over 3 decades BRILLIANT , Patna has by far been the number one choice amongst the students for NEET grooming .  BRILLIANT has been the most sought after and the premier institute amongst all existing NEET coaching institutions in Bihar.  BRILLIANT equips NEET aspirants with personalized courses to serve their needs across the Nation through their specialized centers and their easily accessible interactive online platform.  It also offers a range of scholarships and discounts on fees for the meritorious students and has a state - of - their art faculty team to cater to the personal preparation needs for individual students which propel them to qualify NEET with Rank.</p>
        </div>

       
    </div>
    </section>
    <section class="section4">
      <div class="container toppers" style="border-top: 1px dotted #cccccc; margin-top: 30px; padding-top: 20px;">
        <img alt="NEET Topper" class="dis-desk" data-entity-type="file" data-entity-uuid="82397c29-2c86-4f91-a464-74c19e0df9cf" src="https://brilliantpatna.com/wp-content/uploads/2021/03/Neeraj-300x225.jpg">
        <img alt="NEET Topper" class="dis-mob" data-entity-type="file" data-entity-uuid="82397c29-2c86-4f91-a464-74c19e0df9cf" src="https://brilliantpatna.com/wp-content/uploads/2021/03/Neeraj-300x225.jpg">
        <img alt="JEE Topper" class="dis-desk" data-entity-type="file" data-entity-uuid="82397c29-2c86-4f91-a464-74c19e0df9cf" src="https://brilliantpatna.com/wp-content/uploads/2021/03/Neeraj-300x225.jpg">
        <img alt="JEE Topper" class="dis-mob" data-entity-type="file" data-entity-uuid="82397c29-2c86-4f91-a464-74c19e0df9cf" src="https://brilliantpatna.com/wp-content/uploads/2021/03/Neeraj-300x225.jpg">
      </div>
    </section>
  @endif


@endsection

@section('scripts')

<script>
   $(document).ready(function() {
       $('.sessionmodal').addClass("active");
       setTimeout(function() {
           $('.sessionmodal').removeClass("active");
      }, 4500);
    });
</script>


 @if($setting->right_setting == 1)
  <script type="text/javascript" language="javascript">
   // Right click disable
    $(function() {
    $(this).bind("contextmenu", function(inspect) {
    inspect.preventDefault();
    });
    });
      // End Right click disable
  </script>
@endif

@if($setting->element_setting == 1)
<script type="text/javascript" language="javascript">
//all controller is disable
      $(function() {
      var isCtrl = false;
      document.onkeyup=function(e){
      if(e.which == 17) isCtrl=false;
}

      document.onkeydown=function(e){
       if(e.which == 17) isCtrl=true;
      if(e.which == 85 && isCtrl == true) {
     return false;
    }
 };
      $(document).keydown(function (event) {
       if (event.keyCode == 123) { // Prevent F12
       return false;
  }
      else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
     return false;
   }
 });
});
     // end all controller is disable
 </script>


@endif
@endsection
