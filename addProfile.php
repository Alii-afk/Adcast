<?php
include("include/classes/session.php");
$result = $database->findUser($session->username);
$username = $session->username;
$name = $result['name'];
$error = "";
$status= "'0'";
$businessNameError = $form->error("businessName");
$businessIndustrylError = $form->error("businessIndustry");
$businessTypeError = $form->error("businessType");
$workingHoursError = $form->error("workingHours");
$timezoneError = $form->error("timezone");

if($businessNameError != "")
{
    $error = $businessNameError;
}
else if ($businessIndustrylError != "")
{
    $error = $businessIndustrylError;
}
else if ($businessTypeError != "")
{
    $error = $businessTypeError;
}
else if ($workingHoursError != "")
{
    $error = $workingHoursError;
}
else if ($timezoneError != "")
{
    $error = $timezoneError;
}


if(isset($_GET['SetUpProfile']))
 {
     $status= "'1'";
 }
 if(isset($_GET['FormError']))
 {
     $status= "'2'";
 }
 if(isset($_GET['DBError']))
 {
     $status= "'3'";
 }
 

$jumostp = rand(100000, 999999);
$jumo1 = $jumostp;
$_SESSION['CSRF_Code'] =    $jumo1;
$jumo = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/switzer" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>

<body style="background-color: #117BC8;" onload="launch_toast(<?php echo $status; ?>)">
    <?php include("headers/header.php"); ?>
    <div class="row d-flex container-fluid justify-content-around">
        <div class="addProfileContainer col-sm-12 col-md-7 col-lg-7 d-flex justify-content-around">
            <form class="row justify-content-around" method="POST" action="process.php">
                <label for="formName" class="headLabel">ADD PROFILE INFO</label>
                <div class="profileFormContainer col-md-8 col-sm-6">
                    <input type="text" class="formInput" placeholder="Name of Your Business" name="businessName"><br>
                    <select class="formInput" name="businessIndustry" id="businessIndustryId">
                        <option value="" selected>Business industry</option>
                        <option value="construction">Construction</option>
                    </select><br>
                    <select class="formInput" name="businessType" id="businessTypeId">
                        <option value="" selected>Business type</option>
                        <option value="liftIndustry">Lift Industry</option>
                    </select><br>
                    <select class="formInput" name="workingHours" id="workingHourId">
                        <option value="">-Working hours</option>
                        <option value="8">8 hours</option>
                        <option value="9">9 hours</option>
                        <option value="10">10 hours</option>
                    </select><br>
                    <select class="formInput" name="timezone" id="timezoneId">
                        <option value="" selected>Select Time Zone</option>
                        <option value="Pacific/Midway">Midway [SST -11:00]</option>
                        <option value="Pacific/Niue">Niue [NUT -11:00]</option>
                        <option value="Pacific/Apia">Apia [WST -11:00]</option>
                        <option value="Pacific/Tahiti">Tahiti [TAHT -10:00]</option>
                        <option value="Pacific/Honolulu">Honolulu [HST -10:00]</option>
                        <option value="Pacific/Rarotonga">Rarotonga [CKT -10:00]</option>
                        <option value="Pacific/Fakaofo">Fakaofo [TKT -10:00]</option>
                        <option value="Pacific/Marquesas">Marquesas [MART -09:30]</option>
                        <option value="America/Adak">Adak [HADT -09:00]</option>
                        <option value="Pacific/Gambier">Gambier [GAMT -09:00]</option>
                        <option value="America/Anchorage">Anchorage [AKDT -08:00]</option>
                        <option value="Pacific/Pitcairn">Pitcairn [PST -08:00]</option>
                        <option value="America/Dawson_Creek">Dawson Creek [MST -07:00]</option>
                        <option value="America/Dawson">Dawson [PDT -07:00]</option>
                        <option value="America/Belize">Belize [CST -06:00]</option>
                        <option value="America/Boise">Boise [MDT -06:00]</option>
                        <option value="Pacific/Easter">Easter [EAST -06:00]</option>
                        <option value="Pacific/Galapagos">Galapagos [GALT -06:00]</option>
                        <option value="America/Resolute">Resolute [CDT -05:00]</option>
                        <option value="America/Cancun">Cancun [CDT -05:00]</option>
                        <option value="America/Guayaquil">Guayaquil [ECT -05:00]</option>
                        <option value="America/Lima">Lima [PET -05:00]</option>
                        <option value="America/Bogota">Bogota [COT -05:00]</option>
                        <option value="America/Atikokan">Atikokan [EST -05:00]</option>
                        <option value="America/Caracas">Caracas [VET -04:30]</option>
                        <option value="America/Guyana">Guyana [GYT -04:00]</option>
                        <option value="America/Campo_Grande">Campo Grande [AMT -04:00]</option>
                        <option value="America/La_Paz">La Paz [BOT -04:00]</option>
                        <option value="America/Anguilla">Anguilla [AST -04:00]</option>
                        <option value="Atlantic/Stanley">Stanley [FKT -04:00]</option>
                        <option value="America/Detroit">Detroit [EDT -04:00]</option>
                        <option value="America/Boa_Vista">Boa Vista [AMT -04:00]</option>
                        <option value="America/Santiago">Santiago [CLT -04:00]</option>
                        <option value="America/Asuncion">Asuncion [PYT -04:00]</option>
                        <option value="Antarctica/Rothera">Rothera [ROTT -03:00]</option>
                        <option value="America/Paramaribo">Paramaribo [SRT -03:00]</option>
                        <option value="America/Sao_Paulo">Sao Paulo [BRT -03:00]</option>
                        <option value="America/Argentina/Buenos_Aires">Buenos Aires [ART -03:00]</option>
                        <option value="America/Cayenne">Cayenne [GFT -03:00]</option>
                        <option value="America/Glace_Bay">Glace Bay [ADT -03:00]</option>
                        <option value="America/Argentina/San_Luis">San Luis [WARST -03:00]</option>
                        <option value="America/Araguaina">Araguaina [BRT -03:00]</option>
                        <option value="America/Montevideo">Montevideo [UYT -03:00]</option>
                        <option value="America/St_Johns">St Johns [NDT -02:30]</option>
                        <option value="America/Miquelon">Miquelon [PMDT -02:00]</option>
                        <option value="America/Noronha">Noronha [FNT -02:00]</option>
                        <option value="America/Godthab">Godthab [WGST -02:00]</option>
                        <option value="Atlantic/Cape_Verde">Cape Verde [CVT -01:00]</option>
                        <option value="Atlantic/Azores">Azores [AZOST 00:00]</option>
                        <option value="America/Scoresbysund">Scoresbysund [EGST 00:00]</option>
                        <option value="UTC">UTC [UTC 00:00]</option>
                        <option value="Africa/Abidjan">Abidjan [GMT 00:00]</option>
                        <option value="Africa/Casablanca">Casablanca [WET 00:00]</option>
                        <option value="Africa/Bangui">Bangui [WAT +01:00]</option>
                        <option value="Europe/Guernsey">Guernsey [BST +01:00]</option>
                        <option value="Europe/Dublin">Dublin [IST +01:00]</option>
                        <option value="Africa/Algiers">Algiers [CET +01:00]</option>
                        <option value="Atlantic/Canary">Canary [WEST +01:00]</option>
                        <option value="Africa/Windhoek">Windhoek [WAT +01:00]</option>
                        <option value="Africa/Johannesburg">Johannesburg [SAST +02:00]</option>
                        <option value="Africa/Blantyre">Blantyre [CAT +02:00]</option>
                        <option value="Africa/Tripoli">Tripoli [EET +02:00]</option>
                        <option value="Africa/Ceuta">Ceuta [CEST +02:00]</option>
                        <option value="Asia/Jerusalem">Jerusalem [IDT +03:00]</option>
                        <option value="Africa/Addis_Ababa">Addis Ababa [EAT +03:00]</option>
                        <option value="Africa/Cairo">Cairo [EEST +03:00]</option>
                        <option value="Antarctica/Syowa">Syowa [SYOT +03:00]</option>
                        <option value="Europe/Volgograd">Volgograd [VOLST +04:00]</option>
                        <option value="Europe/Samara">Samara [SAMST +04:00]</option>
                        <option value="Asia/Tbilisi">Tbilisi [GET +04:00]</option>
                        <option value="Europe/Moscow">Moscow [MSD +04:00]</option>
                        <option value="Asia/Dubai">Dubai [GST +04:00]</option>
                        <option value="Indian/Mauritius">Mauritius [MUT +04:00]</option>
                        <option value="Indian/Reunion">Reunion [RET +04:00]</option>
                        <option value="Indian/Mahe">Mahe [SCT +04:00]</option>
                        <option value="Asia/Tehran">Tehran [IRDT +04:30]</option>
                        <option value="Asia/Kabul">Kabul [AFT +04:30]</option>
                        <option value="Asia/Aqtau">Aqtau [AQTT +05:00]</option>
                        <option value="Asia/Ashgabat">Ashgabat [TMT +05:00]</option>
                        <option value="Asia/Oral">Oral [ORAT +05:00]</option>
                        <option value="Asia/Yerevan">Yerevan [AMST +05:00]</option>
                        <option value="Asia/Baku">Baku [AZST +05:00]</option>
                        <option value="Indian/Kerguelen">Kerguelen [TFT +05:00]</option>
                        <option value="Indian/Maldives">Maldives [MVT +05:00]</option>
                        <option value="Asia/Karachi">Karachi [PKT +05:00]</option>
                        <option value="Asia/Dushanbe">Dushanbe [TJT +05:00]</option>
                        <option value="Asia/Samarkand">Samarkand [UZT +05:00]</option>
                        <option value="Antarctica/Mawson">Mawson [MAWT +05:00]</option>
                        <option value="Asia/Colombo">Colombo [IST +05:30]</option>
                        <option value="Asia/Kathmandu">Kathmandu [NPT +05:45]</option>
                        <option value="Indian/Chagos">Chagos [IOT +06:00]</option>
                        <option value="Asia/Bishkek">Bishkek [KGT +06:00]</option>
                        <option value="Asia/Almaty">Almaty [ALMT +06:00]</option>
                        <option value="Antarctica/Vostok">Vostok [VOST +06:00]</option>
                        <option value="Asia/Yekaterinburg">Yekaterinburg [YEKST +06:00]</option>
                        <option value="Asia/Dhaka">Dhaka [BDT +06:00]</option>
                        <option value="Asia/Thimphu">Thimphu [BTT +06:00]</option>
                        <option value="Asia/Qyzylorda">Qyzylorda [QYZT +06:00]</option>
                        <option value="Indian/Cocos">Cocos [CCT +06:30]</option>
                        <option value="Asia/Rangoon">Rangoon [MMT +06:30]</option>
                        <option value="Asia/Jakarta">Jakarta [WIT +07:00]</option>
                        <option value="Asia/Hovd">Hovd [HOVT +07:00]</option>
                        <option value="Antarctica/Davis">Davis [DAVT +07:00]</option>
                        <option value="Asia/Bangkok">Bangkok [ICT +07:00]</option>
                        <option value="Indian/Christmas">Christmas [CXT +07:00]</option>
                        <option value="Asia/Omsk">Omsk [OMSST +07:00]</option>
                        <option value="Asia/Novokuznetsk">Novokuznetsk [NOVST +07:00]</option>
                        <option value="Asia/Choibalsan">Choibalsan [CHOT +08:00]</option>
                        <option value="Asia/Ulaanbaatar">Ulaanbaatar [ULAT +08:00]</option>
                        <option value="Asia/Brunei">Brunei [BNT +08:00]</option>
                        <option value="Antarctica/Casey">Casey [WST +08:00]</option>
                        <option value="Asia/Singapore">Singapore [SGT +08:00]</option>
                        <option value="Asia/Manila">Manila [PHT +08:00]</option>
                        <option value="Asia/Hong_Kong">Hong Kong [HKT +08:00]</option>
                        <option value="Asia/Krasnoyarsk">Krasnoyarsk [KRAST +08:00]</option>
                        <option value="Asia/Makassar">Makassar [CIT +08:00]</option>
                        <option value="Asia/Kuala_Lumpur">Kuala Lumpur [MYT +08:00]</option>
                        <option value="Australia/Eucla">Eucla [CWST +08:45]</option>
                        <option value="Pacific/Palau">Palau [PWT +09:00]</option>
                        <option value="Asia/Tokyo">Tokyo [JST +09:00]</option>
                        <option value="Asia/Dili">Dili [TLT +09:00]</option>
                        <option value="Asia/Jayapura">Jayapura [EIT +09:00]</option>
                        <option value="Asia/Pyongyang">Pyongyang [KST +09:00]</option>
                        <option value="Asia/Irkutsk">Irkutsk [IRKST +09:00]</option>
                        <option value="Australia/Adelaide">Adelaide [CST +09:30]</option>
                        <option value="Asia/Yakutsk">Yakutsk [YAKST +10:00]</option>
                        <option value="Australia/Currie">Currie [EST +10:00]</option>
                        <option value="Pacific/Port_Moresby">Port Moresby [PGT +10:00]</option>
                        <option value="Pacific/Guam">Guam [ChST +10:00]</option>
                        <option value="Pacific/Truk">Truk [TRUT +10:00]</option>
                        <option value="Antarctica/DumontDUrville">DumontDUrville [DDUT +10:00]</option>
                        <option value="Australia/Lord_Howe">Lord Howe [LHST +10:30]</option>
                        <option value="Pacific/Ponape">Ponape [PONT +11:00]</option>
                        <option value="Pacific/Kosrae">Kosrae [KOST +11:00]</option>
                        <option value="Antarctica/Macquarie">Macquarie [MIST +11:00]</option>
                        <option value="Pacific/Noumea">Noumea [NCT +11:00]</option>
                        <option value="Pacific/Efate">Efate [VUT +11:00]</option>
                        <option value="Pacific/Guadalcanal">Guadalcanal [SBT +11:00]</option>
                        <option value="Asia/Sakhalin">Sakhalin [SAKST +11:00]</option>
                        <option value="Asia/Vladivostok">Vladivostok [VLAST +11:00]</option>
                        <option value="Pacific/Norfolk">Norfolk [NFT +11:30]</option>
                        <option value="Asia/Kamchatka">Kamchatka [PETST +12:00]</option>
                        <option value="Pacific/Tarawa">Tarawa [GILT +12:00]</option>
                        <option value="Asia/Magadan">Magadan [MAGST +12:00]</option>
                        <option value="Pacific/Wallis">Wallis [WFT +12:00]</option>
                        <option value="Pacific/Kwajalein">Kwajalein [MHT +12:00]</option>
                        <option value="Pacific/Funafuti">Funafuti [TVT +12:00]</option>
                        <option value="Pacific/Nauru">Nauru [NRT +12:00]</option>
                        <option value="Asia/Anadyr">Anadyr [ANAST +12:00]</option>
                        <option value="Antarctica/McMurdo">McMurdo [NZST +12:00]</option>
                        <option value="Pacific/Wake">Wake [WAKT +12:00]</option>
                        <option value="Pacific/Fiji">Fiji [FJT +12:00]</option>
                        <option value="Pacific/Chatham">Chatham [CHAST +12:45]</option>
                        <option value="Pacific/Enderbury">Enderbury [PHOT +13:00]</option>
                        <option value="Pacific/Tongatapu">Tongatapu [TOT +13:00]</option>
                        <option value="Pacific/Kiritimati">Kiritimati [LINT +14:00]</option>
                    </select><br>
                    <input type="hidden" name="CSRF_Code" value="<?php echo $jumo ?>">
                    <input type="submit" class="saveButton formButton" value="SAVE" name="registerProfile">
                </div>
            </form>
        </div>
    </div>
    <div id="toast"><div id="desc"></div></div>
</body>
<script>

function launch_toast(value) {
    var x = document.getElementById("toast");
    
    if(value == 1)
    {
       var y = document.getElementById("desc");
        y.innerHTML = "Set Up Your Profile"; 
    }
    <?php if($error !="") { ?>
    if(value == 2)
    {
       var y = document.getElementById("desc");
        y.innerHTML = '<?php echo $error;?>'; 
        x.style.backgroundColor = "#F94025";
    }
    if(value == 3)
    {
       var y = document.getElementById("desc");
        y.innerHTML = "Database Error"; 
        x.style.backgroundColor = "#F94025";
    }
    <?php } ?>
    if(value != 0)
    {
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
}
    </script>
</html>