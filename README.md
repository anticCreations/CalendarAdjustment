# CalendarAdjustment


Example

$arr =  array(
    "post_title" => "TEST",
  "description" => "TESTBESCHRIJVING",
  "start" => date('j/n/Y H:i:s',time()),
  "end" => date('j/n/Y H:i:s',time()),
  "venue" => "StationTest"
);
$cal = new CalendarAdjustments($arr);
$cal->db_interactions();
