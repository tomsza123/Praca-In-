
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
    name.setAttribute('oninput','update();');
    name.required = "required";
    
    var name2 = document.createElement("input");
    name2.setAttribute('type','text');
    name2.setAttribute('id','name2');
    name2.setAttribute('name','name2');
    name2.setAttribute('oninput','update();');

    var lastname = document.createElement("input");
    lastname.setAttribute('type','text');
    lastname.setAttribute('id','lastname');
    lastname.setAttribute('name','lastname');
    lastname.setAttribute('oninput','update();');

    var number = document.createElement("input");
    number.setAttribute('type','number');
    number.setAttribute('id','number');
    number.setAttribute('name','number');
    number.setAttribute('min',1);
    
    if(window.location.pathname == '/edit_ident.php')
    {
        name.setAttribute('value', name_value);  
        name2.setAttribute('value', name2_value); 
        lastname.setAttribute('value', lastname_value);
    }

    
    //console.log(name)

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
            if(window.location.pathname == '/add_ident.php')
            {
                document.getElementById('demo').innerHTML += '<h2>Ilość:</h2>';
                document.getElementById('demo').appendChild(number);
            }
            
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
            if(window.location.pathname == '/add_ident.php')
            {
                document.getElementById('demo').innerHTML += '<h2>Ilość:</h2>';
                document.getElementById('demo').appendChild(number);
            }
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
function update() 
{
    if(document.getElementById('name'))
    {
        name_value = document.getElementById("name").value;document.getElementById('name').setAttribute('value', name_value);
    }
    if(document.getElementById('name2'))
    {
        name2_value = document.getElementById("name2").value;document.getElementById('name2').setAttribute('value', name2_value);
    }
    if(document.getElementById('lastname'))
    {
        lastname_value = document.getElementById("lastname").value;document.getElementById('lastname').setAttribute('value', lastname_value);
    }
}

/* function identType()
{
    var type = document.getElementById("ident_type_2").value;
    
    if(type == 'Identyfikator strefowy')
    {
        document.getElementById("zone").style.display = "initial";
    }
    else
    {
        document.getElementById("zone").style.display = "none";
    }
}
 */