<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	#container {
		/*margin: auto;*/
		border: 1px solid #D0D0D0;
		/*box-shadow: 0 0 8px #D0D0D0;*/
        /*text-align: center;*/
        /*min-height: 96vh;*/
        /*vertical-align: top;*/
        display: table;
	}
    
    #lewy {
        /*min-height: 73vh;*/
        /*width: 45%;*/
        border: 1px solid greenyellow;
        /*margin: 0;*/
        /*display: inline-block;*/
        display: table-cell;
    }

    #prawy {
        /*min-height: 73vh;*/
        /*width: 45%;*/
        border: 1px solid blueviolet;
        /*margin: 0;*/
        /*display: inline-block;*/
        display: table-cell;
    }
    #szukanie {
        /*min-height: 20vh;*/
        /*width: 95%;*/
        border: 1px solid crimson;
        /*margin: auto;*/
    }
	</style>
</head>
<body>

<div id="container">
        <div id="lewy">
           <p>sdf</p>
        </div><div id="prawy">
<p>
    dfgdfg
    dfgdfg
    dfg
    dfg<br />
    dfgdfgdfg
    dfg
    <br />
    dfgdfg
</p>
        </div>
</div>
<div id="szukanie">
    <input type="text" name="szukaj" title="Szukaj"/>
    <button id="dodaj_artyste" name="dodart" title="Dodanie artysy" >Dodaj artystę</button>
</div>
</body>
</html>