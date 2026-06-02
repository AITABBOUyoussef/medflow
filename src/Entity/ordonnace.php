<?php
class ordonnace{
    private int $id;
    private int $rendezVousId;
    private string $contenu;
    public function __construct(
        int $id,
        int $rendezVousId,
        string $contenu
    ){
        $this->id=$id;
        $this->rendezVousId=$rendezVousId;
        $this->contenu=$contenu;
    }
   
}
