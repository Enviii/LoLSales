<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

// $ch = curl_init();
// $fp = fopen("output.html", "w");

// $url="http://na.leagueoflegends.com/en/news/store/sales/champion-and-skin-sale-0325-0328";

// curl_setopt($ch, CURLOPT_URL, $url);
// //curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_FILE, $fp);

// if (curl_error($ch))
//     die(curl_error($ch));

// $output = curl_exec($ch);
// fwrite($fp, $output);

// curl_close($ch);
// fclose($fp);

$doc = new DOMDocument();
$doc->loadHTMLFile("output.html");
$xpath = new DOMXPath($doc);

//get entire div that contains a ton of messy crap
$entireText = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]');
foreach ($entireText as $text) {
    $cleanText = mb_convert_encoding($text->textContent, 'HTML-ENTITIES', 'UTF-8');
    $cleanText = str_replace("&nbsp;", '', $cleanText);
    //echo $cleanText;

	$explodedText = preg_split('/[\s]+/', $cleanText);
    foreach ($explodedText as $key => $value) {
    	//echo $key." - ".$value."<br>";
    }
}

echo "<br>";

//get h4 with skin champ names
$skinArr = array();
$skinName = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]/h4');
foreach ($skinName as $skin) {
	//var_dump($skin->textContent);
	$skinArr[]=$skin->textContent;

	// split with " " so i can unset from explodedTest
    $explodedSkin = explode(" ", $skin->textContent);
    foreach ($explodedSkin as $key => $value) {
    	//echo $key." - ".$value."<br>";
    	unset($explodedText[array_search($value,$explodedText)]);
    }
}

echo "<br>";

//get striked out prices
$skinXprice = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]/strike');
foreach ($skinXprice as $xprice) {
    //var_dump($xprice->textContent);
    //printf($tag->textContent);
    //echo $tag->textContent;
}
echo "<br>";

//get skin img
$imgArr = array();
$skinImg = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]/div[@class="gs-container default-2-col"]/div/span/a/@href');
foreach ($skinImg as $img) {
    //var_dump($img->textContent);
    $imgArr[]=$img->textContent;
    //printf($tag->textContent);
    //echo $tag->textContent;
}
echo "<br>";

//get skin img
$champArr = array();
$champImg = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]/div[@class="gs-container default-3-col"]/div/span/a/img/@src');
foreach ($champImg as $champ) {
    //var_dump($champ->textContent);
    $champArr[]=$champ->textContent;
    //printf($tag->textContent);
    //echo $tag->textContent;
}
echo "<br>";

//Get rid of the meaningless text. Split and unset it from explodedTest
$grabText = "Grab these champions and skins on sale for 50% off for a limited time: Skin SalesGive your champions a new look with these skins: RPChampion SalesAdd these champions to your roster: RP RP RP RP RP ";
$grabSplit = explode(" ", $grabText);
foreach ($grabSplit as $key => $value) {
	unset($explodedText[array_search($value,$explodedText)]);
}

//echo explodedTest to see final values
$explodedText = array_values($explodedText);
foreach ($explodedText as $key => $value) {
	echo $key." - ".$value."<br>";
}

/////////////////////////////////////////
////////////////////////////////////////
//////////final results here///////////
///////////////////////////////////////
//////////////////////////////////////
echo "<br>";
echo "<br>";

printf("Champion: ".$explodedText[6] ." Original Price: ". $explodedText[7] ." Sale Price: ". $explodedText[8] ." <img height='150' src=".$champArr[0]."> ");
echo "<br>";
printf("Champion: ".$explodedText[9] ." Original Price: ". $explodedText[10] ." Sale Price: ". $explodedText[11]." <img height='150' src=".$champArr[1]."> ");
echo "<br>";
printf("Champion: ".$explodedText[12] ." Original Price: ". $explodedText[13] ." Sale Price: ". $explodedText[14]." <img height='150' src=".$champArr[2]."> ");

echo "<br>";
echo "<br>";
echo "<br>";

printf("Skin: ".$skinArr[0] ." Original Price: ". $explodedText[0] ." Sale Price: ". $explodedText[1] ." <img height='100' src=".$imgArr[0]."> <img height='100' src=".$imgArr[1]."> ");
echo "<br>";
echo "<br>";
echo "<br>";
printf("Skin: ".$skinArr[1] ." Original Price: ". $explodedText[2] ." Sale Price: ". $explodedText[3] ." <img height='100' src=".$imgArr[2]."> <img height='100' src=".$imgArr[3]."> ");
echo "<br>";
echo "<br>";
echo "<br>";
printf("Skin: ".$skinArr[2] ." Original Price: ". $explodedText[4] ." Sale Price: ". $explodedText[5] ." <img height='100' src=".$imgArr[4]."> <img height='100' src=".$imgArr[5]."> ");




echo "<br>";
echo "<br>";







//messy foreach

// $index = 0;
// foreach ($skinName as $key => $value) {
// 	echo "Skin ".$value->textContent." Original Price: ".$explodedText[$index];
// 	echo "<img height='150' src=".$imgArr[$index].">";
// 	$index+=1;
// 	echo " Sale Price: ".$explodedText[$index];
// 	echo "<img height='150' src=".$imgArr[$index].">";
// 	echo "<br>";
// 	$index+=1;
// }

// $index2=0;
// foreach ($skinName as $key => $value) {
// 	echo $skinArr[$index2].$explodedText[$index2].$imgArr[$index2];
// 	$index+=1;
// 	echo $skinArr[$index2].$explodedText[$index2].$imgArr[$index2];
// }




/////////////////////////////////////////////////////////
///////////get start and end date from url///////////////

preg_match("/(?P<text>\.*)sale-(?P<date1>\d{4})-(?P<date2>\d{4})/", "http://na.leagueoflegends.com/en/news/store/sales/champion-and-skin-sale-0325-0328", $results);


$startFirst2 = substr($results[2], 0, 2);
$startTheRest = substr($results[2], 2);
$endFirst2 = substr($results[3], 0, 2);
$endTheRest = substr($results[3], 2);
echo "<br>";

$startDate = date("Y")."-".$startFirst2."-".$startTheRest;
$endDate = date("Y")."-".$endFirst2."-".$endTheRest;

echo "<br>";
echo "Start Date: ".$startDate;
echo "<br>";
echo "End Date: ".$endDate;
?>