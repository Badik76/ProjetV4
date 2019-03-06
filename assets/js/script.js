//déclaration des instances de Materialize
$('select').formSelect();
$('.collapsible').collapsible();
// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
$('.modal').modal();
$('.sidenav').sidenav();
$(".dropdown-trigger").dropdown();
// carou
$('.carousel.carousel-slider').carousel({
    fullWidth: true,
    indicators: true,
    next: 7
});
setInterval(function () {
    $('.carousel').carousel('next');
}, 7000);
//définition du datepicker
$('.datepicker').datepicker({
    i18n: {
        selectMonths: true,
        selectYears: 2,
        firstDay: 1,
        months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthsShort: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        weekdays: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        weekdaysShort: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        weekdaysAbbrev: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
        today: 'Aujourd\'hui',
        clear: 'Réinitialiser',
        cancel: 'Fermer'
    },
    format: 'dd/mm/yyyy',
    container: 'body'
});