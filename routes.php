<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotas</title>
    <link rel="stylesheet" type="text/css" href="style-geral.css">
    <link rel="stylesheet" type="text/css" href="routes.css">
</head>
<body>
    <div class="header">
        <a href="home.php" class="container-logo">
            <img src="assets/logo.jpg" alt="" class="logo-header">
        </a>
        <div class="rotas-container">
            <a href="routes.php">ROTAS</a>
        </div>
        <div class="cadastro-container">
            <a href="clients.php">CLIENTES</a>
        </div>
        <a href="login.php" class="user-container">
            <img src="assets/user.png" alt="" class="user">
        </a>
    </div>
    <div class="routes-container">
        <div class="nav-bar">HOME > ROTAS</div>
        <div class="routes">
            <table class="table-container">
                <tr class="table-labels">
                    <td>RUA</td>
                    <td>QTD CAIXAS</td>
                    <td>REFERÊNCIA</td>
                    <td>VAGAS</td>
                    <td>TIPO SPRINT</td>
                </tr>
                <tr>
                    <td>Rua real da torre</td>
                    <td>22</td>
                    <td>a</td>
                    <td>2</td>
                    <td>Estudante</td>
                </tr>
    
            </table>
        </div>
        
        <div class="new-route-container" onclick="showaddroute()">
            <span class="plus">+</span>
            <span class="new-route-label">INSERIR NOVA ROTA</span>
        </div>
        <div class="pop-up-container">
            <img src="assets/close.png" alt="" class="img-close" onclick="hideaddroute()">
            <span>INSERIR NOVA ROTA</span>
            <div class="form-add">
                <input type="text" placeholder="Rua">
                <input type="text" placeholder="QTD CAIXAS">
                <input type="text" placeholder="REFERÊNCIA">
                <input type="text" placeholder="VAGAS">
                <input type="text" placeholder="TIPO SPRINT">
            </div>
            <div class="button-insert">INSERIR</div>
        </div>
    </div>
    
    <script>
        function showaddroute() {
            var popup = document.getElementsByClassName("pop-up-container")[0];
            popup.style.display = 'flex'
        }
        function hideaddroute() {
            var popup = document.getElementsByClassName("pop-up-container")[0];
            popup.style.display = 'none'
        }
    </script>
</body>
</html>