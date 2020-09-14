<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body{
            overflow-x: hidden;
        }
        .row{
            padding-top: 1%;;
            text-align: center;
        }

        .row .col-3{
            height: 150px;
            text-align: center;
            vertical-align: middle;
            line-height: 150px; 
        }

        .row .col-3:nth-child(1){
            background-color: lightcyan;
        }

        .row .col-3:nth-child(2){
            background-color:lightgrey;
        }

        .row .col-3:nth-child(3){
            background-color:lightskyblue;
        }

        .row .col-3:nth-child(4){
            background-color: lightyellow;
        }

        .leftside{
            float: left;
        }
        #blueBold{
            color: blue;
        }
        #redBold{
            color: red;
        }
    </style>
    <title>Hello, world!</title>
  </head>
  <body>

    <div class="row">
        <div class="col-3">All Generations</div>
        <div class="col-3">All Ones Generations</div>
        <div class="col-3">100%<</div>
        <div class="col-3">General information</div>
      </div>

    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            Amount of populations
            <br/>
            <br/>
 <table style="width:100%">
      <tr>
        <th>DNA diffrences</th>
      </tr>
      <tr>
        <td  id="goodDNA"></td>
      </tr>
      <tr>
        <td id="badDNA"></td>
      </tr>
    </table> 
        <br />
        <br />
        <br />
        <div class="leftside">Number of populations: <div id="NumberOfPopulation"></div></div>
        <div class="leftside" style="margin-left: 50px;">Elements in populations: <div id="ElementsInPopulation"></div></div>
        <div class="leftside" style="margin-left: 50px;">Number of generations below 100: <div id="belowOneHundred"></div></div>
        <div class="leftside" style="margin-left: 50px;">Number of generations below 100 in %: <div id="belowOneHundredInPercentage"></div></div>
        <div class="leftside" style="margin-left: 50px;">The lowest generation needed: 
            <div id="TheLessNeededOne">
            </div>
             [ <i id="TheLessNeededOneIndex"></i> ]
        </div>
        
        <div class="leftside" style="margin-left: 50px;">The higest generation needed: 
            <div id="TheMostNeededOne">
            </div>

             [ <i id="TheMostNeededOneIndex"></i> ]

        </div>


        </div>
        <div class="col-1"></div>
        <div class="col-4" style="margin-top: 30px;">Check individual try: <input type="number" id="ChartNo"><button onclick="showSingleTry()">Submit</button></div>
    </div>  

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

    <script>
window.onload = function() {
 
var dataPoints = [];
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    zoomEnabled: true,
    title: {
        text: "AI Generations"
    },
    axisY: {
        title: "Number of generations",
        titleFontSize: 24,
        prefix: "G"
    },
    data: [{
        type: "line",
        yValueFormatString: "###",
        dataPoints: dataPoints
    }]
});


function findDiff(str1, str2){ 
  let diff= "";
  str2.split('').forEach(function(val, i){
    if (val != str1.charAt(i))
      diff += val ;         
  });
  return diff;
}

 
function addData(data) {



    var gooddna = data["HealthyDNA"].split("");
    var baddna = data["UnhealthyDNA"].split("");
    var gooddnaString = ""
    var baddnaString = ""

    
    for(i=0;i<gooddna.length;i++){
        if(gooddna[i] != baddna[i]){
            gooddna[i] = "<b id='blueBold'>"+gooddna[i]+"</b>"
            baddna[i] = "<b id='redBold'>"+baddna[i]+"</b>"
        }
        gooddnaString = gooddna.join('')
        baddnaString = baddna.join('')
    }

    document.getElementById("goodDNA").innerHTML = gooddnaString;
    document.getElementById("badDNA").innerHTML = baddnaString;
    belowOneHundred = 0;
    TheMostNeededOne = 0;
    belowOneHundredInPercentage = 0.0;
    TheMostNeededOneIndex = 0;
    TheLessNeededOne = 1000;
    TheLessNeededOneIndex = 1000;

    document.getElementById("NumberOfPopulation").innerHTML = data["NumberOfPopulation"];
    document.getElementById("ElementsInPopulation").innerHTML = data["ElementsInPopulation"];
    var dps = data["Data"];
    for (var i = 0; i < data["NumberOfPopulation"]; i++) {
    // console.log(dps[i]["0"]["Generation"])
    if(dps[i]["0"]["Generation"] < 101)
        belowOneHundred++;

    if(TheMostNeededOne < dps[i]["0"]["Generation"]){
        TheMostNeededOne = dps[i]["0"]["Generation"]
        TheMostNeededOneIndex = i;
    }


    if(TheLessNeededOne > dps[i]["0"]["Generation"]){
        TheLessNeededOne = dps[i]["0"]["Generation"]
        TheLessNeededOneIndex = i;
    }

        dataPoints.push({
            x: i,
            y: dps[i]["0"]["Generation"]
        });
    }

    belowOneHundredInPercentage = belowOneHundred / data["NumberOfPopulation"] * 100

    document.getElementById("belowOneHundred").innerHTML = belowOneHundred;
    document.getElementById("TheMostNeededOne").innerHTML = TheMostNeededOne;
    document.getElementById("TheLessNeededOne").innerHTML = TheLessNeededOne;
    console.log(TheLessNeededOneIndex)
    console.log(TheMostNeededOneIndex)
    document.getElementById("TheLessNeededOneIndex").innerHTML = TheLessNeededOneIndex;
    document.getElementById("TheMostNeededOneIndex").innerHTML = TheMostNeededOneIndex;
    document.getElementById("belowOneHundredInPercentage").innerHTML = belowOneHundredInPercentage.toFixed(2) + "%";
    chart.render();
}
 

$.getJSON("output.json", addData);

 
}

function showSingleTry(){
    var ChartNo = $("#ChartNo").val();
    window.location.href = '/singleChart.php?chartNo='+ChartNo;
}

    </script>

</body>
</html>