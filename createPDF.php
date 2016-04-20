<html>
<body>
Use http://www.onmyfeet.net/survey2/pdf/file-create.php instead. For example, <a href="http://www.onmyfeet.net/survey2/pdf/file-create.php?name=1">http://www.onmyfeet.net/survey2/pdf/file-create.php?name=1</a>.
</body>
</html>

<?php
/*require 'pdfconverter/pdfcrowd.php';
include("db_connect.php");
$evaluatorid = $_GET['evaluatorid'];
$evalueeid = $_GET['evalueeid'];
$result = mysql_fetch_array(mysql_query("SELECT * FROM observation WHERE evaluatorSelect ='$evaluatorid' AND evalueeid='$evalueeid'"));
if($result['q1']==0){
    $q1 = "Yes (Proceed with Evaluation)";
}else{
    $q1 = "No (Terminate the Evaluation)";
}
$evalueeName=changeIdToName($evalueeid,"evaluees");

if($result['q5']==0){
    $q2 = "Yes";
}else{
    $q2 = "No";
}

if($result['q6']==0){
    $q3 = "Teacher";
}elseif($result['q6']==1){
    $q3 = "Guidance Services";
}elseif($result['q6']==2){
    $q3 = "Media Services";
}else{
    $q3 = "School Nurse";
}

if($result['q7']==0){
    $q4 = "Formative Long Observation ";
}elseif($result['q7']==1){
    $q4 = "Formative Short Observation (Teacher Only) ";
}elseif($result['q7']==2){
    $q4 = "Student Growth Objective";
}else{
    $q4 = "ABA Teacher";
}

function changeIdToName($id, $tbl_name){
    $temp = mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE id='$id'"));
    return strtoupper($temp['last']).",".strtoupper($temp['first']);
}
function changeNameToId($name, $tbl_name){
    $last = substr($name, 0, strpos($name, ","));
    $first = substr($name, strpos($name,",")+1);
    return mysql_fetch_array(mysql_query("SELECT * FROM $tbl_name WHERE UPPER(first) = UPPER('$first') AND UPPER(last) = UPPER('$last')"))['id'];
}
function alterScore($score){
    return 4-$score;
}
$q5 = $result['q8'];
switch($result['startTime']){
    case 0:
        $q6 = "7:30 AM";
        break;
    case 1:
        $q6 = "8:00 AM";
        break;
    case 2:
        $q6 = "8:30 AM";
        break;
    case 3:
        $q6 = "9:00 AM";
        break;
    case 4:
        $q6 = "9:30 AM";
        break;
    case 5:
        $q6 = "10:00 AM";
        break;
    case 6:
        $q6 = "10:30 AM";
        break;
    case 7:
        $q6 = "11:00 AM";
        break;
    case 8:
        $q6 = "11:30 AM";
        break;
    case 9:
        $q6 = "12 Noon";
        break;
    case 10:
        $q6 = "12:30 PM";
        break;
    case 11:
        $q6 = "1:00 PM";
        break;
    case 12:
        $q6 = "1:30 PM";
        break;
    case 13:
        $q6 = "2:00 PM";
        break;
    case 14:
        $q6 = "2:30 PM";
        break;
    case 15:
        $q6 = "3:00 PM";
        break;
    case 16:
        $q6 = "3:30 PM";
        break;
    case 17:
        $q6 = "4:00 PM";
        break;
}
$q7 = changeIdToName($evaluatorid,"evaluators");
$tobeparsed = json_decode($result['surveyJSON'],true);
for($i=1; $i<23;$i++){
    $temp = "q".$i;
    $q[$i]=4- $tobeparsed[$temp];
}
if($tobeparsed["q23"]==0){
    $q[23]="Long Observation";
}else{
    $q[23]="Short Observation (Teacher Only)";
}

$page = "<html><head>
<title>Staff Observation Page 1</title>
<style>
.question-title{
    font-weight: bold;
}
body{
    font-family: \"Segoe UI\",\"Trebuchet MS\",Helvetica,Arial,sans-serif;
    font-size:14px;
}
.question{
    background-color: #f9f9f6;;
}
.button{
    display: inline-block;
    text-decoration: none;
    border: 1px solid #dedede;
    border-color: #dedede #d8d8d8 #d3d3d3;
    color: #555;
    box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
    padding: 8px 11px;
    overflow: hidden;
    vertical-align: middle;
    line-height: 16px;
    font-family: \"Open Sans\",\"Segoe UI\",\"FreeSans\",Helvetica,Arial,sans-serif;
    font-size: 14px;
    font-weight: 400;
    background: -webkit-gradient(linear,left top,left bottom,from(#f9f9f9),to(#f0f0f0));
    cursor: pointer;
}
</style>
<style type=\"text/css\"></style>
</head>
<body>
<div class=\"header\">
</div>
<div class=\"questions\">
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">I have read the applicable District certificated staff evaluation protocol, and agree to proceed with the evaluation ? </h2><h4>".$q1."</h4>
        </div>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">Q1: EVALUEE: </h2><h4>".$evalueeName."</h4>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">
                Q4. Date of Observation: </h2><h4>".$q5."
            </h4>
        </div>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">
                Q5. Start Time of Observation: </h2><h4>".$q6."
            </h4>
        </div>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">
                Q6. WHO IS the EVALUATOR: </h2><h4>".$q7."
            </h4>
        </div>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 1 Total Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ts1\">".($q[1]+$q[2]+$q[3]+$q[4]+$q[5]+$q[6])."</h4>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 1 Mean Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ms1\">".(($q[1]+$q[2]+$q[3]+$q[4]+$q[5]+$q[6])/6)."</h4>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">Standard 1: Comments:</h2>
        </div>
        <h4> 
        ".$tobeparsed["qi1"]."
        </h4>
        <br>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 2 Total Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ts2\">".($q[7]+$q[8]+$q[9]+$q[10]+$q[11]+$q[12]+$q[13]+$q[14]+$q[15])."</h4>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 2 Mean Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ms2\">".(($q[7]+$q[8]+$q[9]+$q[10]+$q[11]+$q[12]+$q[13]+$q[14]+$q[15])/9)."</h4>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">Standard 2: Comments:</h2>
        </div>
        <h4>
        ".$tobeparsed["qi2"]."
        </h4>
        <br>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 3 Total Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ts3\">".($q[16]+$q[17]+$q[18]+$q[19]+$q[20])."</h4>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 3 Mean Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ms3\">".(($q[16]+$q[17]+$q[18]+$q[19]+$q[20])/5)."</h4>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">Standard 3: Comments:</h2>
        </div>
        <h4>
        ".$tobeparsed["qi3"]."
        </h4>
        <br>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 4 Total Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ts4\">".($q[21]+$q[22])."</h4>
    </div>
    <div class=\"question\" style=\"width:50%; display:inline;\">
        <h4 class=\"question-title\" style=\"display:inline;\">Std. 4 Mean Score:</h4><h4 class=\"question-title\" style=\"display:inline;\" id=\"ms4\">".(($q[21]+$q[22])/2)."</h4><p id=\"tn4\" style=\"display:none\" >0</p>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">Standard 4: Comments:</h2>
        </div>
        <h4> 
".$tobeparsed["qi4"]."
        </h4>
        <br>
    </div>
    <div class=\"question\">
        <div class=\"question-header\">
            <h2 class=\"question-title\">Your Recommendation for Next Observation</h2>
            <h4>
".$q[23]."
            </h4>
        </div>
    </div>
</div>
</body></html>";
try
{   
    // create an API client instance
    $client = new Pdfcrowd("jasonbao", "fb44ffb68368db54757d2b25515f2806");

    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertHTML($page);

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"observation.pdf\"");

    // send the generated PDF 
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>*/