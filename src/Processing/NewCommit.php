<?php

namespace WriteLabel\Processing;

use App\Board;

use Log;
use App\Models\User;

class NewCommit
{

    public function __construct(Board $board)
    {
        
    }

    
    
    public function run(): void
    {
        $this->forIntegrations();
    }
    
    public function forIntegrations(): void
    {
        $selfClass = $this;
        $this->board->executeForEachIntegration(
            function ($integration) use ($selfClass) {
                $selfClass->forComponents($integration);
            }
        );
    }
    
    
    public function forComponents($integration): void
    {
        $selfClass = $this;
        $this->board->executeForEachComponent(
            function ($component, $callback) use ($integration) {
                $data = $integration->getNewDataForComponent($component);
                foreach($data as $result) {
                    $callback($result);
                }
            }
        );
    }

}
