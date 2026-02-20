$(document).ready(function() {

	var doc = new jsPDF('p', 'pt', 'letter');
	var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {
    doc.fromHTML($('#report').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    var filename=document.getElementById('budget_name').value;
    doc.save(filename+'.pdf');
});
});

function printPage()
	{
		   var html="<html>";
		   html+= document.getElementById('report').innerHTML;

		   html+="</html>";

		   var printWin = window.open('','','left=0,top=0,toolbar=0,scrollbars=0,status  =0');
		   printWin.document.write(html);
		   printWin.document.close();
		   printWin.focus();
		   printWin.print();
		   printWin.close();
	}