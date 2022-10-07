<?php


interface InterfaceTypeArchive
{
    public function addFile();
    public function addFolder();
    public function save();
    public function getFileName();

}

class ZipArchive implements InterfaceTypeArchive {

}

class RarArchive implements InterfaceTypeArchive {

}

class TarArchive implements InterfaceTypeArchive {

}

class Archive
{
    protected $engine;

    /**
     * Archive constructor.
     *
     * @param InterfaceTypeArchive $engine
     */
    public function __construct(InterfaceTypeArchive $engine)
    {
        $this->engine = $engine;
    }

    public function pack()
    {
        $this->engine->addFile();
        $this->engine->addFolder('...');
        $this->engine->save();
        return $this->engine->getFileName();
    }

    public function unpack()
    {
        $this->engine->unzip('...');
    }
}

class application {

    public function run()
    {

        $arch = new Archive(new RarArchive());
        //$arch = new Archive(new RarArchive());
        //$arch = new Archive(new TarArchive());
        //$arch = new Archive(new 7ZipArchive());
        $arch->pack();


        //.....

        $arch->unpack();

    }
}

$app = new application();
$app->run();

class DatabaseConfiguration
{
    public function getUser()
    {

    }
    public function getHost()
    {

    }
    public function getPassword()
    {

    }
    public function getName()
    {

    }
}

class DatabaseConnection
{

    public function __construct(DatabaseConfiguration $config)
    {
        //new PDO($config->getUser() . ':' . $config->getPassword());
    }
}
























