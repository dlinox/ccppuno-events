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
      background-color: white;
      border: 2px solid #007bff;
      color: #007bff;
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
      
      <p> Nos complace informarle que su registro se ha completado exitosamente.
        Sin embargo, aún falta un último paso antes de que pueda acceder a su cuenta.</p>

      <p>
        Para garantizar la seguridad de nuestros servicios y proporcionarle una experiencia óptima, requerimos que valide su pago. Una vez que su pago sea verificado, recibirá un correo de confirmación adicional que incluirá su contraseña de acceso para su cuenta.
      </p>

      <p>
        Por favor, tenga en cuenta que este proceso de validación de pago puede demorar un corto período de tiempo, generalmente unas horas, pero puede variar según el método de pago que haya seleccionado. Una vez que su pago haya sido confirmado, le proporcionaremos los detalles de su cuenta para que pueda acceder sin problemas.
      </p>

      <p>

        Manténgase atento a su bandeja de entrada, ya que le enviaremos un correo electrónico de confirmación tan pronto como se complete la validación de su pago.
      </p>


      <p>Si no has solicitado la inscripción en GUBER2023, simplemente ignora este correo. Estamos aquí para ayudarte con cualquier inquietud.</p>

      <p>El Equipo Organizador de GUBER2023</p>
    </div>
  </div>
</body>

</html>