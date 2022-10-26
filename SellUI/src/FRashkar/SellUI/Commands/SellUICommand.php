<?php

namespace FRashkar\SellUI\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\plugin\PluginOwned;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

use FRashkar\SellUI\Main;

class SellUICommand extends Command {
    
    private Main $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct("sellui", "Sellui command", "/sellui", ["sui"]);
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Please use it in-game!");
        }else{
            $this->getOwningPlugin()->openSellUI($sender);
            $sender->sendMessage(TextFormat::GREEN . "Open SellUI");
        }
        return true;
    }
    
    public function getOwningPlugin() : Main {
        return $this->main;
    }
 }
