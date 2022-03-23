<?php
require __DIR__ . '/vendor/autoload.php';

$id_calendar = 'yourcalendar@gmail.com';
$summary = 'EVENTO ATUALIZADO!';
$description = 'DESCRIÇÃO ATUALIZADA!';
$location = 'NOVO LOCAL';
$datetime_start = new DateTime('2022-03-23 09:00:00');
$time_end = new DateTime('2022-03-23 10:00:00');
$id_event_calendar = 'jm1orplh3ma70s21vipu667ad4';

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

  $event = $calendarService->events->get($id_calendar, $id_event_calendar);
  $event->setSummary($summary);
  $event->setDescription($description);
  $event->setLocation($location);

  $start = new Google_Service_Calendar_EventDateTime();
  $start->setDateTime($time_start);
  $event->setStart($start);

  $end = new Google_Service_Calendar_EventDateTime();
  $end->setDateTime($time_end);
  $event->setEnd($end);

  $updatedEvent = $calendarService->events->update($id_calendar, $event->getId(), $event);
  $id_event = $updatedEvent->getId();
  $link_event = $updatedEvent->gethtmlLink();
  var_dump($id_event, $link_event);

} catch (Google_Service_Exception $gs) {
  $msg = json_decode($gs->getMessage());
  echo json_encode(array('status' => $msg->error->message));
} catch (Exception $e) {
  $msg = $e->getMessage();
  echo json_encode(array('status' => $msg));
}

?>
