function compte_a_rebours()
{
    var compte_a_rebours = document.getElementById("compte_a_rebours");

    var date_actuelle = new Date();
    var date_evenement = new Date("Mar 1 23:59:59 2015"); //Mar 1 23:59:59 2015
    var total_secondes = (date_evenement - date_actuelle) / 1000;

    if (total_secondes > 0)
    {
        var jours = Math.floor(total_secondes / (60 * 60 * 24));
        var heures = Math.floor((total_secondes - (jours * 60 * 60 * 24)) / (60 * 60));
        minutes = Math.floor((total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60))) / 60);
        secondes = Math.floor(total_secondes - ((jours * 60 * 60 * 24 + heures * 60 * 60 + minutes * 60)));

        var mot_jour = "DAYS";
        var mot_heure = "HOURS";
        var mot_minute = "MINUTES";
        var mot_seconde = "SECONDS";

        if (jours == 0)
        {
            jours = 0;
            mot_jour = 'DAY';
        }
        else if (jours == 1)
        {
            mot_jour = "DAY";
        }

        if (heures == 0)
        {
            heures = 0;
            mot_heure = 'HOUR';
        }
        else if (heures == 1)
        {
            mot_heure = "HOUR";
        }

        if (minutes == 0)
        {
            minutes = 0;
            mot_minute = 'MINUTE';
        }
        else if (minutes == 1)
        {
            mot_minute = "MINUTE";
        }

        if (secondes == 0)
        {
            secondes = 0;
            mot_seconde = 'SECOND';
        }
        else if (secondes == 1)
        {
            mot_seconde = "SECOND";
        }

        if (minutes == 0 && heures == 0 && jours == 0)
        {

        }

        days_js.innerHTML = jours;
        hours_js.innerHTML = heures;
        minutes_js.innerHTML = minutes;
        seconds_js.innerHTML = secondes;
        days_label_js.innerHTML = mot_jour;
        hours_label_js.innerHTML = mot_heure;
        minutes_label_js.innerHTML = mot_minute;
        seconds_label_js.innerHTML = mot_seconde;

    }
    else
    {
        location.reload();
    }

    var actualisation = setTimeout("compte_a_rebours();", 1000);
}
compte_a_rebours();