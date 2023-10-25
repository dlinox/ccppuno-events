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
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;

    }

    .certificate-bg {
      position: absolute;
      z-index: 10;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .certificate-header {
      margin-top: 160px;
      width: 100%;
      text-align: center;
      z-index: 20;

    }

    .certificate-header h1 {
      color: #29434e;
      font-size: 38px;
      margin: 10px 0px;
    }

    .certificate-header h3 {
      font-size: 18px;
      color: #555;
    }

    .certificate-body {
      z-index: 20;
      margin: 35px 100px 0 100px;
    }

    .certificate-body h2 {
      margin: 5px 0px 0px 0px;
      font-size: 30px;
    }

    .certificate-body .centificate-description {
      margin-top: 20px;
    }

    .certificate-footer {
      z-index: 20;
      margin-top: 110px;
      padding: 0 100px;
      width: 100%;
    }

    .certificate-qr {
      z-index: 20;
      position: absolute;
      left: 0;
      bottom: 0;
      border: 3px solid #fff;
    }
  </style>
</head>

<body>

  <img class="certificate-bg" src="{{$bg}}" alt="">

  <div class="certificate-header">
    <h1>CERTIFICADO</h1>
    <h3>IX Convención Nacional de Contabilidad Gubernamental y Administración Pública, GUBER-2023</h3>
  </div>

  <div class="certificate-body">
    <p>Otorgado a:</p>
    <h2>{{ $name }}</h2>
    <p>En calidad de:</p>
    <h2> Observador </h2>

    <p class="centificate-description">
      En IX Convención Nacional de Contabilidad Gubernamental y Administración Pública, GUBER-2023 que se realizará en la ciudad de Puno los días 26, 27 y 28 de Octubre del 2023.
    </p>

  </div>



  <table class="certificate-footer" width="100%">
    <tr>
      <td style="text-align: left;">_______________________
        <br>
        Dr. Jose Perez
      </td>
      <td></td>
      <td style="text-align: center;">_______________________
        <br>
        Dr. Jose Perez
      </td>
      <td></td>
      <td style="text-align: right;">_______________________
        <br>
        Dr. Jose Perez

      </td>
    </tr>
  </table>



  <div class="certificate-qr">
    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="Código QR">
  </div>
</body>

</html>