<?= $this->extend('layouts/profil') ?>

<?= $this->section('header') ?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
<link href='<?= base_url() ?>/css/calendar.css' rel='stylesheet' />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="ms-4"><?= $title ?></h1>
<div class='container-fluid mt-2'>
    <div class="row">
        <div id ="column_form" class="col-10 col-md-5 ">
            <div class="container mx-0 my-1">
                <!-- <fieldset class="form-group border p-3"> -->
                    <form id="rdvForm">
                        <div class="form-group row align-items-center mb-3">
                            <label for="select" class="col-12 col-md-2 col-form-label">Type</label>
                            <div class="col-12 col-md-10 ">
                                <select id="selectType" name="select" class="form-select">
                                    <option value="0">Informatique</option>
                                    <option value="1">Programmation processeur</option>
                                    <option value="2">Méthodologie</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 col-12 col-md-6">
                                <input class="form-control" id="dateStart" name="dateStart" type="date" placeholder="&nbsp;Date de départ" />
                                <label for="date">&nbsp;Date de départ</label>
                            </div>
                            <div class="form-floating mb-3 col-12  col-md-6">
                                <input class="form-control" id="timeStart" name="timeStart" type="time" placeholder="&nbsp;Heure de départ" />
                                <label for="heure">&nbsp;Heure de départ</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3  col-12 col-md-6">
                                <input class="form-control" id="dateEnd" name="dateEnd" type="date" placeholder="&nbsp;Date de fin" />
                                <label for="date">&nbsp;Date de fin</label>
                            </div>
                            <div class="form-floating mb-3  col-12 col-md-6">
                                <input class="form-control" id="timeEnd" name="timeEnd" type="time" placeholder="&nbsp;Heure de fin" />
                                <label for="heure">&nbsp;Heure de fin</label>
                            </div>
                        </div>
                        <div class="d-grid col-6 col-md-6">
                            <button type="submit" class="btn btn-primary btn-lg " id="btnAjouter">Ajouter
                            </button>
                        </div>
                    </form>
                <!-- </fieldset> -->
            </div>
        </div>
        <div id="column_calendar" class="my-0 col-10 col-md-6 ">
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
            //padTo2Digits(date.getSeconds()),
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
            initialView: 'dayGridMonth',
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            select: function(info) {
                dateStartSelected = info.start; // Date de début
                dateEndSelected = info.end; //Date de fin
                dateEndSelected.setDate(dateEndSelected.getDate() - 1); //bug
                myForm["dateStart"].value = formatDate(dateStartSelected);
                myForm["timeStart"].value = formatTime(dateStartSelected, 0);
                myForm["dateEnd"].value = formatDate(dateEndSelected);
                myForm["timeEnd"].value = formatTime(dateEndSelected, 0);
            },
            eventClick: function(arg) {
                if (confirm('Êtes vous sûr de supprimer cet évènement?')) {
                    arg.event.remove()
                }
            },
            locale: 'fr',
            events: [],
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
            allDay: true
        });
    }

    function getEvents() {
        calendar.getEvents().forEach(event => {
            event.title
        })
    }


    initCalendar();
    showCalendar();

    myForm.onsubmit = () => {
        dateStartSelected = new Date(myForm["dateStart"].value);
        dateEndSelected = new Date(myForm["dateEnd"].value);
        OnAddEvent();
        return false;
    }
</script>
<?= $this->endSection() ?>