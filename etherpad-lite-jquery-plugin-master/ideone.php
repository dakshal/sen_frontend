<?php
  ini_set('display_errors', 1);

  require_once 'lib/nusoap.php';
  $user = 'Vedasagar';
  $pass = 'qwertyui';

  $lang = $_GET['lang']; // C++

  $code = $_GET['code'];
  $input = $_GET['input'];


  $run = true;
  $private = false;

  $client = new SoapClient( "http://ideone.com/api/1/service.wsdl" );

//create new submission
$result = $client->createSubmission( $user, $pass, $code, $lang, $input, $run, $private );

//if submission is OK, get the status
if ( $result['error'] == 'OK' ) {

    $status = $client->getSubmissionStatus( $user, $pass, $result['link'] );

    if ( $status['error'] == 'OK' ) {

        //check if the status is 0, otherwise getSubmissionStatus again
        while ( $status['status'] != 0 ) {
            sleep( 3 ); //sleep 3 seconds
            $status = $client->getSubmissionStatus( $user, $pass, $result['link'] );
        }

        //finally get the submission results
        $details = $client->getSubmissionDetails( $user, $pass, $result['link'], true, true, true, true, true );
// var_dump( $details );
         if ( $details['error'] == 'OK' ) {
          if($details['cmpinfo']==''){
              echo '<table border="0">';
              echo '<tr>';
              echo "<td><code>".$details['output']."</code></td>";
              echo '</tr>';
              echo '</table>';
          }
          else{
              echo '<table border="0">';
              echo '<tr>';
              echo "<td><code>".$details['cmpinfo']."</code></td>";
              echo '</tr>';
              echo '</table>';

          }
        } else {
                echo '<table border="0">';
    echo '<tr>';
    echo "<td><code>".$details['error']."</code></td>";
    echo '</tr>';
    echo '</table>';
        }
    } else {
        //we got some error
        var_dump( $status );
    }
} else {
    //we got some error
    var_dump( $result );
}
