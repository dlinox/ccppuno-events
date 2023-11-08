<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    * {
      padding: 0px;
      margin: 0px;
      box-sizing: border-box;
    }

    body {
      position: relative;

    }

    .certificate-bg {
      position: absolute;
      z-index: 10;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .certificate-name {
      z-index: 20;
      position: absolute;
      top: 337px;
      left: 215px;
      width: 680px;
      text-align: center;
    }

    .certificate-name h2 {
      text-transform: uppercase;
      font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    }

    .certificate-qr {
      z-index: 20;
      position: absolute;
      left: 60px;
      bottom: 60px;
      border: 3px solid #fff;
    }

    .certificate-f1 {
      z-index: 20;
      position: absolute;
      top: 455px;
      left: 575px;

    }

    .certificate-f1 img {
      width: 320px;
      height: auto;
    }

    .certificate-f2 {
      z-index: 20;
      position: absolute;
      top: 575px;
      left: 250px;
    }

    .certificate-f2 img {
      width: 280px;
      height: auto;
    }
  </style>
</head>

<body>

  <img class="certificate-bg" src="{{$bg}}" alt="">



  <div class="certificate-name">
    <h2>{{ $name }}</h2>
  </div>

  <div class="certificate-qr">
    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="Código QR">
  </div>

  <div class="certificate-f1">
    <img class="certificate-bg" src="{{$f1}}" alt="">
  </div>


  <div class="certificate-f2">
    <img class="" src="{{$f2}}" alt="">
  </div>

</body>

</html>