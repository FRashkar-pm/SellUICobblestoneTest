<?php

namespace FRashkar\SellUI;

use pocketmine\block\VanillaBlocks;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\VanillaItems;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\PlayerInventory;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use FRashkar\SellUI\Commands\SellUICommand;
use Vecnavium\FormsUI\SimpleForm;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase
{

    public function onEnable() : void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if ($this->getEconomyAPI() === null){
            $this->getLogger()->emergency("There are no EconomyAPI plugin.");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
        $this->getServer()->getCommandMap()->register("sellui", new SellUICommand($this));
        $this->getLogger()->info("Plugin Actived!");
        $this->saveDefaultConfig();
        
    }

    public function getEconomyAPI() : ?EconomyAPI
    {
        if ($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") !== null){
            return EconomyAPI::getInstance();
        }
        return null;
    }
    
    public function openSellUI(Player $player)
    {
        $form = new SimpleForm(function(Player $player, int $result = null) : void {
            if ($result === null){
                return;
            }
            // Button 1
            if ($result === 0){
                
                // Get item in hand
                $item = $player->getInventory()->getItemInHand();

                $price = $this->getConfig()->get("price"); // 1 cobblestone = 0.1 money

                // Total item
                $total = $item->getCount() * $price;

                // Give money to player 
                $this->getEconomyAPI()->addMoney($player, $total);

                // Send message to player
                $player->sendMessage("You have recieved $ " . $total . " for selling Cobblestone x" . $item->getCount());

                // Reset item
                $player->getInventory()->setItemInHand(VanillaItems::AIR());
                
            }});

        $item = $player->getInventory()->getItemInHand();

        if ($item->getTypeId() !== VanillaBlocks::COBBLESTONE()->asItem()->getTypeId()){
            $player->sendMessage("You can only sell cobblestone!");
            return;
        }

        // Form
        $form->setTitle( title: "Sell UI");
        $form->setContent( content: "Do you want to sell cobblestone x" . $item->getCount() . " ?");
        $form->addButton(TextFormat::GOLD . "Sell now!", 0, "textures/blocks/cobblestone");

        // Send form to player
        $player->sendForm($form);
    }
}
