<?php
include("../model/conexao.php");
include("useful/footeratv.php");
include("useful/header.php");

session_start();

if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
} else {
    $emailUsuario = $_SESSION["email"];
    $queryAtividades = "SELECT a.*, m.nome AS nome_materia 
                        FROM atividades a
                        JOIN materias m ON a.materia_id = m.id
                        WHERE a.usuario_id = (
                            SELECT id FROM usuarios WHERE email = ?
                        )";
    $stmtAtividades = mysqli_prepare($con, $queryAtividades);
    mysqli_stmt_bind_param($stmtAtividades, "s", $emailUsuario);
    mysqli_stmt_execute($stmtAtividades);
    $resultAtividades = mysqli_stmt_get_result($stmtAtividades);

    $queryFraseMotivacional = "SELECT Frase FROM FrasesMotivac ORDER BY RAND() LIMIT 1";
    $resultFraseMotivacional = mysqli_query($con, $queryFraseMotivacional);
    $fraseMotivacional = mysqli_fetch_assoc($resultFraseMotivacional)['Frase'];
    // Consultar o número de matérias
    $queryMateria = "SELECT COUNT(*) AS total FROM materias";
    $result = mysqli_query($con, $queryMateria);
    // Verificar se a consulta foi bem-sucedida
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] == 0) {
            // Redirecionar para a tela de cadastro com uma mensagem GET
            header('Location: ../view/materias.php?mensagem=Cadastre+uma+materia+antes+de+iniciar+as+atividades.');
            exit();
        }
    } else {
        echo "Erro na consulta: " . mysqli_error($con);
    }

}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/cssmetas.css" rel="stylesheet">
</head>
<body class="bg-dark"> 
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-primary mx-4">Aqui estão seus à fazeres!</h1>
            <ol class="breadcrumb mb-4 mx-4">
                <li class="breadcrumb-item active"><?php echo $fraseMotivacional; ?></li>
            </ol>
            <div class="card mb-4">
                <?php while ($row = mysqli_fetch_assoc($resultAtividades)) { ?>
                    <div class="card-body mb-4 mx-5">
                        <div class="meta">
                            <div class="meta-item">
                                <div class="meta-value-large"><?php echo htmlspecialchars($row['nome']); ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-medium">Matéria: <?php echo htmlspecialchars($row['nome_materia']); ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-small">Data de Entrega: <?php echo htmlspecialchars($row['data_entrega']); ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-play">
                                    <button class="iniciar-btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#pomodoroModal" data-id="<?php echo $row['id']; ?>">Iniciar</button>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-edit">
                                    <a href="editatividade.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">Editar</a>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-reminder">
                                    <button class="lembrete-btn btn btn-warning" data-bs-toggle="modal" data-bs-target="#lembreteModal" data-id="<?php echo $row['id']; ?>">Lembretes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php } ?>
            </div>
        </div>

        <!-- Modal do Pomodoro -->
        <div class="modal fade" id="pomodoroModal" tabindex="-1" aria-labelledby="pomodoroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header bg-dark text-light"> <!-- Alterado para fundo escuro e texto claro -->
                        <h5 class="modal-title" id="pomodoroModalLabel">Pomodoro Timer</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Botão de fechar com estilo claro -->
                    </div>
                    <div class="modal-body text-center">
                        <div id="timer" class="display-4 mb-4">25:00</div>
                        <button id="startTimerBtn" class="btn btn-success me-2">Iniciar</button>
                        <button id="pauseTimerBtn" class="btn btn-warning me-2" style="display: none;">Pausar</button>
                        <button id="resumeTimerBtn" class="btn btn-info me-2" style="display: none;">Retomar</button>
                        <button id="resetTimerBtn" class="btn btn-secondary me-2">Zerar</button>
                        <button id="stopTimerBtn" class="btn btn-danger">Parar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Scripts do Bootstrap e temporizador -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let timerInterval;
        let remainingTime = 25 * 60; // Tempo total em segundos (25 minutos)
        const timerElement = document.getElementById('timer');
        const startTimerBtn = document.getElementById('startTimerBtn');
        const pauseTimerBtn = document.getElementById('pauseTimerBtn');
        const resumeTimerBtn = document.getElementById('resumeTimerBtn');
        const resetTimerBtn = document.getElementById('resetTimerBtn');
        const stopTimerBtn = document.getElementById('stopTimerBtn');
        let activityId;

        // Atualiza o activityId quando um botão de iniciar é clicado
        document.querySelectorAll('.iniciar-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                activityId = this.getAttribute('data-id');
                resetTimer(); // Reseta o temporizador para 25:00 ao abrir o modal
            });
        });

        startTimerBtn.addEventListener('click', function() {
            startTimer(activityId);
            startTimerBtn.style.display = 'none';
            pauseTimerBtn.style.display = 'inline-block';
        });

        pauseTimerBtn.addEventListener('click', function() {
            clearInterval(timerInterval);
            pauseTimerBtn.style.display = 'none';
            resumeTimerBtn.style.display = 'inline-block';
        });

        resumeTimerBtn.addEventListener('click', function() {
            startTimer(activityId);
            resumeTimerBtn.style.display = 'none';
            pauseTimerBtn.style.display = 'inline-block';
        });

        resetTimerBtn.addEventListener('click', function() {
            resetTimer();
        });

        stopTimerBtn.addEventListener('click', function() {
            clearInterval(timerInterval);
            resetTimer();
            var modal = bootstrap.Modal.getInstance(document.getElementById('pomodoroModal'));
            modal.hide(); // Fecha o modal
        });

        function startTimer(activityId) {
            timerInterval = setInterval(function() {
                let minutes = Math.floor(remainingTime / 60);
                let seconds = remainingTime % 60;

                if (remainingTime <= 0) {
                    clearInterval(timerInterval);
                    registerTime(activityId, 25 * 60); // Registra o tempo quando o temporizador termina
                } else {
                    // Atualiza o temporizador na interface do usuário
                    timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    remainingTime--; // Decrementa o tempo restante
                }
            }, 1000);
        }

        function resetTimer() {
            clearInterval(timerInterval);
            remainingTime = 25 * 60;
            timerElement.textContent = "25:00";
            startTimerBtn.style.display = 'inline-block';
            pauseTimerBtn.style.display = 'none';
            resumeTimerBtn.style.display = 'none';
        }

        function registerTime(activityId, totalTime) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'registrar_tempo.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log('Tempo registrado com sucesso!');
                }
            };
            xhr.send(`activity_id=${activityId}&elapsed_time=${totalTime}`);
        }
    });
    </script>
</body>
</html>
