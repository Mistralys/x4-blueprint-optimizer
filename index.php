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

$ui = new UserInterface(new BlueprintOptimizer(X4_BLUEPRINTS_PATH));
$ui->display();
