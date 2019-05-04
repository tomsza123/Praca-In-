function typeSelect() 
{
    var x = document.getElementById("selected_type").value;
    var y = x.split("|");
    var x = y[0];
    document.getElementById("demo").innerHTML = x;

    switch(x)
    {
        case "":
            document.getElementById("zone").style.display = 'none';
            document.getElementById("drive").style.display = 'none';
            document.getElementById("nonzone").style.display = 'none';
            document.getElementById("form").innerHTML =''; 
        break
        case "Identyfikator bezstrefowy":
            
            document.getElementById("zone").style.display = 'none';
            document.getElementById("drive").style.display = 'none';
            document.getElementById("nonzone").style.display = '';
            
            break;
        case "Identyfikator strefowy":
            
            document.getElementById("zone").style.display = '';
            document.getElementById("drive").style.display = 'none';
            document.getElementById("nonzone").style.display = 'none';
            
            break;
        case "Wjazdówka":
            
            document.getElementById("zone").style.display = 'none';
            document.getElementById("drive").style.display = '';
            document.getElementById("nonzone").style.display = 'none';
            
            break;
        default:return;
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