<?php
/**
 * @package X4BlueprintOptimizer
 * @subpackage UserInterface
 */

declare(strict_types=1);

use Mistralys\X4\BlueprintOptimizer;
use Mistralys\X4\UI\UserInterface;

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';

try {
    $app = new BlueprintOptimizer(X4_BLUEPRINTS_PATH);
    $app->createUI(X4_APP_URL)->display();
}
catch (\AppUtils\BaseException $e)
{
    UserInterface::displayException($e);
}
