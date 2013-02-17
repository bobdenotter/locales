<?php
// No notices, plz. 
error_reporting(E_ALL ^ E_NOTICE);

require_once('countrycodes.php');
require_once('languagecodes.php');

$locale_data = array();
        
//Get locales from Linux terminal command locale
$locales = shell_exec('locale -a');
$locales = explode("\n" , $locales);

// Make a convenient array..
foreach($locales as $locale)
{
    if(!empty($locale))
    {
        list($lc, $encoding) = explode('.' , $locale);
        list($lcode , $ccode) = explode('_' , $lc);
        $lcode = strtolower($lcode);
        
        if (in_array($lcode, array('', 'c', 'posix'))) {
            continue;
        }
        
        $language = $language_codes[$lcode];
        $country = $country_codes[$ccode];

        $locale_data[] = array(
            'locale' => $lc,
            'language' => $language,
            'country' => ucwords(strtolower($country)),
            'encoding' => $encoding,
            'country_code' => $ccode,
            'language_code' => $lcode
        );

    }
}

//echo "<pre>";
//print_r($locale_data);
// echo "</pre>";

// Output them, in a fancy ascii table:
echo "    Locale   Language             Country  \n";
foreach($locale_data as $locale) {
    if ( !in_array($locale['encoding'], array("UTF-8", "utf8"))) {
        continue;
    }
    printf("    %-8s %-20s %-42s %-4s %-4s\n", 
        $locale['locale'], 
        $locale['language'], 
        $locale['country'], 
        $locale['language_code'], 
        $locale['country_code'] 
    );
}
