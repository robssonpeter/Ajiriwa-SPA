<?php
namespace App\Custom;

use OpenAI;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AI{
    public static function ask($question){
        $scriptPath = '/var/www/node_projects/google-gemini/index.js';
        $nodePath = exec('which node');
        
        
        $process = new Process([$nodePath, $scriptPath, $question]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return ['output' => $process->getOutput()];

        exec("$nodePath $scriptPath '$question'", $output, $retval);

        if ($retval == 0) {
            return ['output' => $output];
        } else {
            return ['error' => 'Node script execution failed'];
        }
    }
}