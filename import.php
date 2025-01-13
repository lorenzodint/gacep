<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "gacep";


try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}




// ____________________________________________________________________

try {
    $sql = "DELETE FROM c1_anagrafica";


    $stmt = $conn->prepare($sql);


    if ($stmt->execute()) {
    } else {
        echo "errore execuzione query";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

try {
    $sql = "DELETE FROM c2_prestazioni_sanitarie";


    $stmt = $conn->prepare($sql);


    if ($stmt->execute()) {
    } else {
        echo "errore execuzione query";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}



// ____________________________________________________________________________


function import_c1($conn, $filename)
{
    // include('connect.php');
    // require_once('vendor/autoload.php');


    // Definizione delle lunghezze dei campi
    $field_lengths = [3, 3, 6, 16, 30, 20, 16, 16, 1, 8, 6, 3, 2, 20];

    // Apertura del file
    $file = fopen($filename, "r");

    // Lettura del file riga per riga

    if ($file) {



        while (!feof($file)) {

            $line = fgets($file);
            $data = [];
            $start = 0;



            // Estrazione dei campi in base alle lunghezze definite
            foreach ($field_lengths as $length) {
                $data[] = trim(substr($line, $start, $length));
                $start += $length;
            }

            //for ($i = 0; $i < count($field_lengths); $i++) {
            //    $data[] = trim(substr($line, $start, $field_lengths[$i]));
            //    $start += $field_lengths[$i];
            //}



            $dat_1 = str_replace(" ", "", $data[9]);
            if ($data[9] == "00000000" or $dat_1 == "") {
                $date = null;
            } else {
                $date = DateTime::createFromFormat('dmY', $data[9])->format('Y-m-d');
            }



            try {
                $sql = "INSERT INTO c1_anagrafica (regione, az_ulss, erogatore, medico, cognome, nome, filler, codice_fiscale, sesso, data_nascita, prov_com, usl_res, progr_ric, ID)
             VALUES (:data1, :data2, :data3, :data4, :data5, :data6, :data7, :data8, :data9, :data10, :data11, :data12, :data13, :data14)";


                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':data1', $data[0]);
                $stmt->bindParam(':data2', $data[1]);
                $stmt->bindParam(':data3', $data[2]);
                $stmt->bindParam(':data4', $data[3]);
                $stmt->bindParam(':data5', $data[4]);
                $stmt->bindParam(':data6', $data[5]);
                $stmt->bindParam(':data7', $data[6]);
                $stmt->bindParam(':data8', $data[7]);
                $stmt->bindParam(':data9', $data[8]);
                $stmt->bindParam(':data10', $date);
                $stmt->bindParam(':data11', $data[10]);
                $stmt->bindParam(':data12', $data[11]);
                $stmt->bindParam(':data13', $data[12]);
                $stmt->bindParam(':data14', $data[13]);


                if ($stmt->execute()) {
                } else {
                    echo "errore execuzione query";
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
    }


    // Chiusura del file e della connessione al databasex\
    fclose($file);
    // $conn->close();
}





function import_c2_new($conn, $filename)
{
    $spazio = "<br><br>";
    //echo "inizio import c2new" . $spazio;


    // Definizione delle lunghezze dei campi
    $field_lengths = [3, 3, 6, 16, 2, 8, 1, 7, 3, 2, 7, 8, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 20, 3, 2, 3, 1, 6, 1, 8, 8, 8, 20, 8, 8, 8, 1, 1, 8, 2, 1, 3, 8, 8, 8, 1, 4];

    // Apertura del file
    $file = fopen($filename, "r");

    //echo "apro file: " . $filename . $spazio;

    $arrayRecord = array();
    $contRecord = 1;
    $errore = false;


    // Lettura del file riga per riga
    while (!feof($file)) {
        // echo "inizio lettura file" . $spazio;
        // echo "record".$contRecord.$spazio;

        $line = fgets($file);
        $data = [];
        $start = 0;

        $arrayRecord["RECORD: " . strval($contRecord)] = array();
        // echo "array record: ".$spazio;
        // print_r($arrayRecord);
        // echo $spazio;
        // Estrazione dei campi in base alle lunghezze definite
        foreach ($field_lengths as $length) {
            $data[] = trim(substr($line, $start, $length));
            $start += $length;
        }
        // echo "completo foreach field_lengths".$spazio;

        // Controllo la versione del file caricato
        // echo($data[39] . " - " . $data[40] . " - " . $data[41] . " - " . $data[42] . " - " . $data[43] . " - " . $data[44] . " - " .
        // $data[45] . " - " . $data[46] );


        $dat_1 = str_replace(" ", "", $data[5]);
        if ($data[5] == "00000000" or $dat_1 == "") {
            $date = null;
        } else {
            $date = DateTime::createFromFormat('dmY', $data[5])->format('Y-m-d');
        }
        // echo "data 5".$spazio;

        $dat_1 = str_replace(" ", "", $data[34]);
        if ($data[34] == "00000000" or $dat_1 == "") {
            $date1 = null;
        } else {
            $date1 = DateTime::createFromFormat('dmY', $data[34])->format('Y-m-d');
        }
        // echo "data 34".$spazio;


        $dat_1 = str_replace(" ", "", $data[43]);
        if ($data[43] == "00000000" or $dat_1 == "") {
            $date2 = null;
        } else {
            $date2 = DateTime::createFromFormat('dmY', $data[43])->format('Y-m-d');
        }
        // echo "data 43".$spazio;



        $dat_1 = str_replace(" ", "", $data[44]);
        if ($data[44] == "00000000" or $dat_1 == "") {
            $date3 = null;
        } else {
            $date3 = DateTime::createFromFormat('dmY', $data[44])->format('Y-m-d');
        }
        // echo "data 44".$spazio;




        $dat_1 = str_replace(" ", "", $data[45]);
        if ($data[45] == "00000000" or $dat_1 == "") {
            $date4 = null;
        } else {
            $date4 = DateTime::createFromFormat('dmY', $data[45])->format('Y-m-d');
        }
        // echo "data 45".$spazio;


        // Controllo la versione del file caricato
        // echo($data[39] . " - " . $data[40] . " - " . $data[41] . " - " . $data[42] . " - " . $data[43] . " - " . $data[44] . " - " .
        // $data[45] . " - " . $data[46] );

        // echo $spazio;

        if (
            $data[39] == null and $data[40] == null and $data[41] == null and  $data[42] == null and $data[43] == null and
            $data[44] == null and $data[45] == null and $data[46] == null
        ) {
            $data[47] = "2000";
        } else {
            $data[47] = "2024";
        }
        // print_r($data[47]);
        //echo $spazio;
        // echo "inizio controllo errori".$spazio;
        // Controllo campi obbligatori
        if ($data[0] == null) {

            $arrayName = "ERR_COL 1: errore Codice Regione Addebitante mancante!";

            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[1] == null) {
            $arrayName = "ERR_COL 2: errore Codice Azienda Sanitaria inviante mancante!";

            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[2] == null) {
            $arrayName = "ERR_COL 3: errore Codice Struttura Erogatrice mancante!";

            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[3] == null) {
            $arrayName = "ERR_COL 4: errore Numero Ricetta mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[4] == null) {
            $arrayName = "ERR_COL 5: errore Progressivo Riga Ricetta mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[5] == null and $data[4] != "99") {
            $arrayName = "ERR_COL 6: errore Data Prestazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[6] == null and $data[4] != "99") {
            $arrayName = "ERR_COL 7: errore Codice Nomenclatura mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[7] == null and $data[4] != "99") {
            $arrayName = "ERR_COL 8: errore Codice Prestazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[8] == null) {
            $arrayName = "ERR_COL 9: errore Quantità Prestazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[9] == null and $data[25] == "S" and $data[4] == "99") {
            $arrayName = "ERR_COL 10: errore Posizione Utente (Esente, Non Esente) mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[10] == null) {
            $arrayName = "ERR_COL 11: errore Importo Ticket mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[11] == null) {
            $arrayName = "ERR_COL 12: errore Importo Totale mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[12] == null) {
            $arrayName = "ERR_COL 13: errore Posizione Contabile mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[23] == null) {
            $arrayName = "ERR_COL 24: errore Identificativo mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[24] == null and $data[12] == "3") {
            $arrayName = "ERR_COL 25: errore Regione Iniziale Addebito mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[25] == null) {
            $arrayName = "ERR_COL 26: errore Tipo Erogazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[27] == null) {
            $arrayName = "ERR_COL 28: errore Classe di Propietà mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[28] == null and $data[9] == "01" and $data[25] == "S" and $data[4] == "99") {
            $arrayName = "ERR_COL 29: errore Codice Esenzione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[29] == null) {
            $arrayName = "ERR_COL 30: errore Tipo Struttura mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[31] == null) {
            $arrayName = "ERR_COL 32: errore Fatturato Lordo mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[33] == null) {
            $arrayName = "ERR_COL 34: errore Numero della Fattura mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[34] == null) {
            $arrayName = "ERR_COL 35: errore Data Fattura mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[35] == null) {
            $arrayName = "ERR_COL 36: errore Fatturato Netto mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);

            //  in attesa di conferma da parte di Mauro
            //} else if ($data[36] == null) {
            //    $arrayName = "ERR_COL 37: errore Liquidato mancante!";
            //    array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
            //} else if ($data[37] == null) {
            //    $arrayName = "ERR_COL 38: errore Causa Mancata Liquidazione mancante!";
            //    array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
            //} else if ($data[38] == null) {
            //    $arrayName = "ERR_COL 39: errore Causa di Parziale Liquidazione mancante!";
            //    array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[39] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 40: errore Codice Prestazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[40] == null and $data[47] == "2024" and $data[4] != "99") {
            $arrayName = "ERR_COL 41: errore Branca Specialistica mancante!" . $data[40];
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[41] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 42: errore Garanzia Tempi Max mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[42] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 43: errore Numero Sedute Cicli mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[43] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 44: errore Data Prenotazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[44] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 45: errore Data 1° Disponibilità mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[45] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 46: errore Data 1° Appuntamento mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        } else if ($data[46] == null and $data[47] == "2024") {
            $arrayName = "ERR_COL 47: errore Tipo Prenotazione mancante!";
            array_push($arrayRecord["RECORD: " . strval($contRecord)], $arrayName);
        }

        // Se il formato è precedente al 2024 pone i nuovi campi obbligatori a 0

        if (
            $data[47] == "2024"
        ) {
            $data[39] = "XXX";
            $data[40] = "XX";
            $data[41] = "X";
            $data[42] = "XXX";
            $data[43] = "01011900";
            $data[44] = "01011900";
            $data[45] = "01011900";
            $data[46] = "X";
        }

        foreach ($arrayRecord as $record) {
            if (count($record) != 0) {
                $errore = true;
                break;
            }
        }



        $contRecord += 1;
    }


    if ($errore == true) {

        fclose($file);

        return $arrayRecord;
        exit;

        // Chiusura del file e della connessione al databasex\
        // fclose($file);
    } else {
        // Chiusura del file e della connessione al databasex\
        // fclose($file);
        fclose($file);

        return "NO";
    }



    // if (controllo($arrayErr)){

    // }else{
    //     write_err("percorsi file", $arrayErr)
    // }


    // Chiusura del file e della connessione al databasex\
    // fclose($file);
    // $conn->close();
}


$risult = import_c2_new($conn, "./filePrestazioni/fileC2");
echo json_encode($risult);
