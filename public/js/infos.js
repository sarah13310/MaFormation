// Affiche temporairement les erreurs, infos, avertissements
 
    const warning = document.getElementById('warning');
    const error = document.getElementById("error");
    const success = document.getElementById("success");
  
    setTimeout(() => {
        if (warning) {
            warning.remove();
        }
        if (error) {
            error.remove();
        }
        if (success) {
            success.remove();
        }
    }, 1500);
