<?php 
require_once 'config.php';

include_once 'GoogleCalendarApi.class.php'; 
      
if(isset($_GET['code'])){
    $GoogleCalendarApi = new GoogleCalendarApi(); 

    $calendar_event = array( 
        'summary' => 'MEU EVENTO', 
        'location' => '', 
        'description' => 'Minha Descrição'
    ); 
     
    $event_datetime = array(
        'event_date' => '2022-03-09', 
        'start_time' => '10:00:00', 
        'end_time' => '12:00:00' 
    );
     
    $access_token_sess = $_SESSION['google_access_token']; 
    if(!empty($access_token_sess)){ 
        $access_token = $access_token_sess; 
    }else{ 
        $data = $GoogleCalendarApi->GetAccessToken(GOOGLE_CLIENT_ID, REDIRECT_URI, GOOGLE_CLIENT_SECRET, $_GET['code']); 
        $access_token = $data['access_token']; 
        $_SESSION['google_access_token'] = $access_token;
    }

    if(!empty($access_token)){ 
        try { 
            $user_timezone = $GoogleCalendarApi->GetUserCalendarTimezone($access_token); 
            $google_event_id = $GoogleCalendarApi->CreateCalendarEvent($access_token, 'primary', $calendar_event, 0, $event_datetime, $user_timezone);             
            if($google_event_id){
                unset($_SESSION['google_access_token']); 
                var_dump('success'); 
            } 
        } catch(Exception $e) {
            //header('Bad Request', true, 400); 
            var_dump($e->getMessage());
        } 
    }else{
        var_dump('Failed to fetch access token!');
    } 
}
