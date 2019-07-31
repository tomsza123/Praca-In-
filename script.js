
function typeSelect() 
{
    var x = document.getElementById("selected_type").value;
    var y = x.split("|");
    var x = y[0];
    document.getElementById("demo").innerHTML = x;

    switch(x)
    {
        case "Pusty":
            
            document.getElementById("zone").style.display = 'none';
            document.getElementById("drive").style.display = 'none';
            document.getElementById("nonzone").style.display = 'none';
            document.getElementById("empty").style.display = '';
            document.getElementById("demo").style.display = 'none';
            document.getElementById("add").style.display = 'none';

            break;
        case "Identyfikator bezstrefowy":
            
            document.getElementById("zone").style.display = 'none';
            document.getElementById("drive").style.display = 'none';
            document.getElementById("nonzone").style.display = '';
            document.getElementById("empty").style.display = 'none';
            document.getElementById("demo").style.display = '';
            document.getElementById("add").style.display = '';
            
            break;
        case "Identyfikator strefowy":
            
            document.getElementById("zone").style.display = '';
            document.getElementById("drive").style.display = 'none';
            document.getElementById("nonzone").style.display = 'none';
            document.getElementById("empty").style.display = 'none';
            document.getElementById("demo").style.display = '';
            document.getElementById("add").style.display = '';
            
            break;
        case "Wjazdówka":
            
            document.getElementById("zone").style.display = 'none';
            document.getElementById("drive").style.display = '';
            document.getElementById("nonzone").style.display = 'none';
            document.getElementById("empty").style.display = 'none';
            document.getElementById("demo").style.display = '';
            document.getElementById("add").style.display = '';
            break;
        //default:
        //    return;

    }
}


$(document).ready(function()
{
    $('.open-menu, .hide').click(function()
    {	
		$('nav').toggleClass('show');		
	});//open click	
});//document ready end


//$( "#selected_type" ).val();
//$( "#selected_type option:selected" ).text();

function toggle(source) 
{
    checkboxes = document.getElementsByName('checkbox[]');

    for(var i=0, n=checkboxes.length;i<n;i++) 
    {
      checkboxes[i].checked = source.checked;
    }
}

function anuluj() 
{
    if (confirm("Czy chcesz zakończyć? \nKliknij OK by zakończyć") == true){
        location.replace('main.php');        
    }
    else{        
    }
}
