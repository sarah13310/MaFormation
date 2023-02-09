<?= $this->extend('layouts/profil') ?>

<?= $this->section('header') ?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

<link href='<?= base_url() ?>/css/calendar.css' rel='stylesheet' />
<link href='<?= base_url() ?>/css/theme.css' rel='stylesheet' />
<style>
    
    table>thead {
        vertical-align: bottom;
        font-size: 12px;
        /* background: linear-gradient(#1607eb, #0d6efd); */
        background: #333333;
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="ms-4 mb-1"><i class="bi bi-calendar2-date"></i>&nbsp;&nbsp;<?= $title ?></h1>
<hr class="mt-1">
<div class='container-fluid'>

    <div class="col">
        <div id="column_calendar" class="container-fluid">
            <div class="mb-3" id='calendar'></div>
        </div>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    let calendar;
    var myForm = document.forms["rdvForm"];
    let selectType = document.getElementById("selectType");
    let btnAjouter = document.getElementById('btnAjouter');
    let date = new Date();
    
    let rdvs = <?= $events ?>; //"";
   
    let dateStartSelected;
    let dateEndSelected;
    const calendarEl = document.getElementById('calendar');

    function initCalendar() {
        calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',
            initialView: 'dayGridMonth',
            selectable: true,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,'
            },
            
            locale: 'fr',
            events: rdvs,
        });
    }

    function showCalendar() {
        calendar.render();
    }
    
    initCalendar();
    showCalendar();
    

    let buttons = document.querySelectorAll('button');
    for (let i = 0; i < buttons.length; i++) {
        if (buttons[i].matches(".btn-primary")) {
            buttons[i].classList.replace("btn-primary", "<?= $buttonColor ?>");
        }
    }
</script>
<?= $this->endSection() ?>