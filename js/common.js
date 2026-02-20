$(document).ready(function() {

$('#datepick').mask('99/99/9999');
				$('#datepick').datepicker({
					dateFormat: 'dd/mm/yy',
					changeMonth: true,
					
					changeYear: true,
					//yearRange: "1930:2010",
					//dayNames: ['Domenica', 'Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato'],
				//	dayNamesMin: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
					//dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
		//			monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
				//	monthNames: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'],
				//	monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'],
					firstDay: 1,
					gotoCurrent:true,
					showOn: 'both',
					showAnim: 'fadeIn',
					showOptions: {duration: 300},
					buttonImage: 'images/icons/calendar.png',
				//	buttonText: 'Clicca qui per visualizzare il calendario',
					//buttonImageOnly: true
		     	});
				
$('#datepick1').mask('99/99/9999');
				$('#datepick1').datepicker({
					dateFormat: 'dd/mm/yy',
					changeMonth: true,
					
					changeYear: true,
					//yearRange: "1930:2010",
					//dayNames: ['Domenica', 'Lunedi', 'Martedi', 'Mercoledi', 'Giovedi', 'Venerdi', 'Sabato'],
				//	dayNamesMin: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
					//dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
		//			monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
				//	monthNames: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'],
				//	monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'],
					firstDay: 1,
					gotoCurrent:true,
					showOn: 'both',
					showAnim: 'fadeIn',
					showOptions: {duration: 300},
					buttonImage: 'images/icons/calendar.png',
				//	buttonText: 'Clicca qui per visualizzare il calendario',
					//buttonImageOnly: true
		     	});
	
/*$(function() {
    $( "#datePick" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:2010",
        showOn: "both",
        buttonImage: "/datepicker/calendar.gif",
        buttonImageOnly: true,
        dateFormat: "dd-mm-yy"
    });
});

$(function() {
    $.mask.masks = $.extend($.mask.masks,{
        date: { mask : "39-19-9999" }
    });
});
$(function() {
    $( "#datePick" ).setMask();
});


$('#datepick').DatePicker({

	flat: true,
	date: '2008-07-31',
	current: '2008-07-31',
	calendars: 1,
	starts: 1
});

$('#datepick').Zebra_DatePicker({
  view: 'years'
});*/
});