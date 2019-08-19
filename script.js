
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
function goBack() 
{
    window.history.back()
}

function typeSelect() 
{
    var list = document.getElementById("selected_type");
    var selected = list.options[list.selectedIndex].value;
    var type = selected.split('|');

    /* pola do uzupełniania */
    var name = document.createElement("input");
    name.setAttribute('type','text');
    name.setAttribute('id','name');
    name.setAttribute('name','name');
    name.required = "required";
    
    var name2 = document.createElement("input");
    name2.setAttribute('type','text');
    name2.setAttribute('id','name2');
    name2.setAttribute('name','name2');

    var lastname = document.createElement("input");
    lastname.setAttribute('type','text');
    lastname.setAttribute('id','lastname');
    lastname.setAttribute('name','lastname');

    var number = document.createElement("input");
    number.setAttribute('type','number');
    number.setAttribute('id','number');
    number.setAttribute('name','number');
    number.setAttribute('min',1);

    switch(type[0])
    {
        case 'Identyfikator bezstrefowy':
            document.getElementById("zone").style.display = 'none';
            document.getElementById("add").style.display = ''; 

            document.getElementById('demo').innerHTML = '<h2>Imię:</h2>';
            document.getElementById('demo').appendChild(name);
            document.getElementById('demo').innerHTML += '<h2>Nazwisko:</h2>';
            document.getElementById('demo').appendChild(name2);
            document.getElementById('demo').innerHTML += '<h2>Nazwa:</h2>';
            document.getElementById('demo').appendChild(lastname);
            document.getElementById('demo').innerHTML += '<h2>Ilość:</h2>';
            document.getElementById('demo').appendChild(number);
        break;
        
        case 'Identyfikator strefowy':

            document.getElementById("zone").style.display = '';   
            document.getElementById("add").style.display = '';

            document.getElementById('demo').innerHTML = '<h2>Imię:</h2>';
            document.getElementById('demo').appendChild(name);
            document.getElementById('demo').innerHTML += '<h2>Nazwisko:</h2>';
            document.getElementById('demo').appendChild(name2);
            document.getElementById('demo').innerHTML += '<h2>Nazwa:</h2>';
            document.getElementById('demo').appendChild(lastname);
            document.getElementById('demo').innerHTML += '<h2>Ilość:</h2>';
            document.getElementById('demo').appendChild(number);
        break;

        case 'Wjazdówka':
            document.getElementById("zone").style.display = 'none'; 
            document.getElementById("add").style.display = '';

            document.getElementById('demo').innerHTML = '<h2>Numer rejestracyjny:</h2>';
            document.getElementById('demo').appendChild(name);
        break;

        default:
            document.getElementById("zone").style.display = 'none'; 
            document.getElementById('demo').innerHTML = '';
            document.getElementById("add").style.display = 'none';
    }

}