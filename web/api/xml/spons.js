// JavaScript Document

window.onload = function xml()
{

var spons = "<tr><th><h2>Naam</h2></th><th><h2>Omscrhijving</h2></th><th><h2>LINK</h2></th><th><h2>IMAGE</h2></th></tr>";

	if (window.XMLHttpRequest)
		{
		 xmlhttp=new XMLHttpRequest();
		}
	else
		{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	xmlhttp.open("GET","spons.xml",false);
	xmlhttp.send();
	var data=xmlhttp.responseXML;

	//console.log(data);

	var SPO = data.getElementsByTagName('Sponsers')[0].getElementsByTagName('SPONSER');
var x=data.getElementsByTagName("SPONSER");
for (i=0;i<x.length;i++)
	{
		var text = '<tr><td id="name"> ' + SPO[i].getElementsByTagName('NAME')[0].innerHTML;
		text+= '</td><td id="beschrijving">' + SPO[i].getElementsByTagName('BESCHRIJVING')[0].innerHTML;
		text+= '</td><td id="link">' + SPO[i].getElementsByTagName('LINK')[0].innerHTML;
		text+= '</td><td id="image">' + SPO[i].getElementsByTagName('IMAGE')[0].innerHTML + "</td></tr>";
		//console.log(text);
		spons+= text;
	}
	document.getElementById('spons').innerHTML = spons;
}
