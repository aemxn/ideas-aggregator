<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /** Inserts data source to DB */
    public function insertDataSourceToDb($data = array()) {

      if ($data) {
      	$i = 0;
        foreach($data as $data_) {
          $remote_id = $data_['id'];
          $title = $data_['title'];
          $author = $data_['author'];
          $url = $data_['url'];
          $metadata = serialize($data_['metadata']);

          $stmt = $this->conn->prepare("INSERT INTO ideas (remote_id, title, author, url, metadata) values(?, ?, ?, ?, ?)");
		  // if ( false===$stmt ) die('prepare() failed at: '. $i . ' ' . htmlspecialchars($this->conn->error));
          $rc = $stmt->bind_param("sssss", $remote_id, $title, $author, $url, $metadata);
		  // if ( false===$rc ) die('bind_param() failed at: '. $i . ' ' . htmlspecialchars($stmt->error));
          $result = $stmt->execute();
		  // if ( false===$result ) die('execute() failed at: '. $i . ' ' . htmlspecialchars($stmt->error));

          $stmt->close();
          $i++;
        }
        return array('object' => 'insertDataSourceToDb', 'status' => 1, 'message' => 'OK');
      } else {
        return array('object' => 'insertDataSourceToDb', 'status' => 0, 'message' => 'No object supplied');
      }
    }
}