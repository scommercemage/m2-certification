<?php

namespace Scommerce\Popular\Model\Indexer;

use Magento\Framework\Mview\ActionInterface;

/**
 * Class Popular
 * @package Scommerce\Popular\Model\Indexer
 */
class Popular implements \Magento\Framework\Indexer\ActionInterface, ActionInterface
{
    /*
     * Used by mview, allows process indexer in the "Update on schedule" mode
     */
    public function execute($ids)
    {
        //Used by mview, allows you to process multiple placed orders in the "Update on schedule" mode
    }

    /*
     * Will take all of the data and reindex
     * Will run when reindex via command line
     */
    public function executeFull()
    {
        //Should take into account all placed orders in the system
    }

    /*
     * Works with a set of entity changed (may be massaction)
     */
    public function executeList(array $ids)
    {
        //Works with a set of placed orders (mass actions and so on)
    }

    /*
     * Works in runtime for a single entity using plugins
     */
    public function executeRow($id)
    {
        //Works in runtime for a single order using plugins
    }
}
