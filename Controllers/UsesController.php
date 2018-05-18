<?php

class UsesController
{    
    public function insertLangAndFwForJob($jobId, $pdo) {
        $tc = new TechnologyController();
        
        $language = $tc->getLang();
        
        $this->insertUsesForJobAndLang($jobId, $language, $pdo);
        //SQL and Scratch do not have frameworks associated with them
        if($language != "SQL" && $language != "Scratch") {
            $this->insertUsesForJobAndFW($jobId, $pdo, $language);
        }
    }
    
    private function insertUsesForJobAndLang($jobId, $language, $pdo) {
        $usesTuple = $this->getUsesTupleForLang($language, $jobId, $pdo);
        $this->insertUses($usesTuple, $pdo);
    }
    
    private function getUsesTupleForLang($language, $jobId, $pdo) {
        $tc = new TechnologyController();
        
        $techId = $tc->queryTechnologyId($language, $pdo);
        $usesTuple = new Uses($techId, $jobId);
        $usesTuple->language = $language;
        
        return $usesTuple;
    }
    
    private function insertUsesForJobAndFW($jobId, $pdo, $language) {
        $tc = new TechnologyController();
        
        $framework = $tc->getRandomFWForLang($language);
        $usesTuple = $this->getUsesTupleForFW($framework, $jobId, $pdo);
        $this->insertUses($usesTuple, $pdo);
    }
    
    private function getUsesTupleForFW($framework, $jobId, $pdo) {
        $tc = new TechnologyController();
        
        $techId = $tc->queryTechnologyId($framework, $pdo);
        $usesTuple = new Uses($techId, $jobId);
        
        return $usesTuple;
    }
    
    private function insertUses($uses, $pdo)
    {
        $dbc = new DbController();
        $dbc->insertUsesTuple($uses, $pdo);
    }
}

