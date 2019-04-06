<?php
namespace PoconoSewVac\FormulaShipping\Modules;
use modmore\Commerce\Modules\BaseModule;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

class FormulaShipping extends BaseModule {

    public function getName()
    {
        $this->adapter->loadLexicon('commerce_formulashipping:default');
        return $this->adapter->lexicon('commerce_formulashipping');
    }

    public function getAuthor()
    {
        return 'Tony Klapatch';
    }

    public function getDescription()
    {
        return $this->adapter->lexicon('commerce_formulashipping.description');
    }

    public function initialize(EventDispatcher $dispatcher)
    {
        // Load our lexicon
        $this->adapter->loadLexicon('commerce_formulashipping:default');

        // Add the xPDO package, so Commerce can detect the derivative classes
        $root = dirname(dirname(__DIR__));
        $path = $root . '/model/';
        $this->adapter->loadPackage('commerce_formulashipping', $path);
    }

    public function getModuleConfiguration(\comModule $module)
    {
        $fields = [];
        return $fields;
    }
}
