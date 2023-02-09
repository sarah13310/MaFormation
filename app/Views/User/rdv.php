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
    section {
        font-size: 14px;
    }

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
        <div class="col">
            <div id="column_calendar" class="container-fluid">
                <div class="mb-3" id='calendar'></div>
            </div>
        </div>
        <div class="row">
            <div id="column_form" class="col col-md-8 ">

                <fieldset>
                    <form id="rdvForm" name="rdvForm" action="/user/rdv/save" method="post">
                        <input type="hidden" name="id_rdv">
                        <legend><i class="bi bi-calendar2-check"></i>&nbsp;&nbsp;Prenez votre rendez-vous</legend>
                        <div>
                            <!-- <fieldset class="form-group border p-3"> -->
                            <p class="medium text-muted"> <?= $legend ?></p>

                            <!-- liste des formations -->
                            <div class="form-group row align-items-center mb-3">
                                <label for="select" class="col-12 col-md-3 col-form-label">Formations</label>
                                <div class="col col-md-9 ">
                                    <select id="id_training" name="id_training" class="form-select">
                                        <?php foreach ($trainings as $training) : ?>
                                            <option value="<?= $training['id_training'] ?>"><?= $training['title'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <!-- liste des formateurs -->
                            <div class="form-group row align-items-center mb-3">
                                <label for="select" class="col-12 col-md-3 col-form-label">Formateurs</label>
                                <div class="col col-md-9 ">
                                    <select id="id_former" name="id_former" class="form-select">
                                        <?php foreach ($formers as $former) : ?>
                                            <option value="<?= $former['id_user'] ?>"><?= $former['name'] . " " . $former['firstname'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-floating mb-3 col ">
                                    <input class="form-control" id="dateStart" name="dateStart" type="date" placeholder="&nbsp;Date de départ" />
                                    <label for="date">&nbsp;Date de départ</label>
                                </div>
                                <div class="form-floating mb-3 col ">
                                    <input class="form-control" id="timeStart" name="timeStart" type="time" placeholder="&nbsp;Heure de départ" />
                                    <label for="heure">&nbsp;Heure de départ</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-floating mb-3  col ">
                                    <input class="form-control" id="dateEnd" name="dateEnd" type="date" placeholder="&nbsp;Date de fin" />
                                    <label for="date">&nbsp;Date de fin</label>
                                </div>
                                <div class="form-floating mb-3 col ">
                                    <input class="form-control" id="timeEnd" name="timeEnd" type="time" placeholder="&nbsp;Heure de fin" />
                                    <label for="heure">&nbsp;Heure de fin</label>
                                </div>
                            </div>
                            <div class="d-grid col-5 ">
                                <button type="submit" class="btn btn-primary " id="btnAjouter">Ajouter
                                </button>
                            </div>
                            <!-- </fieldset> -->
                        </div>
                    </form>

                </fieldset>
            </div>
            <div class="col-4"><img src="<?= base_url() . '/assets/img/reunion2.jpg' ?>"></div>
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
    let test = [{
        title: 'BCH237',
        start: '2023-02-08T10:30:00',
        end: '2023-02-08T11:30:00',
    }]; //"";
    let rdvs = <?= $events ?>; //"";



    function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
    }

    function formatDate(date) {
        return [
            date.getFullYear(),
            padTo2Digits(date.getMonth() + 1),
            padTo2Digits(date.getDate()),
        ].join('-');
    }

    function formatTime(date, offset = 1) {
        return [
            padTo2Digits(date.getHours() + offset),
            padTo2Digits(date.getMinutes()),
        ].join(':');
    }

    // on initialise les champs date et heure
    myForm["dateStart"].value = formatDate(date);
    myForm["timeStart"].value = formatTime(date);
    myForm["dateEnd"].value = formatDate(date);
    myForm["timeEnd"].value = formatTime(date, 2);

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
            select: function(info) {
                dateStartSelected = info.start; // Date de début
                dateEndSelected = info.end; //Date de fin
                dateEndSelected.setDate(dateEndSelected.getDate()); //bug
                myForm["dateStart"].value = formatDate(dateStartSelected);
                myForm["timeStart"].value = formatTime(dateStartSelected, 0);
                myForm["dateEnd"].value = formatDate(dateEndSelected);
                myForm["timeEnd"].value = formatTime(dateEndSelected, 0);
            },
            eventClick: function(arg) {
                if (confirm('Êtes vous sûr de supprimer cet évènement?')) {
                    //arg.event.remove()
                    console.log(arg.event.id);
                    rdvForm.action = "/user/rdv/delete";
                    rdvForm.id_rdv.value = arg.event.id;
                    rdvForm.submit();
                }
            },
            locale: 'fr',
            events: rdvs,
        });
    }

    function showCalendar() {
        calendar.render();
    }

    // Ajouter un évènement
    function OnAddEvent() {
        event.stopPropagation();
        let titleStr = selectType.options[selectType.selectedIndex].text;
        // var dateStart = dateStartSelected; // will be in local time
        let dateEnd = dateEndSelected.setDate(dateEndSelected.getDate() + 1); // will be in local time
        calendar.addEvent({
            title: titleStr,
            start: dateStartSelected,
            end: dateEnd,
            allDay: false
        });
    }

    function getEvents() {
        calendar.getEvents().forEach(event => {
            event.title
        })
    }
    initCalendar();
    showCalendar();

    /*myForm.onsubmit = () => {
        //dateStartSelected = new Date(myForm["dateStart"].value);
        //dateEndSelected = new Date(myForm["dateEnd"].value);
        //OnAddEvent();
        this.action = "/user/rdv/add";
        this.method = "POST";
        this.submit();
       
    }*/

    let buttons = document.querySelectorAll('button');
    for (let i = 0; i < buttons.length; i++) {
        if (buttons[i].matches(".btn-primary")) {
            buttons[i].classList.replace("btn-primary", "<?= $buttonColor ?>");
        }
    }
</script>
<?= $this->endSection() ?>