<?php

namespace Doomsday;

class Scenario {

    protected $missileCount;

    protected $asteroid;

    protected $missiles = ['Doudou', 'Jc', 'Pierre'];

    protected $history;

    public function __construct(){
        $this->missileCount = 15;
        $this->asteroid = new Asteroid;
        $this->history = [];
    }

    public function run($sequence = null){
        if(is_null($sequence) || !is_array($sequence)){
            $sequence = $this->generateSequence();
        }
        do {
            $missileName = array_shift($sequence);
            $fullMissileName = "\\Doomsday\\Missile\\" . $missileName;
            $missile = new $fullMissileName;

            $result = $this->asteroid->sendMissile($missile);
            $this->history[] = [$missileName, $result, $this->asteroid->getHp()];
            $this->missileCount--;

        } while ($this->canContinue());
        return $this->output($this->asteroid->isKo(), $this->history);
    }

    protected function canContinue(){
        return $this->missileCount > 0 && !$this->asteroid->isKo();
    }

    protected function generateSequence(){
        $seq = [];
        do {
            $seq[] = $this->missiles[array_rand($this->missiles)];
        } while (count($seq) < 15);

        return $seq;
    }

    protected function output($result, $history){
        $html = [];
        $html[] = '<div id="resultimage"><img src="img/'.($result ? 'win' : 'lose').'.jpg" height="400"/></div><hr/>';
        if($result){
            $html[] = '<h1>'.count($history).' Runs</h1>';
        }
        $html[] = '<table>';
        $html[] = '<tr><th>Run</th>';
        for($i = 1; $i <= count($history); $i++){
            $html[] = "<th>#{$i}</th>";
        }
        $html[] = '</tr>';
        $html[] = '<tr><th>Missile used</th>';
        foreach($history as $entry){
            $html[] = "<td>{$entry[0]}</td>";
        }
        $html[] = '</tr>';
        $html[] = '<tr><th>Result</th>';
        foreach($history as $entry){
            $html[] = '<td class="'.($entry[1] ? "success" : "failure").'">'.($entry[1] ? 'HIT' : 'MISS').'</td>';
        }
        $html[] = '</tr>';
        $html[] = '<tr><th>Remaining HP</th>';
        foreach($history as $entry){
            $html[] = "<td>".max($entry[2], 0)."</td>";
        }
        $html[] = '</tr>';
        $html[] = '</table>';

        $successCount = count(array_filter($history, function($h){return ($h[1] == true);}));
        $pcSuccess = round($successCount / count($history) * 100 * 100) / 100;

        $html[] = '<h2>'.$pcSuccess.'% success</h2>';

        $html = implode("\n", $html);

        return $html;
    }
}