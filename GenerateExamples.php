#!/usr/bin/php
<?php

/**
 * Doxygen PDF Stylesheets
 * 
 * Helper file to automatically generate examples on how the different templates look.
 * Generates for every .tex file a corresponding .pdf and .jpg file.
 * 
 * @author Martin Theobald <m.theobald@harbour-island.com>
 * 
 * */
$fp = popen('find . -name "*.tex"','r');
$data = file_get_contents('../Stylesheetexamplemaker/doxyfile.template');
chdir ('../Stylesheetexamplemaker');
while ($file = fgets($fp)) {
	$fx = fopen("doxyfile","w");
	fputs($fx,str_replace("XXYXXYXXY","../Doxygen-PDF-Stylesheets/".substr($file,1),$data));	
	fclose($fx);
	
	$fx = popen("doxygen","r");
	while($l = fgets($fx)) {
		echo $l;
	}
	pclose ($fx);
	
	chdir("doc/latex");
	$fx = popen("make pdf","r");
	while($l = fgets($fx)) {
		echo $l;
	}
	pclose ($fx);
	$fx = popen("convert refman.pdf refman.jpg","r");
	while($l = fgets($fx)) {
		echo $l;
	}
	pclose ($fx);
	
	rename ("refman.pdf","../../../Doxygen-PDF-Stylesheets/".substr($file,1,-4)."pdf");
	rename ("refman-0.jpg","../../../Doxygen-PDF-Stylesheets/".substr($file,1,-4)."jpg");
	chdir ("../..");
}
pclose($fp);


