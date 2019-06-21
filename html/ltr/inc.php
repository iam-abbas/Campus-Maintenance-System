<?php
function redirect($url)
{
   header('Location: ' . $url);
   die();
}

function isAdmin($id, $con) {
  $sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result = mysqli_query($con,$sql_query);
  $row = mysqli_fetch_assoc($result);
  if($row['admin'] == 1) {
    return true;
  } else {
    return false;
  }
}

function isWork($id, $con) {
  $sql_query = "SELECT * FROM `users` WHERE `id` = '{$id}'";
  $result = mysqli_query($con,$sql_query);
  $row = mysqli_fetch_assoc($result);
  if($row['man_pow'] == 1) {
    return true;
  } else {
    return false;
  }
}
function getAdminTokens($con) {
  $sql_query = "SELECT * FROM `users` WHERE `admin` = '1'";
  $result = mysqli_query($con, $sql_query);
  $token_id = array();
  while($row = mysqli_fetch_assoc($result)) {
    if(!empty($row['fcm-token'])) {
    $token_id[] =$row['fcm-token'];
    }
  }
  return $token_id;
}
function sethead($str) {
echo '
  <div class="page-breadcrumb">
  <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">'.$str.'</h4>
          <div class="ml-auto text-right">
              <nav aria-label="breadcrumb">
              </nav>
          </div>
      </div>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
  ';
}

function DateAndTime($time) {
  $date = date('jS F, Y H:i:s', $time);
  return $date;
}

function checkForBadwords($haystack) {
  $needle  = array("4r5e", "5h1t", "5hit", "a55", "anal", "anus", 
  "ar5e", "arrse", "arse", "ass", "ass-fucker", "asses", 
  "assfucker", "assfukka", "asshole", "assholes", "asswhole", 
  "a_s_s", "b!tch", "b00bs", "b17ch", "b1tch", "ballbag", 
  "balls", "ballsack", "bastard", "beastial", "beastiality",
  "bellend", "bestial", "bestiality", "bi+ch", "biatch", "bitch",
  "bitcher", "bitchers", "bitches", "bitchin", "bitching", "bloody",
  "blow job", "blowjob", "blowjobs", "boiolas", "bollock", "bollok",
  "boner", "boob", "boobs", "booobs", "boooobs", "booooobs", "booooooobs",
  "breasts", "buceta", "bugger", "bum", "bunny fucker", "butt", "butthole", 
  "buttmuch", "buttplug", "c0ck", "c0cksucker", "carpet muncher", "cawk",
  "chink", "cipa", "cl1t", "clit", "clitoris", "clits", "cnut", "cock", "cock-sucker", 
  "cockface", "cockhead", "cockmunch", "cockmuncher", "cocks", "cocksuck", "cocksucked", 
  "cocksucker", "cocksucking", "cocksucks", "cocksuka", "cocksukka",
  "cok", "cokmuncher", "coksucka", "coon", "cox", "crap", "cum", "cummer",
  "cumming", "cums", "cumshot", "cunilingus", "cunillingus", "cunnilingus", "cunt",
  "cuntlick", "cuntlicker", "cuntlicking", "cunts", "cyalis", "cyberfuc", "cyberfuck",
  "cyberfucked", "cyberfucker", "cyberfuckers", "cyberfucking", 
  "d1ck", "damn", "dick", "dickhead", "dildo", "dildos", "dink", "dinks", "dirsa", "dlck", "dog-fucker",
  "doggin", "dogging", "donkeyribber", "doosh", "duche", "dyke", "ejaculate", "ejaculated", "ejaculates",
  "ejaculating", "ejaculatings", "ejaculation", "ejakulate", "f u c k", "f u c k e r", "f4nny", "fag", 
  "fagging", "faggitt", "faggot", "faggs", "fagot", "fagots", "fags", "fanny", "fannyflaps", "fannyfucker",
  "fanyy", "fatass", "fcuk", "fcuker", "fcuking", "feck", "fecker", "felching", "fellate", "fellatio", 
  "fingerfuck", "fingerfucked", "fingerfucker", "fingerfuckers", "fingerfucking", "fingerfucks", "fistfuck",
  "fistfucked", "fistfucker", "fistfuckers", "fistfucking", "fistfuckings", "fistfucks", "flange", "fook", 
  "fooker", "fuck", "fucka", "fucked", "fucker", "fuckers", "fuckhead", "fuckheads", "fuckin", "fucking",
  "fuckings", "fuckingshitmotherfucker", "fuckme", "fucks", "fuckwhit", "fuckwit", "fudge packer", "fudgepacker",
  "fuk", "fuker", "fukker", "fukkin", "fuks", "fukwhit", "fukwit", "fux", "fux0r", "f_u_c_k", "gangbang", 
  "gangbanged", "gangbangs", "gaylord", "gaysex", "goatse", "God", "god-dam", "god-damned", "goddamn",
  "goddamned", "hardcoresex", "hell", "heshe", "hoar", "hoare", "hoer", "homo", "hore", "horniest",
  "horny", "hotsex", "jack-off", "jackoff", "jap", "jerk-off", "jism", "jiz", "jizm", "jizz", "kawk",
  "knob", "knobead", "knobed", "knobend", "knobhead", "knobjocky", "knobjokey", "kock", "kondum",
  "kondums", "kum", "kummer", "kumming", "kums", "kunilingus", "l3i+ch", "l3itch", "labia",
  "lust", "lusting", "m0f0", "m0fo", "m45terbate", "ma5terb8", "ma5terbate", "masochist", 
  "master-bate", "masterb8", "masterbat*", "masterbat3", "masterbate", "masterbation", 
  "masterbations", "masturbate", "mo-fo", "mof0", "mofo", "mothafuck", "mothafucka", 
  "mothafuckas", "mothafuckaz", "mothafucked", "mothafucker", "mothafuckers", "mothafuckin", 
  "mothafucking", "mothafuckings", "mothafucks", "mother fucker", "motherfuck", "motherfucked", 
  "motherfucker", "motherfuckers", "motherfuckin", "motherfucking", "motherfuckings", "motherfuckka", 
  "motherfucks", "muff", "mutha", "muthafecker", "muthafuckker", "muther", "mutherfucker", "n1gga",
  "n1gger", "nazi", "nigg3r", "nigg4h", "nigga", "niggah", "niggas", "niggaz", "nigger", "niggers", 
  "nob", "nob jokey", "nobhead", "nobjocky", "nobjokey", "numbnuts", "nutsack", "orgasim", "orgasims",
  "orgasm", "orgasms", "p0rn", "pawn", "pecker", "penis", "penisfucker", "phonesex", "phuck", "phuk", 
  "phuked", "phuking", "phukked", "phukking", "phuks", "phuq", "pigfucker", "pimpis", "piss", "pissed",
  "pisser", "pissers", "pisses", "pissflaps", "pissin", "pissing", "pissoff", "poop", "porn", "porno",
  "pornography", "pornos", "prick", "pricks", "pron", "pube", "pusse", "pussi", "pussies", "pussy",
  "pussys", "rectum", "retard", "rimjaw", "rimming", "s hit", "s.o.b.", "sadist", "schlong", "screwing", 
  "scroat", "scrote", "scrotum", "semen", "sex", "sh!+", "sh!t", "sh1t", "shag", "shagger", "shaggin", 
  "shagging", "shemale", "shi+", "shit", "shitdick", "shite", "shited", "shitey", "shitfuck", "shitfull",
  "shithead", "shiting", "shitings", "shits", "shitted", "shitter", "shitters", "shitting", "shittings",
  "shitty", "skank", "slut", "sluts", "smegma", "smut", "snatch", "son-of-a-bitch", "spac", "spunk", 
  "s_h_i_t", "t1tt1e5", "t1tties", "teets", "teez", "testical", "testicle", "tit", "titfuck", "tits",
  "titt", "tittie5", "tittiefucker", "titties", "tittyfuck", "tittywank", "titwank", "tosser", "turd",
  "tw4t", "twat", "twathead", "twatty", "twunt", "twunter", "v14gra", "v1gra", "vagina", "viagra", "vulva", 
  "w00se", "wang", "wank", "wanker", "wanky", "whoar", "whore", "willies", "willy", "xrated", "xxx",
  "madarchod","gandu","gand","behenchod","lund","saala","harami","loda","lodda","lodaa","mochi ","dalal","lodu",
  "chatta","pandi","lunja ","munda","lanja","khojja","hijra","hijda","chakka",
  "betichod","chod","chut","bhosadi","bsdk","bhosadike", "badword"

);

  if(!is_array($needle)) $needle = array($needle);
  foreach($needle as $query) {
      if(strpos($haystack, $query) !== false) return true; // stop on first true result
  }
  return false;
}

function getName($id, $con) {
    $query = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '{$id}' ");
    $row = mysqli_fetch_assoc($query);
    return $row['name'];
}

function timeago($time) {

      $time = time() - $time; // to get the time since that moment
      if($time <= 0) {
        return "Just now";
      }

      $tokens = array (
      31536000 => 'year',
      2592000 => 'month',
      604800 => 'week',
      86400 => 'day',
      3600 => 'hour',
      60 => 'minute',
      1 => 'second',
      );

      foreach ($tokens as $unit => $text) {
      if ($time < $unit) continue;
    $numberOfUnits = floor($time / $unit);
    return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s ago':' ago');
  }

}

function timeLeft($secondsLeft) {

  $minuteInSeconds = 60;
  $hourInSeconds = $minuteInSeconds * 60;
  $dayInSeconds = $hourInSeconds * 24;

  $days = floor($secondsLeft / $dayInSeconds);
  $secondsLeft = $secondsLeft % $dayInSeconds;

  $hours = floor($secondsLeft / $hourInSeconds);
  $secondsLeft = $secondsLeft % $hourInSeconds;

  $minutes= floor($secondsLeft / $minuteInSeconds);

  $seconds = $secondsLeft % $minuteInSeconds;

  $timeComponents = array();

  if ($days > 0) {
    $timeComponents[] = $days . " day" . ($days > 1 ? "s" : "");
  }

  if ($hours > 0) {
    $timeComponents[] = $hours . " hour" . ($hours > 1 ? "s" : "");
  }

  if ($minutes > 0) {
    $timeComponents[] = $minutes . " minute" . ($minutes > 1 ? "s" : "");
  }

  if ($seconds > 0) {
    $timeComponents[] = $seconds . " second" . ($seconds > 1 ? "s" : "");
  }

  if (count($timeComponents) > 0) {
    $formattedTimeRemaining = implode(", ", $timeComponents);
    $formattedTimeRemaining = trim($formattedTimeRemaining);
  } else {
    $formattedTimeRemaining = "No time remaining.";
  }

  return $formattedTimeRemaining;

}

?>
