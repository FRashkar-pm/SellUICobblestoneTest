<?php

namespace FRashkar\SellUI\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SellUICommand extends Command {

    public function __construct()
    {
        parent::__construct("sellui", "Sellui command", "/sellui", ["sui"]);
    }
 }
