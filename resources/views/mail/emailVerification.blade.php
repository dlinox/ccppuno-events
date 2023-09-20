<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f8fa;
      margin: 0;
      padding: 0;
    }

    .email-container {
      width: 100%;
      max-width: 650px;
      margin: 40px auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .header-image {
      width: 100%;
      max-height: 250px;
      object-fit: cover;
    }

    .content {
      padding: 30px 40px;
      font-size: 16px;
      line-height: 1.6;
      color: #333;
    }

    .btn {
      display: block;
      width: 200px;
      padding: 12px;
      text-align: center;
      margin: 20px auto;
      background-color: #007bff;
      color: #ffffff;
      text-decoration: none;
      border-radius: 7px;
    }

    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="email-container">
    <img src="https://lh6.googleusercontent.com/1prBFR9Y3dfmHcgaYVd2nrFs_w3xLuX-H1OneZGmLA5yKqutDRT8BOB8sTXdoDF378Wao9B8zISKnnYNQHl0EuPbk90Ec0RzJkKhJHv-Frm8-JFHErpjNHxdchvz5iGVeg=w1584" alt="Imagen descriptiva" class="header-image">
    <div class="content">
      <h2>¡Gracias por registrarte en GUBER2023!</h2>
      <p>¡Hola {{$data['name']}}!</p>
      <p>Estás a punto de asegurar tu lugar en GUBER2023. Antes de continuar, necesitamos que verifiques tu dirección de correo electrónico para garantizar una comunicación fluida.</p>
      <a href="{{$data['urlVerification']}}" class="btn">Verificar Correo</a>
      <p>Si no has solicitado la inscripción en GUBER2023, simplemente ignora este correo. Estamos aquí para ayudarte con cualquier inquietud.</p>
      
      <p>El Equipo Organizador de GUBER2023</p>
    </div>
  </div>
</body>

</html>