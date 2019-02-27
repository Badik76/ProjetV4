<?php
// Start the session
session_start();
// End the session
session_unset();
//session_regenerate_id(true); 
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include_once '../includes/header.php'; ?>       
    <div class="card-panel">
        <div class="card-content center">
            <h2>Merci de votre visite sur notre site.</h2>
            <p>Nous espérons vous revoir bientôt</p>
        </div>
    </div>
    <!-- fin formulaire inscription-->
    <?php include_once '../includes/footer.php'; ?>    
</body>
</html>