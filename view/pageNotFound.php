<div>
    <!-- Main Form -->
    <?php if(isset($_SESSION['error'])){
        echo '<div class="alert alert-danger">';
        echo $error;
        echo '</div>';
    }?>

    <div>
        <div>
            <h1><a href="/haushalt">Zurück</a></h1>
        </div>
    </div>
