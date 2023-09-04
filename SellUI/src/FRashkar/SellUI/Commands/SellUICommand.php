<?php

namespace FRashkar\SellUI\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use FRashkar\SellUI\Main;

class SellUICommand extends Command implements PluginOwned
{
    
    public function __construct(private Main $main)
    {
        $this->main = $main;
        parent::__construct("sellui", "Sellui command", "/sellui", ["sui"]);
        $this->setPermission("sellui.command");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::RED . "Please use it in-game!");
        } else {
            $this->getOwningPlugin()->openSellUI($sender);
        }
        return true;
    }
    
    public function getOwningPlugin() : Main
    {
        return $this->main;
    }
 }
