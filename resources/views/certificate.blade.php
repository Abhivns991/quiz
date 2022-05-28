<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> Certificate </title>
       
    <style >
    
        body {
        font-family: helvetica;
        padding: 10px;
        margin: 0;
        }
        
        @media screen and (max-width: 660px) {
        h2{right: 17% !important;
        top: 43%!important;
        font-size: 11px;
        }
        
        }
  </style>
  </head>
    
<body>
    <div style="position: relative; width: 75%; margin: auto; padding: 15px;">
      <h2 style="position: absolute; right: 24%; top: 44%; color: #b32a24;">ABHISHEK KUMAR</h2>
      <img src="{{asset('/images/certificate.jpg')}}" width="100%">
    </div>
    <div style="position: relative; width: 75%; padding: 20px; margin: auto; text-align: center;">
   <a href="javascript:window.print()" style="width: 50px; height: 50px; padding: 10px;background-color: #676362;
    text-decoration: none;color: white; border-radius: 5px;" > Print</a>
  </div>
      
</body>
</html>