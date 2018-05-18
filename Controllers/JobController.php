<?php

class JobController
{
    function insertNewJob($jobId, $zip, $pdo)
    {
        $job = new Job($zip, $jobId);
        
        $dbc = new DbController();
        $dbc->insertJobTuple($job, $pdo);
        
    }
}

