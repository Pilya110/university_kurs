<?php
/**
 * Base model
 * Class for load container to slim app
 * This class is a interface for loading the model from namespace
 *
 * @package pageBuilder
 * @author I.L.Konev aka Krox
 */
namespace core\ifaces;

class Model
{
    /**
     * @var slim app
     */
    private $app;

    /**
     * @var Models namespace
     */
    public $modelsNameSpace = "\\core\\models\\";

    /**
     * Constructor
     *
     * @param slim $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Getter of model class
     *
     * @param mixed
     * @return model class by name
     */
    public function __get($v)
    {
        if (!$v) {
            return;
        }
        $v = ucfirst($v);
        $model = $this->modelsNameSpace . $v;
        if (!class_exists($model)) {
            throw new \RuntimeException('Model file is not found ' . $model, 1);
        }
        $m = new $model($this->app);
        return $m;
    }
}
