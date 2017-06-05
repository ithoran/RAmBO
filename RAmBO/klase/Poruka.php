<?php

/* CREATE TABLE poruka(
  ID int PRIMARY KEY AUTO_INCREMENT,
  CONTENT text,
  OBJAVA_ID int,
  SENDER_ID int,
  RECEIVER_ID int,
  VREME datetime,
  `READ` int,
  FOREIGN KEY (SENDER_ID) REFERENCES korisnik(ID),
  FOREIGN KEY (RECEIVER_ID) REFERENCES korisnik(ID),
  FOREIGN KEY (OBJAVA_ID) REFERENCES objava(ID)
  ); */

class Poruka {

    var $id;
    var $content;
    var $vreme;
    var $read;
    var $objava_id;
    var $sender_id;
    var $receiver_id;

    public function __construct($id, $content, $vreme, $read, $objava_id,$sender_id,$receiver_id) {
        
        $this->id=$id;
        $this->content=$content;
        $this->vreme=$vreme;
        $this->read=$read;
        $this->objava_id=$objava_id;
        $this->sender_id=$sender_id;
        $this->receiver_id=$receiver_id;
        
        
    }

}
