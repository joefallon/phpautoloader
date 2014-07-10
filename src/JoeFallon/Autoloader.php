<?php
/**
 * @author    Joseph Fallon <joseph.t.fallon@gmail.com>
 *
 * @copyright Copyright 2014 Joseph Fallon (All rights reserved)
 *
 * @license   MIT
 */
namespace JoeFallon;

class Autoloader
{
    /** @var string */
    private $_classFilename;
    /** @var string[] */
    private $_includePaths;


    /**
     * registerAutoLoad - Call this method to start the autoloader.
     */
    public static function registerAutoLoad()
    {
        $autoLoader = new AutoLoader();
        spl_autoload_register(array($autoLoader, 'load'));
    }


    /**
     * load
     *
     * @param string $className
     * @return bool
     */
    public function load($className)
    {
        $this->_classFilename = $className . '.php';
        $this->_includePaths  = explode(PATH_SEPARATOR, get_include_path());
        $classFound           = null;

        if(strpos($this->_classFilename, '\\') !== false)
        {
            $classFound = $this->searchForBackslashNamespacedClass();
            if($classFound) { return true; }
        }
        elseif(strpos($this->_classFilename, '_') !== false)
        {
            $classFound = $this->searchForUnderscoreNamespacedClass();
            if($classFound) { return true; }
        }
        else
        {
            $classFound = $this->searchForNonNamespacedClass();
            if($classFound) { return true; }
        }

        return false;
    }


    /**
     * searchForNonNamespacedClass
     *
     * @return bool
     */
    protected function searchForNonNamespacedClass()
    {
        $filename = $this->_classFilename;

        // Search through the include paths for the file.
        foreach($this->_includePaths as $includePath)
        {
            $filePath = $includePath . DIRECTORY_SEPARATOR . $filename;

            if(file_exists($filePath))
            {
                require($filename);
                return true;
            }
        }

        return false;
    }


    /**
     * searchForUnderscoreNamespacedClass
     *
     * @return boolean
     */
    protected function searchForUnderscoreNamespacedClass()
    {
        $filename = $this->_classFilename;

        foreach($this->_includePaths as $includePath)
        {
            $className = str_replace('_', '/', $filename);
            $filePath  = $includePath . DIRECTORY_SEPARATOR . $className;

            if(file_exists($filePath))
            {
                require($filePath);
                return true;
            }
        }

        return false;
    }


    /**
     * searchForBackslashNamespacedClass
     *
     * @return boolean
     */
    protected function searchForBackslashNamespacedClass()
    {
        $filename = $this->_classFilename;

        foreach($this->_includePaths as $includePath)
        {
            $className = str_replace('\\', '/', $filename);
            $filePath  = $includePath . DIRECTORY_SEPARATOR . $className;

            if(file_exists($filePath))
            {
                require($filePath);
                return true;
            }
        }

        return false;
    }
}
