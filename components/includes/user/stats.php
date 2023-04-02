<?php
// Une nouvelle session de jeu doit être créée pour éviter que le jeu ne recommence à chaque refresh
if (isset($_POST["newGame"])) {
    $_SESSION['deck'] =  getDeck($_SESSION['id']);
    header("Location: index.php?id=play");
}

$stats = fetch_stats($_SESSION['id']);
?>

<div id="cardList">
    <div id="statusOk" class="tabs-container">
        <form action="" method="post">
            <div style="width: 100%;" class="centered">
                <input type="submit" class="submitInput" name="newGame" value="Nouvelle partie">
            </div>
        </form>
        </br>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Retenu', 'Connu', 'Moyen', 'À revoir', 'Inconnu'],
            datasets: [{
                label: '# of Votes',
                data: [<?php echo $stats[0] . ", " . $stats[1] . ", " . $stats[2] . ", " . $stats[3] . ", " . $stats[4] ?>],
                borderWidth: 1
            }]
        },
    });
</script>