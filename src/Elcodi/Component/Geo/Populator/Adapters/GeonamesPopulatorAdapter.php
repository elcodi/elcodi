<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Geo\Populator\Adapters;

use DateTime;
use Elcodi\Component\Geo\Builder\GeoBuilder;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Mmoreram\Extractor\Extractor;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Populator\Interfaces\PopulatorInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class GeonamesPopulatorAdapter
 *
 * @author Berny Cantos <be@rny.cc>
 */
class GeonamesPopulatorAdapter implements PopulatorInterface
{
    /**
     * @var Extractor
     */
    protected $extractor;

    /**
     * @var GeoBuilder
     */
    protected $geoBuilder;

    /**
     * @param Extractor       $extractor
     * @param GeoBuilder      $geoBuilder
     */
    public function __construct(Extractor $extractor, GeoBuilder $geoBuilder)
    {
        $this->extractor = $extractor;
        $this->geoBuilder = $geoBuilder;
    }

    /**
     * Populate a country
     *
     * @param string $countryCode Country Code
     *
     * @return LocationInterface[]
     */
    public function populate($countryCode)
    {
        $countryCode = strtoupper($countryCode);
        $tempname = $this->downloadFile($countryCode);
        $pathname = $this->extractFile($tempname);
        $locations = $this->loadLocationsFrom($countryCode, $pathname);

        return $locations;
    }

    /**
     * Download data file from country
     * Avoids download if the file exists
     *
     * @param string $countryCode Country code
     *
     * @return string
     */
    protected function downloadFile($countryCode)
    {
        $tempname = sys_get_temp_dir().'/elcodi-locator-geonames-'.$countryCode.'.zip';
        if (!file_exists($tempname)) {

            $dirname = dirname($tempname);
            if (!file_exists($dirname)) {

                mkdir($dirname, 0777, true);
            }
            $downloadUrl = 'http://download.geonames.org/export/zip/'.$countryCode.'.zip';
            copy($downloadUrl, $tempname);
        }

        return $tempname;
    }

    /**
     * Download file and return new pathname of extracted content
     *
     * The geoname's zipfile contains this structure:
     * - {countryCode}.txt
     * - readme.txt
     *
     * We're only interested in the first file.
     *
     * @param string $tempname temporary name for downloaded content
     *
     * @return string Pathname of the resulting file
     */
    protected function extractFile($tempname)
    {
        $extractedFiles = $this
            ->extractor
            ->extractFromFile($tempname)
            ->files()
            ->notName('readme.txt')
            ->getIterator();

        $extractedFiles->rewind();
        if (!$extractedFiles->valid()) {

            throw new FileNotFoundException();
        }

        return $extractedFiles->current();
    }

    /**
     * Extract data from de CSV and create new Location objects
     *
     * @param string $pathname
     *
     * @return LocationInterface[]
     */
    protected function loadLocationsFrom($countryCode, $pathname)
    {
        $country = $this->addCountry($countryCode);

        $interpreter = new Interpreter();
        $interpreter->unstrict();
        $interpreter->addObserver(function (array $columns) use ($country) {

            $state    = $this->addState($columns, $country);
            $province = $this->addProvince($columns, $state);
            $city     = $this->addCity($columns, $province);
            $code     = $this->addPostalCode($columns, $city);
        });

        $config = new LexerConfig();
        $config->setDelimiter("\t");
        $lexer = new Lexer($config);
//        $started = new DateTime();
//        $output->writeln('<header>[Geo]</header> <body>Starting file processing</body>');
        $lexer->parse($pathname, $interpreter);
//        $finished = new DateTime();
//        $elapsed = $finished->diff($started);
//        $output->writeln('<header>[Geo]</header> <body>File processed in '.$elapsed->format('%s').' seconds</body>');

        return [];
    }

    /**
     * Get Country name from country code
     *
     * @return string[] Country code and country name
     */
    protected function getCountryInfo($countryCode)
    {
        $countryNames = [
            "AD" => ["AD", "Andorra"],
            "AE" => ["AE", "United Arab Emirates"],
            "AF" => ["AF", "Afghanistan"],
            "AG" => ["AG", "Antigua and Barbuda"],
            "AI" => ["AI", "Anguilla"],
            "AL" => ["AL", "Albania"],
            "AM" => ["AM", "Armenia"],
            "AO" => ["AO", "Angola"],
            "AQ" => ["AQ", "Antarctica"],
            "AR" => ["AR", "Argentina"],
            "AS" => ["AS", "American Samoa"],
            "AT" => ["AT", "Austria"],
            "AU" => ["AU", "Australia"],
            "AW" => ["AW", "Aruba"],
            "AX" => ["AX", "Åland"],
            "AZ" => ["AZ", "Azerbaijan"],
            "BA" => ["BA", "Bosnia and Herzegovina"],
            "BB" => ["BB", "Barbados"],
            "BD" => ["BD", "Bangladesh"],
            "BE" => ["BE", "Belgium"],
            "BF" => ["BF", "Burkina Faso"],
            "BG" => ["BG", "Bulgaria"],
            "BH" => ["BH", "Bahrain"],
            "BI" => ["BI", "Burundi"],
            "BJ" => ["BJ", "Benin"],
            "BL" => ["BL", "Saint Barthélemy"],
            "BM" => ["BM", "Bermuda"],
            "BN" => ["BN", "Brunei"],
            "BO" => ["BO", "Bolivia"],
            "BQ" => ["BQ", "Bonaire"],
            "BR" => ["BR", "Brazil"],
            "BS" => ["BS", "Bahamas"],
            "BT" => ["BT", "Bhutan"],
            "BV" => ["BV", "Bouvet Island"],
            "BW" => ["BW", "Botswana"],
            "BY" => ["BY", "Belarus"],
            "BZ" => ["BZ", "Belize"],
            "CA" => ["CA", "Canada"],
            "CC" => ["CC", "Cocos [Keeling], Islands"],
            "CD" => ["CD", "Democratic Republic of the Congo"],
            "CF" => ["CF", "Central African Republic"],
            "CG" => ["CG", "Republic of the Congo"],
            "CH" => ["CH", "Switzerland"],
            "CI" => ["CI", "Ivory Coast"],
            "CK" => ["CK", "Cook Islands"],
            "CL" => ["CL", "Chile"],
            "CM" => ["CM", "Cameroon"],
            "CN" => ["CN", "China"],
            "CO" => ["CO", "Colombia"],
            "CR" => ["CR", "Costa Rica"],
            "CU" => ["CU", "Cuba"],
            "CV" => ["CV", "Cape Verde"],
            "CW" => ["CW", "Curacao"],
            "CX" => ["CX", "Christmas Island"],
            "CY" => ["CY", "Cyprus"],
            "CZ" => ["CZ", "Czech Republic"],
            "DE" => ["DE", "Germany"],
            "DJ" => ["DJ", "Djibouti"],
            "DK" => ["DK", "Denmark"],
            "DM" => ["DM", "Dominica"],
            "DO" => ["DO", "Dominican Republic"],
            "DZ" => ["DZ", "Algeria"],
            "EC" => ["EC", "Ecuador"],
            "EE" => ["EE", "Estonia"],
            "EG" => ["EG", "Egypt"],
            "EH" => ["EH", "Western Sahara"],
            "ER" => ["ER", "Eritrea"],
            "ES" => ["ES", "Spain"],
            "ET" => ["ET", "Ethiopia"],
            "FI" => ["FI", "Finland"],
            "FJ" => ["FJ", "Fiji"],
            "FK" => ["FK", "Falkland Islands"],
            "FM" => ["FM", "Micronesia"],
            "FO" => ["FO", "Faroe Islands"],
            "FR" => ["FR", "France"],
            "GA" => ["GA", "Gabon"],
            "GB" => ["GB", "United Kingdom"],
            "GD" => ["GD", "Grenada"],
            "GE" => ["GE", "Georgia"],
            "GF" => ["GF", "French Guiana"],
            "GG" => ["GG", "Guernsey"],
            "GH" => ["GH", "Ghana"],
            "GI" => ["GI", "Gibraltar"],
            "GL" => ["GL", "Greenland"],
            "GM" => ["GM", "Gambia"],
            "GN" => ["GN", "Guinea"],
            "GP" => ["GP", "Guadeloupe"],
            "GQ" => ["GQ", "Equatorial Guinea"],
            "GR" => ["GR", "Greece"],
            "GS" => ["GS", "South Georgia and the South Sandwich Islands"],
            "GT" => ["GT", "Guatemala"],
            "GU" => ["GU", "Guam"],
            "GW" => ["GW", "Guinea-Bissau"],
            "GY" => ["GY", "Guyana"],
            "HK" => ["HK", "Hong Kong"],
            "HM" => ["HM", "Heard Island and McDonald Islands"],
            "HN" => ["HN", "Honduras"],
            "HR" => ["HR", "Croatia"],
            "HT" => ["HT", "Haiti"],
            "HU" => ["HU", "Hungary"],
            "ID" => ["ID", "Indonesia"],
            "IE" => ["IE", "Ireland"],
            "IL" => ["IL", "Israel"],
            "IM" => ["IM", "Isle of Man"],
            "IN" => ["IN", "India"],
            "IO" => ["IO", "British Indian Ocean Territory"],
            "IQ" => ["IQ", "Iraq"],
            "IR" => ["IR", "Iran"],
            "IS" => ["IS", "Iceland"],
            "IT" => ["IT", "Italy"],
            "JE" => ["JE", "Jersey"],
            "JM" => ["JM", "Jamaica"],
            "JO" => ["JO", "Jordan"],
            "JP" => ["JP", "Japan"],
            "KE" => ["KE", "Kenya"],
            "KG" => ["KG", "Kyrgyzstan"],
            "KH" => ["KH", "Cambodia"],
            "KI" => ["KI", "Kiribati"],
            "KM" => ["KM", "Comoros"],
            "KN" => ["KN", "Saint Kitts and Nevis"],
            "KP" => ["KP", "North Korea"],
            "KR" => ["KR", "South Korea"],
            "KW" => ["KW", "Kuwait"],
            "KY" => ["KY", "Cayman Islands"],
            "KZ" => ["KZ", "Kazakhstan"],
            "LA" => ["LA", "Laos"],
            "LB" => ["LB", "Lebanon"],
            "LC" => ["LC", "Saint Lucia"],
            "LI" => ["LI", "Liechtenstein"],
            "LK" => ["LK", "Sri Lanka"],
            "LR" => ["LR", "Liberia"],
            "LS" => ["LS", "Lesotho"],
            "LT" => ["LT", "Lithuania"],
            "LU" => ["LU", "Luxembourg"],
            "LV" => ["LV", "Latvia"],
            "LY" => ["LY", "Libya"],
            "MA" => ["MA", "Morocco"],
            "MC" => ["MC", "Monaco"],
            "MD" => ["MD", "Moldova"],
            "ME" => ["ME", "Montenegro"],
            "MF" => ["MF", "Saint Martin"],
            "MG" => ["MG", "Madagascar"],
            "MH" => ["MH", "Marshall Islands"],
            "MK" => ["MK", "Macedonia"],
            "ML" => ["ML", "Mali"],
            "MM" => ["MM", "Myanmar [Burma],"],
            "MN" => ["MN", "Mongolia"],
            "MO" => ["MO", "Macao"],
            "MP" => ["MP", "Northern Mariana Islands"],
            "MQ" => ["MQ", "Martinique"],
            "MR" => ["MR", "Mauritania"],
            "MS" => ["MS", "Montserrat"],
            "MT" => ["MT", "Malta"],
            "MU" => ["MU", "Mauritius"],
            "MV" => ["MV", "Maldives"],
            "MW" => ["MW", "Malawi"],
            "MX" => ["MX", "Mexico"],
            "MY" => ["MY", "Malaysia"],
            "MZ" => ["MZ", "Mozambique"],
            "NA" => ["NA", "Namibia"],
            "NC" => ["NC", "New Caledonia"],
            "NE" => ["NE", "Niger"],
            "NF" => ["NF", "Norfolk Island"],
            "NG" => ["NG", "Nigeria"],
            "NI" => ["NI", "Nicaragua"],
            "NL" => ["NL", "Netherlands"],
            "NO" => ["NO", "Norway"],
            "NP" => ["NP", "Nepal"],
            "NR" => ["NR", "Nauru"],
            "NU" => ["NU", "Niue"],
            "NZ" => ["NZ", "New Zealand"],
            "OM" => ["OM", "Oman"],
            "PA" => ["PA", "Panama"],
            "PE" => ["PE", "Peru"],
            "PF" => ["PF", "French Polynesia"],
            "PG" => ["PG", "Papua New Guinea"],
            "PH" => ["PH", "Philippines"],
            "PK" => ["PK", "Pakistan"],
            "PL" => ["PL", "Poland"],
            "PM" => ["PM", "Saint Pierre and Miquelon"],
            "PN" => ["PN", "Pitcairn Islands"],
            "PR" => ["PR", "Puerto Rico"],
            "PS" => ["PS", "Palestine"],
            "PT" => ["PT", "Portugal"],
            "PW" => ["PW", "Palau"],
            "PY" => ["PY", "Paraguay"],
            "QA" => ["QA", "Qatar"],
            "RE" => ["RE", "Réunion"],
            "RO" => ["RO", "Romania"],
            "RS" => ["RS", "Serbia"],
            "RU" => ["RU", "Russia"],
            "RW" => ["RW", "Rwanda"],
            "SA" => ["SA", "Saudi Arabia"],
            "SB" => ["SB", "Solomon Islands"],
            "SC" => ["SC", "Seychelles"],
            "SD" => ["SD", "Sudan"],
            "SE" => ["SE", "Sweden"],
            "SG" => ["SG", "Singapore"],
            "SH" => ["SH", "Saint Helena"],
            "SI" => ["SI", "Slovenia"],
            "SJ" => ["SJ", "Svalbard and Jan Mayen"],
            "SK" => ["SK", "Slovakia"],
            "SL" => ["SL", "Sierra Leone"],
            "SM" => ["SM", "San Marino"],
            "SN" => ["SN", "Senegal"],
            "SO" => ["SO", "Somalia"],
            "SR" => ["SR", "Suriname"],
            "SS" => ["SS", "South Sudan"],
            "ST" => ["ST", "São Tomé and Príncipe"],
            "SV" => ["SV", "El Salvador"],
            "SX" => ["SX", "Sint Maarten"],
            "SY" => ["SY", "Syria"],
            "SZ" => ["SZ", "Swaziland"],
            "TC" => ["TC", "Turks and Caicos Islands"],
            "TD" => ["TD", "Chad"],
            "TF" => ["TF", "French Southern Territories"],
            "TG" => ["TG", "Togo"],
            "TH" => ["TH", "Thailand"],
            "TJ" => ["TJ", "Tajikistan"],
            "TK" => ["TK", "Tokelau"],
            "TL" => ["TL", "East Timor"],
            "TM" => ["TM", "Turkmenistan"],
            "TN" => ["TN", "Tunisia"],
            "TO" => ["TO", "Tonga"],
            "TR" => ["TR", "Turkey"],
            "TT" => ["TT", "Trinidad and Tobago"],
            "TV" => ["TV", "Tuvalu"],
            "TW" => ["TW", "Taiwan"],
            "TZ" => ["TZ", "Tanzania"],
            "UA" => ["UA", "Ukraine"],
            "UG" => ["UG", "Uganda"],
            "UM" => ["UM", "U.S. Minor Outlying Islands"],
            "US" => ["US", "United States"],
            "UY" => ["UY", "Uruguay"],
            "UZ" => ["UZ", "Uzbekistan"],
            "VA" => ["VA", "Vatican City"],
            "VC" => ["VC", "Saint Vincent and the Grenadines"],
            "VE" => ["VE", "Venezuela"],
            "VG" => ["VG", "British Virgin Islands"],
            "VI" => ["VI", "U.S. Virgin Islands"],
            "VN" => ["VN", "Vietnam"],
            "VU" => ["VU", "Vanuatu"],
            "WF" => ["WF", "Wallis and Futuna"],
            "WS" => ["WS", "Samoa"],
            "XK" => ["XK", "Kosovo"],
            "YE" => ["YE", "Yemen"],
            "YT" => ["YT", "Mayotte"],
            "ZA" => ["ZA", "South Africa"],
            "ZM" => ["ZM", "Zambia"],
            "ZW" => ["ZW", "Zimbabwe"],
        ];

        return $countryNames[$countryCode];
    }
}
