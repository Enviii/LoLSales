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
echo "<br><br>";
$xpath = new DOMXPath($doc);

//get entire div that contains a ton of messy crap
$entireText = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]');
foreach ($entireText as $text) {
    $cleanText = mb_convert_encoding($text->textContent, 'HTML-ENTITIES', 'UTF-8');
    $cleanText = str_replace("&nbsp;", '', $cleanText);
    //echo $cleanText;

	$explodedText = preg_split('/[\s]+/', $cleanText);
    foreach ($explodedText as $key => $value) {
    	echo $key." - ".$value."<br>";
    }
}

echo "<br>";

//get h4 with skin champ names
$skinName = $xpath->query('//div[@class="field field-name-body field-type-text-with-summary field-label-hidden"]/h4');
foreach ($skinName as $skin) {
	//var_dump($skin->textContent);

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


printf("Champion: ".$explodedText[6] ." Original Price: ". $explodedText[7] ." Sale Price: ". $explodedText[8]);
echo "<br>";
printf("Champion: ".$explodedText[9] ." Original Price: ". $explodedText[10] ." Sale Price: ". $explodedText[11]);
echo "<br>";
printf("Champion: ".$explodedText[12] ." Original Price: ". $explodedText[13] ." Sale Price: ". $explodedText[14]);

echo "<br>";
echo "<br>";

$index = 0;
foreach ($skinName as $key => $value) {
	echo "Skin ".$value->textContent." Original Price: ".$explodedText[$index];
	$index+=1;
	echo " Sale Price: ".$explodedText[$index];
	echo "<br>";
	$index+=1;
}





?>