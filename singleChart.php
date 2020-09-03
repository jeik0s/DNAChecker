<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>

    </style>
    <title>Hello, world!</title>
  </head>
  <body>

    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <br/>
            <br/>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <br/>
            <br/>
        <div id="DNAchanges">DNA CODE</div>
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
        text: "Single Try"
    },
    axisY: {
        title: "Number of generations",
        titleFontSize: 24,
        prefix: "G"
    },
    data: [{
        type: "stepLine",
        yValueFormatString: "###",
        dataPoints: dataPoints
    }]
});

 
function addData(data) {

    const queryString = window.location.search;
    ChartNo = queryString.split("=")
    ChartNo = ChartNo[1]
    console.log(ChartNo);
    
    var gooddna = data["HealthyDNA"].split("");
    TableOFChanges = [];
    var dps = data["Data"];
    console.log(dps[0])
    interval = 0;

    Object.entries(dps[0]).forEach(([key, value]) => {interval++;});

        dataPoints.push({
            x: 0,
            y: 0
        });

    for (var i = interval-1; i > 0; i--) {
        

        var baddna = dps[ChartNo][i-1]["Changed"].split("");
        for(j=0;j<gooddna.length;j++){
            if(gooddna[j] != baddna[j]){
                baddna[j] = "<b style='color:red;'>"+baddna[j]+"</b>"
            }
            baddnaString = baddna.join('')
        }
            TableOFChanges.push(baddnaString)



        dataPoints.push({
            x: interval-i,
            y: dps[ChartNo][i-1]["Generation"]
        });
    }

    chart.render();

    var gooddna = data["HealthyDNA"].split("");
    var baddna = data["UnhealthyDNA"].split("");
    for(j=0;j<gooddna.length;j++){
        if(gooddna[j] != baddna[j]){
            gooddna[j] = "<b style='color: blue'>"+gooddna[j]+"</b>"
        }
        gooddnaString = gooddna.join('')
    }


    paragraf = "<p>" + gooddnaString + "</p>"
    TableOFChanges.forEach(element => paragraf = paragraf + "<p>" + element + "</p>");
    document.getElementById("DNAchanges").innerHTML = paragraf;
    // console.log(paragraf)


}
 
$.getJSON("output.json", addData);

}
    


    </script>

</body>
</html>