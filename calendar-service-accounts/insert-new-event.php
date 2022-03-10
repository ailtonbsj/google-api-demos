<?php
require __DIR__ . '/vendor/autoload.php';

$id_calendar = 'exemplo@gmail.com';
$summary = 'MEU EVENTO';
$description = 'DESCRIÇÃO';
$datetime_start = new DateTime('2022-03-10 09:00:00');
$time_end = new DateTime('2022-03-10 12:00:00');

$msg = '';
$id_event = '';
$link_event;

date_default_timezone_set('America/Fortaleza');
putenv('GOOGLE_APPLICATION_CREDENTIALS=keys.json');

$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/calendar']);

$time_start = $datetime_start->format(\DateTime::RFC3339);
$time_end = $time_end->format(\DateTime::RFC3339);

try {
  $calendarService = new Google_Service_Calendar($client);

  $optParams = array(
    'orderBy' => 'startTime',
    'maxResults' => 20,
    'singleEvents' => TRUE,
    'timeMin' => $time_start,
    'timeMax' => $time_end,
  );
  $events = $calendarService->events->listEvents($id_calendar, $optParams);
  $cont_events = count($events->getItems());

  if ($cont_events == 0) {
    $event = new Google_Service_Calendar_Event();
    $event->setSummary($summary);
    $event->setDescription($description);

    $start = new Google_Service_Calendar_EventDateTime();
    $start->setDateTime($time_start);
    $event->setStart($start);

    $end = new Google_Service_Calendar_EventDateTime();
    $end->setDateTime($time_end);
    $event->setEnd($end);

    $createdEvent = $calendarService->events->insert($id_calendar, $event);
    $id_event = $createdEvent->getId();
    $link_event = $createdEvent->gethtmlLink();
    var_dump($id_event, $link_event);
  } else {
    $msg = "Já há $cont_events eventos nessa data!";
  }
} catch (Google_Service_Exception $gs) {
  $msg = json_decode($gs->getMessage());
  $msg = $msg->error->message;
} catch (Exception $e) {
  $msg = $e->getMessage();
}
var_dump($msg);

?>
