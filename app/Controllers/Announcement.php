<?php
namespace App\Controllers;

class Announcement extends BaseController{
  public function index($id = false){
    if($id){
      $announcement = $this->announcementModel->find($id);
      $title = $announcement["TITLE"];
      $createdAt = $announcement["CREATED_AT"];
      $content = $announcement['CONTENT'];

      $data = [
        'pageTitle' => "Announcement",
        'title' => $title,
        'createdAt' => $createdAt,
        'content' => $content,
      ];
      echo view("announcement/header.php",$data);
      echo view("announcement/body.php", $data);
      echo view("announcement/footer.php");
    }
  }

  public function get(){
    header("Content-type:application/json");

    $response = $this->announcementModel->orderBy("CREATED_AT DESC")->findAll();

    return $this->setResponseFormat('json')->respond($response, 200);
  }
}
