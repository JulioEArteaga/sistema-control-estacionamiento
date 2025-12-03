<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login – Estacionamiento</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary d-flex justify-content-center align-items-center vh-100">

<div class="card p-4" style="width:350px">
<h4 class="text-center">Iniciar Sesión</h4>

<div id="msg"></div>

<input type="text" id="usuario" class="form-control mb-2" placeholder="Usuario">
<input type="password" id="password" class="form-control mb-2" placeholder="Contraseña">

<button onclick="login()" class="btn btn-dark w-100">Ingresar</button>
</div>

<script>
function login() {
    fetch("ajax_login.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: `usuario=${usuario.value}&password=${password.value}`
    })
    .then(r => r.text())
    .then(data => {
        if (data === "ok") location.href="dashboard.php";
        else msg.innerHTML = `<div class="alert alert-danger">${data}</div>`;
    });
}
</script>
</body>
</html>
