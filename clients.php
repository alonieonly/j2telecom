<?php
    require_once("conn.php");
    require_once("Usuario.php");
    session_start();
    $objeto = $_SESSION["logged_user"];
    $sql = "SELECT * FROM clientes";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $table = $result;
    }
    function Redirect($url, $permanent = false)
    {
        if (headers_sent() === false)
        {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }
        exit();
    }
    if (isset($_POST["nome"]) && isset($_POST["rua"]) && isset($_POST["numero"]) && isset($_POST["comp"]) && isset($_POST["contato"]) && isset($_POST["rota"])) {
        $nome = $_POST["nome"];
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $comp = $_POST["comp"];
        $contato = $_POST["contato"];
        $rota = $_POST["rota"];

        $stmt = $conn->prepare("INSERT INTO clientes (nome, rua, numero, complemento, contato,rota) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $rua, $numero, $comp, $contato, $rota);
        $stmt->execute();
        $stmt->close();
        Redirect('http://localhost/inter-2024/clients.php', false);
    }

    if (isset($_POST["querycod"])) {
        $cod = mysqli_real_escape_string($conn, $_POST["querycod"]);
        $sqla = "SELECT * FROM clientes WHERE cod = '$cod'";
        $resulta = $conn->query($sqla);
        if ($resulta->num_rows > 0) {
            $_SESSION["table_form"] = mysqli_fetch_assoc($resulta);
            http_response_code(200);
        } else {
            http_response_code(404);
        }
    } else {
        http_response_code(400);
    }
    if (isset($_POST["edit-nome"]) && isset($_POST["edit-rua"]) && isset($_POST["edit-numero"]) && isset($_POST["edit-comp"]) && isset($_POST["edit-contato"]) && isset($_POST["edit-rota"])) {
        $edit_nome = $_POST["edit-nome"];
        $edit_rua = $_POST["edit-rua"];
        $edit_numero = $_POST["edit-numero"];
        $edit_comp = $_POST["edit-comp"];
        $edit_contato = $_POST["edit-contato"];
        $edit_rota = $_POST["edit-rota"];
        $edit_cod = $_POST["edit-cod"];

        $stmt = $conn->prepare("UPDATE clientes SET nome=?,rua=?,numero=?,complemento=?,contato=?,rua=? WHERE cod=?");
        $stmt->bind_param("sssssss", $edit_nome, $edit_rua, $edit_numero, $edit_comp, $edit_contato, $edit_rota,$edit_cod);
        $stmt->execute();
        $stmt->close();
        Redirect('http://localhost/inter-2024/clients.php', false);
    }
    if (isset($_POST['deleteid'])) {
        $cod = mysqli_real_escape_string($conn, $_POST['deleteid']);
        $sql = "DELETE FROM clientes WHERE cod = '$cod'";
        
        if (mysqli_query($conn, $sql)) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" type="text/css" href="style-geral.css">
    <link rel="stylesheet" type="text/css" href="clients.css">
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
        <div class="user-container" onclick="showinfos()">
            <img src="assets/user.png" alt="" class="user">
        </div>
    </div>
    <div class="routes-container">
    <div class="nav-bar"><a href="home.php">HOME</a> > CLIENTES</div>
        <div class="routes">
            <table class="table-container">
                <tr class="table-labels">
                    <td>NOME</td>
                    <td>CODIGO</td>
                    <td>ROTA</td>
                    <?php
                        if ($objeto->getisadmin() == 1) {
                            echo "<td>AÇÃO</td>";
                        }
                    ?>
                </tr>
                <?php
                    if (isset($table)) {
                        for($j=0;$j<$table->num_rows;$j++) {
                            $linha = mysqli_fetch_assoc($table);
                            $cod = $linha['cod'];
                            echo "<tr data-cod=\"{$linha['cod']}\">";
                                echo "<td>";
                                echo $linha['nome'];
                                echo "</td>";

                                echo "<td>";
                                echo sprintf("%04d", $linha['cod']);
                                echo "</td>";

                                echo "<td>";
                                echo sprintf("%02d", $linha['rota']);
                                echo "</td>";

                                if ($objeto->getisadmin() == 1) {
                                    echo "<td>";
                                    echo "<img class='img-table' src=\"assets/info.png\" onclick=\"showedit($cod)\"></img>";
                                    echo "</td>";
                                }

                            echo "</tr>";
                        }
                    }
                ?>
            </table>
        </div>
        
        <div class="new-route-container" onclick="showaddroute()">
            <span class="plus">+</span>
            <span class="new-route-label">INSERIR NOVO CLIENTE</span>
        </div>
        <div class="pop-up-clientes">
            <img src="assets/close.png" alt="" class="img-close" onclick="hideaddroute()">
            <span>INSERIR NOVO CLIENTE</span>
            <form class="form-add" id="myForm" method="post" action="">
                <input type="text" placeholder="NOME" name="nome">
                <input type="text" placeholder="RUA" name="rua">
                <input type="text" placeholder="NUMERO" name="numero">
                <input type="text" placeholder="COMPLEMENTO" name="comp">
                <input type="text" placeholder="CONTATO" name="contato">
                <input type="text" placeholder="ROTA" name="rota">
            </form>
            <button type="button" onclick="submitForm()" class="button-insert">INSERIR</button>
        </div>
        <div class="pop-up-edit">
            <img src="assets/close.png" alt="" class="img-close" onclick="hideedit()">
            <span>CLIENTE</span>
            <form class="form-edit" id="myFormEdit" method="post" action="">
                <?php
                    if (isset($_SESSION["table_form"])){ 
                        $nome = $_SESSION["table_form"]["nome"];
                        $rua = $_SESSION["table_form"]["rua"];
                        $numero = $_SESSION["table_form"]["numero"];
                        $complemento = $_SESSION["table_form"]["complemento"];
                        $contato = $_SESSION["table_form"]["contato"];
                        $rota = $_SESSION["table_form"]["rota"];
                        $cod = $_SESSION["table_form"]["cod"];
                        echo "<input type=\"text\" placeholder=\"NOME\" name=\"edit-nome\" value=\"$nome\">";
                        echo "<input type=\"text\" placeholder=\"RUA\" name=\"edit-rua\" value=\"$rua\">";
                        echo "<input type=\"number\" placeholder=\"numero\" name=\"edit-numero\" value=\"$numero\">";
                        echo "<input type=\"text\" placeholder=\"complemento\" name=\"edit-comp\" value=\"$complemento\">";
                        echo "<input type=\"text\" placeholder=\"contato\" name=\"edit-contato\" value=\"$contato\">";
                        echo "<input type=\"number\" placeholder=\"rota\" name=\"edit-rota\" value=\"$rota\">";
                        echo "<input type=\"text\" placeholder=\"cod\" style=\"display:none;\" name=\"edit-cod\" value=\"$cod\">";
                    }
                ?>
            </form>
            <div class="buttons-container">
                <button type="button" class="button-insert" onclick="submitFormEdit()">EDITAR</button>
                <?php
                    $cod = $_SESSION["table_form"]["cod"];
                    echo "<button type=\"button\" class=\"button-insert\" onclick=\"submitFormDelete($cod)\">EXCLUIR</button>"
                ?>
            </div>
                
        </div>
        <div class="pop-up-exit">
            <img src="assets/close.png" alt="" class="img-close" onclick="hideinfos()">
            <img src="assets/user.png" alt="" class="img-user">
            <span>Nome: <?php echo $objeto->getLogin(); ?></span>
            <span>Cargo: <?php if ($objeto->getisadmin() == 1) {
                echo "Admin";
            } else {
                echo "Operador";
            }
            ?></span>

            <a href="resetconn.php">
                <img src="assets/exit.png" alt="" class="img-exit" onclick="hideaddroute()">
            </a>
        </div>
    </div>
    <script>
        var savedbtn = null;
        function showaddroute() {
            var popup = document.getElementsByClassName("pop-up-clientes")[0];
            popup.style.display = 'flex'
        }
        function hideaddroute() {
            var popup = document.getElementsByClassName("pop-up-clientes")[0];
            popup.style.display = 'none'
        }
        function showedit(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'clients.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send(`querycod=${id}`);
            var popup = document.getElementsByClassName("pop-up-edit")[0];
            popup.style.display = 'flex'
        }
        function hideedit() {
            var popup = document.getElementsByClassName("pop-up-edit")[0];
            popup.style.display = 'none';
            window.location.reload();
        }
        function showinfos() {
            var popup = document.getElementsByClassName("pop-up-exit")[0];
            popup.style.display = 'flex'
        }
        function hideinfos() {
            var popup = document.getElementsByClassName("pop-up-exit")[0];
            popup.style.display = 'none'
        }
        function submitForm() {
            document.getElementById("myForm").submit();
        }
        function submitFormEdit() {
            document.getElementById("myFormEdit").submit();
        }
        function submitFormDelete(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'clients.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Registro removido com sucesso');
                } else {
                    console.log('Erro ao remover registro');
                }
            };
            xhr.send('deleteid=' + id);
            hideedit();
        }
    </script>
</body>
</html>