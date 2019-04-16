<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome to CodeIgniter</title>
    <script src="/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="font_awesome/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Gudea|Hammersmith+One|Kaushan+Script|Lobster|Open+Sans" rel="stylesheet">

	<style type="text/css">

	/*::selection { background-color: #E13300; color: white; }*/
	/*::-moz-selection { background-color: #E13300; color: white; }*/

	body {
        /*font: 13px/20px normal Helvetica, Arial, sans-serif;*/
        /*background-color: #3e94ec;*/
        font-family: "Roboto", helvetica, arial, sans-serif;

        background-color: #f0f0f3;
        background-image: linear-gradient(90deg, transparent 50%, rgba(255,255,255,.5) 50%);
        background-size: 50px 50px;
        margin-top: 0;
        margin-left: 0;
        margin-right: 0;
	}
    
	/*code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}*/
	#container {
		margin: auto;
        width: 90%;
		/*border: 1px solid #D0D0D0;*/
		/*box-shadow: 0 0 8px #D0D0D0;*/
        /*text-align: center;*/
        min-height: 75vh;
        vertical-align: top;
        display: table;
	}
    
    #lewy {
        /*min-height: 70vh;*/
        width: 45%;
        /*border: 1px solid greenyellow;*/
        margin: auto;
        /*display: inline-block;*/
        display: table-cell;
        text-align: center;
    }
    #lewy p{
        margin: 0;
    }

    #prawy p{
        margin: 0;
    }

    #prawy {
        /*min-height: 70vh;*/
        width: 45%;
        /*border: 1px solid blueviolet;*/
        margin: 0;
        /*display: inline-block;*/
        display: table-cell;
        text-align: center;
    }

    #szukanie {
        width: 100%;
        /*border: 1px solid crimson;*/
        margin: auto;
        margin-top: 0;
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        background-color: rgba(67,67,67, 0.7);
        border-bottom: 4px solid #f2ceb9;
    }
        
    #tab_elementy {
        /*border: 1px solid red;*/
        width: 95%;
        border-collapse: collapse;
        padding-left: 2px;
        padding-right: 2px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        margin: auto;
        margin-top: 5px;
    }

    #tab_elementy tr td {
        background:#FFFFFF;
        padding-left: 2px;
        padding-right: 2px;
        padding-top: 4px;
        padding-bottom: 4px;
        border-right: 1px solid #4F5155;
        text-align: left;
        margin-left: 4px;
    }

    
    #tab_elementy tr td:nth-child(2) {
        font-weight: bold;
        text-align: center;
    }
    
    #tab_elementy tr td:nth-child(3) {
        color: green;
        font-weight: bold;
        text-align: center;
    }

    #tab_elementy tr td:last-child  {
        border-right: 0px;
    }

    #tab_elementy tr:nth-child(odd) td {
        /*background:#EBEBEB;*/
        /*background:#f2ceb9;*/
        background: #acbdd3;
    }

    #tab_elementy tr:first-child td {
        
        /*border: 1px solid darkseagreen;*/
        
        color:#D5DDE5;
        background:#1b1e24;
        
        /*padding-top: 5px;*/
        /*padding-bottom: 5px;*/
        /*font-weight: bold;*/
        /*font-size: 16px;*/
        text-align: center;

        font-size:16px;
        padding:12px;
        /*text-align:left;*/
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        vertical-align:middle;
        border-bottom: 4px solid #5d80b6;
    }

    #tab_elementy tr:first-child td:first-child {
        border-top-left-radius: 8px;
        width: 75vw;
        font-size: 20px;
    }

    #tab_elementy tr:first-child td:last-child {
        border-top-right-radius: 8px;
    }

    #tab_elementy tr:last-child td:first-child {
        border-bottom-left-radius: 1px;
        width: 75vw;
    }

    #tab_elementy tr:last-child td:last-child {
        border-bottom-right-radius: 1px;
    }

    #tab_elementy tr td:last-child a{
        text-decoration: none;
        font-weight: bold;
    }
    
    #tab_elementy tr td:last-child a:first-child{
        color: green;
    }

    h1 {
        color: whitesmoke;
        margin: auto;
        font-weight: normal;
        font-family: Verdana;
        text-shadow: 2px 2px #2f2f2f;
    }
        
    button {
        min-width: 160px;
        min-height: 32px;
        height: 32px;
        font-size: 14px;
        vertical-align: middle;
        background-color: #2b4046;
        font-weight: bold;
        color: #f0f0f3;
        font-family: Arial;
        border: 0;
        cursor:pointer;
    }
    
    button:hover {
        background-color: #f7f8f9;
        color: #2b4046;
    }
        
    input {
        min-height: 30px;
        /*border-radius: 5px;*/
        color: #2f2f2f;
        font-weight: bold;
        background-color: #D5DDE5;
        border: 0;
        font-family: Arial;
        padding-left: 4px;
        padding-right: 4px;
        border-left: 5px solid #5d80b6;
        /*border-right: 5px solid #5d80b6;*/
    }
    
    input#nazwa {
        min-width: 300px;
        border-bottom: 1px solid #aaabac;
    }

    input#dodajacy {
        min-width: 300px;
        /*margin-left: 7px;*/
    }

    input#link_youtube {
        min-width: 300px;
        /*margin-left: 7px;*/
    }
        
    span {
        font-family: Arial;
        color: #2f2f2f;
        font-weight: bold;
    }

    .usun_nazwe {
        min-width: 35px;
        background-color: #dd0000;
        border-right: 5px solid #5d80b6;
    }
    
    #ERROR {
        border: 3px solid #e2bea9;
        background-color: #f2ceb9;
        color: red;
        font-weight: bold;
        text-align: center;
        position: fixed;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        top: 30%;
        padding-bottom: 5px;
        display: none;
    }
    
    #dodaj_wykonawce, #dodaj_utwor{
        border: 2px solid #1b3046;
    }
    
    #info {
        color: #1b50f6;
        margin: auto;
        cursor:pointer;
    }

    #info_box {
        background-color: #bcddf3;
        color: #101e3a;
        z-index: 100;
        display: none;

        position: fixed;
        width: 30%;
        height: 50%;
        margin: 1% auto; /* Will not center vertically and won't work in IE6/7. */
        left: 0;
        right: 0;
        overflow: auto;
    }
    
    #info_box div {
        background-color: #f7f8f9;
        text-align: center;
        overflow: hidden;
        font-size: 2em;
        border-bottom: 2px solid #cbc6c3;
        border-left: 2px solid #cbc6c3;
        border-top: 2px solid #cbc6c3;
    }

    #info_box a {
        display: block;
        float: right;
        background-color: red;
        font-size: 2em;
        color: white;
        padding-left: 10px;
        padding-right: 10px;
        border-bottom: 2px solid #cbc6c3;
        border-right: 2px solid #cbc6c3;
        border-top: 2px solid #cbc6c3;
        cursor:pointer;
    }
    
    #info_box p {
        margin-left: 5px;
        margin-right: 5px;
        text-align: justify;
        font-size: 1.2em;
    }

    @media screen and (max-width: 600px) {
        #nazwa {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }
        
        #szukanie {
            padding-top: 37px;
        }
        
        #usun_nazwe {
            position: absolute;
            top: 0;
            right: 0;
        }
        
        #container {
            display: block;    
            margin: 0;
            width: 100%;
        }
        
        #tab_elementy {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        #tab_elementy tr:first-child td:first-child {
            border-top-left-radius: 0px;
        }

        #tab_elementy tr:first-child td:last-child {
            border-top-right-radius: 0px;
        }
        
        #lewy {
            display: block;
            margin: 0;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        #prawy {
            display: block;
            margin: 0;
            width: 100%;
        }
        
        button {
            width: 48%;
        }
        
        input {
            width: 80%;
            margin: auto;
        }

        input#dodajacy {
            min-width: 0;
            margin: auto;
            margin-top: 10px;
        }

        .usun_nazwe {
            width: 35px;
        }
        
        #info_box {
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0;
        }
    }
    </style>
</head>
<body>
<div id="ERROR">
    <p id="error_msg"></p>
    <button id="error_ok">OK</button>
</div>

<div id="info_box">
    <a id="info_box_zamknij">X</a><div>INFO</div>
    <p><?php echo $napisy['info_box']; ?></p>
</div>

<div id="szukanie">
    <button id="dodaj_wykonawce" name="dodart"><?php echo $napisy['dod_wykonawca']; ?></button><input id="nazwa" type="text" name="szukaj" title="nazwa" value="<?php echo $napisy['szukaj']; ?>"/><button id="usun_nazwe" class="usun_nazwe" value="nazwa">X</button><button id="dodaj_utwor" name="dodutw"><?php echo $napisy['dod_utwor']; ?></button>
    <br />
    <input id="dodajacy" type="text" name="dodajacy" title="dodajacy" value="<?php echo $napisy['osoba']; ?>"/><button class="usun_nazwe" value="dodajacy">X</button></br>
    <input id="link_youtube" type="text" name="link_youtube" title="youtube link" value="<?php echo $napisy['youtube_link']; ?>"/><button class="usun_nazwe" value="link_youtube">X</button></br>
    <div style="margin-bottom: 5px;"></div>
    <a id="info"><i class="fa fa-info-circle fa-3x" aria-hidden="true"></i></a>
    <a style="color: #B01010; cursor:pointer;" title="Lista youtube" href="https://www.youtube.com/watch?v=e7lcimljm3k&list=<?php echo $youtube_list; ?>" target="_blank"><i class="fa fa-youtube fa-3x" aria-hidden="true"></i></a>
</div>

<div id="container">
    <div id="lewy">
    </div>
    <div id="prawy">
    </div>
</div>
<?php echo $widok; ?>

<script>
    function odswiezTabele(request) {
        request.done(function( html ) {
            var parts = html.split('<!--SEP-->');
            $( "#lewy" ).html( parts[0] );
            $( "#prawy" ).html( parts[1] );
        });
    }
    
    function szukajUtwory() {
        var nazwa = $("#nazwa").val();

        var request = $.ajax({
            url: "index.php/Main/szukaj",
            method: "POST",
            data: { nazwa: nazwa }
        });

        odswiezTabele(request);
    }
    
    function dodajElement(rodzaj) {
        if (rodzaj == 'W') {
            skrypt = "index.php/Main/dodajWykonawce";
        } else {
            skrypt = "index.php/Main/dodajUtwor";
        }
        var nazwa = $("#nazwa").val();
        var dodajacy = $("#dodajacy").val();
        var link_youtube = $("#link_youtube").val();

        var request = $.ajax({
            url: skrypt,
            method: "POST",
            data: {
                nazwa: nazwa,
                dodajacy: dodajacy,
                link_youtube: link_youtube
            },
            error: function (jqXHR, exception) {
                $( "#ERROR" ).css("display", "block");
                $( "#error_msg" ).html(jqXHR.responseText);
                szukajUtwory();
            }
        });

        odswiezTabele(request);

        event.preventDefault();
    }

    $( document ).ready(function() {
        szukajUtwory();
        
        $("#nazwa").keyup(function(event) {
            szukajUtwory();
        });
        
        $( "#dodaj_wykonawce" ).click(function( event ) {
            dodajElement("W");
        });

        $( "#dodaj_utwor" ).click(function( event ) {
            dodajElement("U");
        });

        $( "#error_ok" ).click(function( event ) {
            $( "#ERROR" ).css("display", "none");
        });


        $('input:text').click(
            function(){
                staraWart = $(this).val();
                if (staraWart == '<?php echo $napisy['szukaj']; ?>' 
                    || staraWart == '<?php echo $napisy['osoba']; ?>' 
                    || staraWart == '<?php echo $napisy['youtube_link']; ?>') {
                    $(this).val('');
                }
        });

        $(".usun_nazwe").click(
            function(){
                wart=$(this).val();
                $('#'+wart).val('');
        });

        $("#info_box_zamknij").click(
            function(){
                $( "#info_box" ).css("display", "none");
        });

        $("#info").click(
            function(){
                $( "#info_box" ).css("display", "block");
        });
    });

</script>
</body>
</html>